<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class OrderService
{
    /**
     * Получить заказ по UUID
     *
     * @param string $uuid
     *
     * @return Model|null
     */
    public function getByUuid(string $uuid): ?Model
    {
        return Order::with('orderProducts')
            ->firstWhere('uuid', $uuid);
    }

    /**
     * Получить заказы пользователя
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Order::where('user_id', auth('sanctum')->id())->get();
    }

    /**
     * Создать заказ
     *
     * @param array $data
     *
     * @return string
     */
    public function make(array $data): string
    {
        /** @var User $user */
        $user = auth('sanctum')->user();

        $order = Order::create([
            'uuid' => Str::uuid(),
            'email' => $data['email'] ?? $user->email,
            'phone' => $data['phone'] ?? $user->phone,
            'user_id' => $user->id ?? null,
        ]);

        foreach (Cart::firstWhere('uuid', $data['cart_uuid'])->products as $product) {
            OrderProduct::create([
                'name' => $product->name,
                'price_raw' => $product->price,
                'number' => $product->pivot->number,
                'order_id' => $order->id,
            ]);
        }

        return $order->uuid;
    }
}

<?php

namespace App\Services;

use App\Models\Cart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CartService
{
    /**
     * Получить корзину по UUID
     *
     * @param string $uuid
     *
     * @return Model|null
     */
    public function getByUuid(string $uuid): ?Model
    {
        return Cart::with('products')
            ->firstWhere('uuid', $uuid);
    }

    /** Установить количество товара в корзине
     *
     * @param array $data
     *
     * @return string UUID корзины
     */
    public function edit(array $data): string
    {
        if (isset($data['uuid'])) {
            $cart = Cart::firstWhere('uuid', $data['uuid']);
        } else {
            $cart = Cart::create(['uuid' => Str::uuid()]);
        }

        foreach ($data['products'] as $product) {
            $cart->products()
                ->syncWithPivotValues($product['id'], [
                    'number' => $product['number'],
                ], false);
        }

        return $cart->uuid;
    }

    /** Удалить товар из корзины
     *
     * @param array $data
     *
     * @return string UUID корзины
     */
    public function delete(array $data): string
    {
        $cart = Cart::firstWhere('uuid', $data['uuid']);
        $cart->products()->detach($data['products']);

        return $cart->uuid;
    }
}

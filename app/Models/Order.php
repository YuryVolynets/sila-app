<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * Заказ
 *
 * @mixin Builder
 * @property-read int                          $id            ID заказа
 * @property string                            $uuid          UUID заказа
 * @property string                            $email         Email пользователя
 * @property string                            $phone         Номер телефона пользователя
 * @property int                               $user_id       ID пользователя
 * @property-read User                         $user          Пользователь
 * @property-read Collection<int,OrderProduct> $orderProducts Товары заказа
 * @property-read Carbon|null                  $created_at
 * @property-read Carbon|null                  $updated_at
 * @method static Order create(array $attributes = [])
 * @method static Order|null firstWhere($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 */
class Order extends Model
{
    protected $fillable = [
        'uuid',
        'email',
        'phone',
        'user_id',
    ];

    /**
     * Пользователь
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Товары заказа
     *
     * @return HasMany
     */
    public function orderProducts(): HasMany
    {
        return $this->hasMany(OrderProduct::class);
    }

    /**
     * Сериализация в JSON
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        $products = [];
        foreach ($this->orderProducts as $product) {
            $products[] = [
                'name' => $product->name,
                'price' => $product->price,
                'number' => $product->number,
            ];
        }
        return [
            'uuid' => $this->uuid,
            'email' => $this->email,
            'phone' => $this->phone,
            'products' => $products,
        ];
    }
}

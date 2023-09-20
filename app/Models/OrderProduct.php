<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Товар заказа
 *
 * @mixin Builder
 * @property-read int         $id        ID товара заказа
 * @property string           $name      Название товара
 * @property int              $price_raw Цена товара, коп.
 * @property int|float        $price     Цена товара, руб.
 * @property string           $number    Количество товара
 * @property int              $order_id  ID заказа
 * @property-read Order       $order     Заказ
 * @property-read Carbon|null $created_at
 * @property-read Carbon|null $updated_at
 * @method static OrderProduct create(array $attributes = [])
 */
class OrderProduct extends Model
{
    protected $fillable = [
        'name',
        'price_raw',
        'number',
        'order_id',
    ];

    protected $appends = [
        'price',
    ];

    protected $hidden = [
        'price_raw',
    ];

    /**
     * Заказ
     *
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Цена в рублях
     *
     * @return float|int
     */
    public function getPriceAttribute(): float|int
    {
        return $this->price_raw / 100;
    }
}

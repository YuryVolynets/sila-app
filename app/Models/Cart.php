<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * Корзина
 *
 * @mixin Builder
 * @property-read int                     $id       ID корзины
 * @property string                       $uuid     UUID корзины
 * @property-read Collection<int,Product> $products Товары
 * @property-read Carbon|null             $created_at
 * @property-read Carbon|null             $updated_at
 * @method static Cart create(array $attributes = [])
 * @method static Cart|null firstWhere($column, $operator = null, $value = null, $boolean = 'and')
 */
class Cart extends Model
{
    protected $fillable = [
        'uuid',
    ];

    /**
     * Товары
     *
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('number')
            ->withTimestamps();
    }

    /**
     * Сериализация в JSON
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        $products = [];
        foreach ($this->products as $product) {
            $products[] = [
                'id' => $product->id,
                'number' => $product->pivot->number,
            ];
        }
        return [
            'uuid' => $this->uuid,
            'products' => $products,
        ];
    }
}

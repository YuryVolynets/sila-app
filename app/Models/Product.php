<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * Товар
 *
 * @mixin Builder
 * @property-read int                  $id          ID товара
 * @property string                    $name        Название товара
 * @property string|null               $description Описание товара
 * @property string                    $slug        ЧПУ товара
 * @property int                       $price_raw   Цена товара, коп.
 * @property int|float                 $price       Цена товара, руб.
 * @property int|null                  $length_raw  Длина, мм
 * @property int|float|null            $length      Длина, см
 * @property int|null                  $width_raw   Ширина, мм
 * @property int|float|null            $width       Ширина, см
 * @property int|null                  $height_raw  Высота, мм
 * @property int|float|null            $height      Высота, см
 * @property int|null                  $weight_raw  Масса, г
 * @property int|float|null            $weight      Масса, кг
 * @property int                       $folder_id   ID категории
 * @property-read Folder               $folder      Категория
 * @property-read Collection<int,Cart> $carts       Корзины
 * @property-read Carbon|null          $created_at
 * @property-read Carbon|null          $updated_at
 * @method static Product firstWhere($column, $operator = null, $value = null, $boolean = 'and')
 */
class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'slug',
        'price_raw',
        'length_raw',
        'width_raw',
        'height_raw',
        'weight_raw',
        'folder_id',
    ];

    protected $appends = [
        'price',
        'length',
        'width',
        'height',
        'weight',
    ];

    protected $hidden = [
        'price_raw',
        'length_raw',
        'width_raw',
        'height_raw',
        'weight_raw',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    /**
     * Категория
     *
     * @return BelongsTo
     */
    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }

    /**
     * Корзины
     *
     * @return BelongsToMany
     */
    public function carts(): BelongsToMany
    {
        return $this->belongsToMany(Cart::class)
            ->withPivot('number')
            ->withTimestamps();
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

    /**
     * Длина, см
     *
     * @return float|int
     */
    public function getLengthAttribute(): float|int
    {
        return $this->length_raw / 10;
    }

    /**
     * Ширина, см
     *
     * @return float|int
     */
    public function getWidthAttribute(): float|int
    {
        return $this->width_raw / 10;
    }

    /**
     * Высота, см
     *
     * @return float|int
     */
    public function getHeightAttribute(): float|int
    {
        return $this->height_raw / 10;
    }

    /**
     * Вес, кг
     *
     * @return float|int
     */
    public function getWeightAttribute(): float|int
    {
        return $this->weight_raw / 1000;
    }

    /**
     * Фильтр по категориям
     *
     * @param Builder    $query
     * @param Collection $folderId
     *
     * @return Builder
     */
    public function scopeFolderId(Builder $query, Collection $folderId): Builder
    {
        return $query->whereIn('folder_id', $folderId);
    }

    /**
     * Фильтр по минимальной цене
     *
     * @param Builder   $query
     * @param int|float $priceMin
     *
     * @return Builder
     */
    public function scopePriceMin(Builder $query, int|float $priceMin): Builder
    {
        return $query->where('price_raw', '>=', $priceMin * 100);
    }

    /**
     * Фильтр по максимальной цене
     *
     * @param Builder   $query
     * @param int|float $priceMax
     *
     * @return Builder
     */
    public function scopePriceMax(Builder $query, int|float $priceMax): Builder
    {
        return $query->where('price_raw', '<=', $priceMax * 100);
    }

    /**
     * Фильтр по минимальной длине
     *
     * @param Builder   $query
     * @param int|float $lengthMin
     *
     * @return Builder
     */
    public function scopeLengthMin(Builder $query, int|float $lengthMin): Builder
    {
        return $query->where('length_raw', '>=', $lengthMin * 10);
    }

    /**
     * Фильтр по максимальной длине
     *
     * @param Builder   $query
     * @param int|float $lengthMax
     *
     * @return Builder
     */
    public function scopeLengthMax(Builder $query, int|float $lengthMax): Builder
    {
        return $query->where('length_raw', '<=', $lengthMax * 10);
    }

    /**
     * Фильтр по минимальной ширине
     *
     * @param Builder   $query
     * @param int|float $widthMin
     *
     * @return Builder
     */
    public function scopeWidthMin(Builder $query, int|float $widthMin): Builder
    {
        return $query->where('width_raw', '>=', $widthMin * 10);
    }

    /**
     * Фильтр по максимальной ширине
     *
     * @param Builder   $query
     * @param int|float $widthMax
     *
     * @return Builder
     */
    public function scopeWidthMax(Builder $query, int|float $widthMax): Builder
    {
        return $query->where('width_raw', '<=', $widthMax * 10);
    }

    /**
     * Фильтр по минимальной высоте
     *
     * @param Builder   $query
     * @param int|float $heightMin
     *
     * @return Builder
     */
    public function scopeHeightMin(Builder $query, int|float $heightMin): Builder
    {
        return $query->where('height_raw', '>=', $heightMin * 10);
    }

    /**
     * Фильтр по максимальной высоте
     *
     * @param Builder   $query
     * @param int|float $heightMax
     *
     * @return Builder
     */
    public function scopeHeightMax(Builder $query, int|float $heightMax): Builder
    {
        return $query->where('height_raw', '<=', $heightMax * 10);
    }

    /**
     * Фильтр по минимальной массе
     *
     * @param Builder   $query
     * @param int|float $weightMin
     *
     * @return Builder
     */
    public function scopeWeightMin(Builder $query, int|float $weightMin): Builder
    {
        return $query->where('weight_raw', '>=', $weightMin * 1000);
    }

    /**
     * Фильтр по максимальной массе
     *
     * @param Builder   $query
     * @param int|float $weightMax
     *
     * @return Builder
     */
    public function scopeWeightMax(Builder $query, int|float $weightMax): Builder
    {
        return $query->where('weight_raw', '<=', $weightMax * 1000);
    }
}

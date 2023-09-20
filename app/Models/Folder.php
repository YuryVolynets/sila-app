<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * Категория
 *
 * @property-read int                     $id                      ID категории
 * @property string                       $name                    Название категории
 * @property int|null                     $parent_id               ID родительской категории
 * @property-read Folder                  $parent                  Родительская категория
 * @property-read Collection<int,Folder>  $children                Дочерние категории
 * @property-read Collection<int,Folder>  $childrenWithDescendants Дочерние категории с потомками
 * @property-read Collection<int,Product> $products                Товары
 * @property-read Carbon|null             $created_at
 * @property-read Carbon|null             $updated_at
 */
// todo проверить тип $parent
class Folder extends Model
{
    protected $fillable = [
        'name',
        'parent_id',
    ];

    /**
     * Родительская категория
     *
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Folder::class, 'parent_id', 'id');
    }

    /**
     * Дочерние категории
     *
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(Folder::class, 'parent_id', 'id');
    }

    /**
     * Дочерние категории с потомками
     *
     * @return HasMany
     */
    public function childrenWithDescendants(): HasMany
    {
        return $this->children()->with('childrenWithDescendants');
    }

    /**
     * Товары
     *
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Сериализация в JSON
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'children' => $this->childrenWithDescendants,
        ];
    }

    /**
     * Получить дерево категорий
     *
     * @return Collection<int,Folder>
     */
    public static function getTree(): Collection
    {
        return Folder::with('childrenWithDescendants')
            ->whereNull('parent_id')
            ->get();
    }

    /**
     * Получить ID дочерних категорий
     *
     * @return Collection
     */
    public static function getDescendantsIds(): Collection
    {
        $result = Collection::empty();

        foreach (self::getTree() as $folder) {
            $folder->fillDescendantsIds($result);
        }

        return $result;
    }

    /**
     * Найти ID дочерних категорий
     *
     * @param Collection $result
     *
     * @return Collection
     */
    private function fillDescendantsIds(Collection &$result): Collection
    {
        $ids = collect([$this->id]);
        foreach ($this->childrenWithDescendants as $child) {
            $ids = $ids->merge($child->fillDescendantsIds($result));
        }

        $result->put($this->id, $ids);

        return $ids;
    }
}

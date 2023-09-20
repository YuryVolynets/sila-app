<?php

namespace App\Services;

use App\Models\Folder;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ProductService
{
    /**
     * Фильтрация товаров
     *
     * @param array $filterData
     *
     * @return Collection
     */
    public function filter(array $filterData): Collection
    {
        $productsBuilder = Product::query();

        foreach ($filterData as $key => $value) {
            switch ($key) {
                case 'folders':
                    $productsBuilder = $productsBuilder->folderId($this->getFolderIds($value));
                    break;
                case 'price':
                    $productsBuilder = $this->addMinMax($productsBuilder, 'price', $value);
                    break;
                case 'param':
                    foreach ($value as $paramKey => $paramValue) {
                        $productsBuilder = $this->addMinMax($productsBuilder, $paramKey, $paramValue);
                    }
                    break;
            }
        }

        return $productsBuilder->get();
    }

    private function getFolderIds(array $folders): Collection
    {
        $folderIds = collect();

        $descendantsIds = Folder::getDescendantsIds();

        foreach ($folders as $folder) {
            $folderIds = $folderIds->merge($descendantsIds[$folder]);
        }

        return $folderIds->unique();
    }

    private function addMinMax(Builder $builder, string $paramName, array $paramValue)
    {
        foreach ($paramValue as $key => $value) {
            $builder = $builder->{$paramName . ucfirst($key)}($value);
        }

        return $builder;
    }

    /**
     * Получить товар по ЧПУ
     *
     * @param string $slug
     *
     * @return Product|null
     */
    public function getBySlug(string $slug): ?Product
    {
        return Product::firstWhere('slug', $slug);
    }
}

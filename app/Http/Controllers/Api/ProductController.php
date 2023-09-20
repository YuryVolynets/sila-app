<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FilterProductRequest;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function show(string $slug, ProductService $productService): JsonResponse
    {
        $product = $productService->getBySlug($slug);

        if ($product) {
            return response()->json($product);
        } else {
            return response()->json([
                'message' => 'Not found.',
            ], Response::HTTP_NOT_FOUND);
        }
    }

    public function filter(FilterProductRequest $request, ProductService $productService): JsonResponse
    {
        return response()->json($productService->filter($request->validated()));
    }
}

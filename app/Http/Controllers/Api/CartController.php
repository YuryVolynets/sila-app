<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\DeleteCartRequest;
use App\Http\Requests\Api\EditCartRequest;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    public function show(string $uuid, CartService $cartService): JsonResponse
    {
        $cart = $cartService->getByUuid($uuid);
        if ($cart) {
            return response()->json($cart);
        } else {
            return response()->json([
                'message' => 'Not found.',
            ], Response::HTTP_NOT_FOUND);
        }
    }

    public function edit(EditCartRequest $request, CartService $cartService): JsonResponse
    {
        return response()->json(['uuid' => $cartService->edit($request->validated())]);
    }

    public function delete(DeleteCartRequest $request, CartService $cartService): JsonResponse
    {
        return response()->json(['uuid' => $cartService->delete($request->validated())]);
    }
}

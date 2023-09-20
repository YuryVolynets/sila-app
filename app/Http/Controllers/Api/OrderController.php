<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\MakeOrderRequest;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function show(string $uuid, OrderService $orderService): JsonResponse
    {
        $order = $orderService->getByUuid($uuid);
        if ($order) {
            return response()->json($order);
        } else {
            return response()->json([
                'message' => 'Not found.',
            ], Response::HTTP_NOT_FOUND);
        }
    }

    public function showAll(OrderService $orderService): JsonResponse
    {
        if (auth('sanctum')->check()) {
            return response()->json($orderService->getAll());
        } else {
            return response()->json([
                'message' => 'Unauthenticated.',
            ], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function make(MakeOrderRequest $request, OrderService $orderService): JsonResponse
    {
        return response()->json(['uuid' => $orderService->make($request->validated())]);
    }
}

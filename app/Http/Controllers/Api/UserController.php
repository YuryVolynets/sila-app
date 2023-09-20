<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginUserRequest;
use App\Http\Requests\Api\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Зарегистрировать пользователя
     *
     * @param RegisterUserRequest $request
     *
     * @return JsonResponse
     */
    public function register(RegisterUserRequest $request): JsonResponse
    {
        $user = User::create($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'User registered',
            'token' => $user->createToken('api token')->plainTextToken,
        ]);
    }

    /**
     * Авторизовать пользователя
     *
     * @param LoginUserRequest $request
     *
     * @return JsonResponse
     */
    public function login(LoginUserRequest $request): JsonResponse
    {
        if (Auth::attempt($request->validated())) {
            /** @var User $user */
            $user = Auth::user();

            return response()->json([
                'status' => true,
                'message' => 'User logged in',
                'token' => $user->createToken('api token')->plainTextToken,
            ]);
        } else {
            return response()->json([
                'message' => 'Unauthenticated.',
            ], Response::HTTP_UNAUTHORIZED);
        }
    }
}

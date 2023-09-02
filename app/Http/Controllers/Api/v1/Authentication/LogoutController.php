<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1\Authentication;

use App\Http\Controllers\Api\v1\Controller;
use App\Http\UseCases\Api\v1\Authentication\LogoutUseCase;
use App\Models\User;
use Illuminate\Http\JsonResponse;

/**
 * @group Authentication
 *
 * @authenticated
 */
class LogoutController extends Controller
{
    public function __invoke(User $user, LogoutUseCase $useCase): JsonResponse
    {
        return $useCase->handle($user);
    }
}

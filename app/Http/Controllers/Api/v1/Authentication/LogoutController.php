<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\v1\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Authentication\EmailRequest;
use App\UseCases\v1\Authentication\LogoutUseCase;
use Illuminate\Http\JsonResponse;

class LogoutController extends Controller
{
    public function __invoke(EmailRequest $request, LogoutUseCase $useCase): JsonResponse
    {
        return $useCase->handle(
            $request->validated()
        );
    }
}

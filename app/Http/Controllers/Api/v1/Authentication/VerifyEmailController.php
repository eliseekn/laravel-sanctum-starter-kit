<?php

namespace App\Http\Controllers\Api\v1\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Authentication\EmailRequest;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\JsonResponse;

class VerifyEmailController extends Controller
{
    public function verify(EmailVerificationRequest $request): JsonResponse
    {
        $request->fulfill();

        return response()->json([
            'status' => 'success',
            'message' => 'Email verified successfully.'
        ]);
    }

    public function notify(EmailRequest $request): JsonResponse
    {
        $user = User::query()
            ->where($request->validated())
            ->first();

        $user->sendEmailVerificationNotification();

        return response()->json([
            'status' => 'success',
            'message' => 'Email verification notification sent successfully.'
        ]);
    }
}

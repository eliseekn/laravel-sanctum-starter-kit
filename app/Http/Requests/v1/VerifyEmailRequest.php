<?php

declare(strict_types=1);

namespace App\Http\Requests\v1;

use App\Enums\HttpResponseStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class VerifyEmailRequest extends FormRequest
{
    public function authorize(): bool
    {
        if (! hash_equals((string) $this->route('id'), (string) $this->user('sanctum')->getKey())) {
            return false;
        }

        if (! hash_equals((string) $this->route('hash'), sha1($this->user('sanctum')->getEmailForVerification()))) {
            return false;
        }

        return true;
    }

    public function rules(): array
    {
        return [
            //
        ];
    }

    protected function failedAuthorization(): void
    {
        throw new HttpResponseException(
            response()->json([
                'status' => HttpResponseStatus::ERROR,
                'message' => 'Unauthaurized',
            ], 401)
        );
    }

    protected function fulfill(): void
    {
        if (! $this->user('sanctum')->hasVerifiedEmail()) {
            $this->user('sanctum')->markEmailAsVerified();
        }
    }
}

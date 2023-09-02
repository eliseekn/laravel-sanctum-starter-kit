<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\v1\Authentication;

use Illuminate\Foundation\Http\FormRequest;

class EmailVerificationRequest extends FormRequest
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

    protected function fulfill(): void
    {
        if (! $this->user('sanctum')->hasVerifiedEmail()) {
            $this->user('sanctum')->markEmailAsVerified();
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Requests\v1\Profile;

use App\Enums\HttpResponseStatus;
use App\Rules\CorrectPassword;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Password;
use Knuckles\Scribe\Attributes\BodyParam;

#[BodyParam('old_password', 'string', 'Old password.', required: true, example: 'OldP@ss1!')]
#[BodyParam('new_password', 'string', 'New password (min 8 characters, uppercases, lowercases, numbers, special characters).', required: true, example: 'N3wP@ss!')]
class UpdatePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (int) $this->user('sanctum')?->id === (int) $this->route('user')?->id;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'old_password' => ['required', new CorrectPassword],
            'new_password' => [
                'required',
                'max:255',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols(),
            ],
        ];
    }

    protected function failedAuthorization(): void
    {
        throw new HttpResponseException(
            response()->json([
                'status' => HttpResponseStatus::ERROR,
                'message' => 'Forbidden',
            ], 403)
        );
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status' => HttpResponseStatus::ERROR,
                'message' => 'Invalid or missing data',
                'errors' => $validator->errors()->toArray(),
            ], 400)
        );
    }
}

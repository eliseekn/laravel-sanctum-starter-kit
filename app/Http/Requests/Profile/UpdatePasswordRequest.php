<?php

declare(strict_types=1);

namespace App\Http\Requests\Profile;

use App\Exceptions\ForbiddenException;
use App\Rules\CorrectPassword;
use Eliseekn\LaravelApiResponse\MakeApiResponse;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Password;
use Knuckles\Scribe\Attributes\BodyParam;

#[BodyParam('old_password', 'string', 'Old password.', required: true, example: 'OldP@ss1!')]
#[BodyParam('new_password', 'string', 'New password (min 8 characters, uppercases, lowercases, numbers, special characters).', required: true, example: 'N3wP@ss!')]
class UpdatePasswordRequest extends FormRequest
{
    use MakeApiResponse;

    public function authorize(): bool
    {
        return (int) $this->user('sanctum')?->id === (int) $this->route('user')?->id;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'old_password' => ['required', new CorrectPassword],
            'new_password' => ['required', 'max:255', Password::min(8)->mixedCase()->letters()->numbers()->symbols()],
        ];
    }

    protected function failedAuthorization(): void
    {
        throw new ForbiddenException;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->errorJsonResponse([
                'message' => 'Invalid or missing data',
                'errors' => $validator->errors()->toArray(),
            ], 400)
        );
    }
}

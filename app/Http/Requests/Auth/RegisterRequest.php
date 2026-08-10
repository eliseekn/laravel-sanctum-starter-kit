<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Eliseekn\LaravelApiResponse\MakeApiResponse;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Password;
use Knuckles\Scribe\Attributes\BodyParam;

#[BodyParam('name', 'string', 'User full name.', required: true, example: 'Doe')]
#[BodyParam('email', 'string', 'Email address.', required: true, example: 'john@doe.com')]
#[BodyParam('password', 'string', 'Password (min 8 characters, uppercases, lowercases, numbers, special characters).', required: true, example: 'P@ssw0rd!')]
class RegisterRequest extends FormRequest
{
    use MakeApiResponse;

    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'max:255', Password::min(8)->mixedCase()->letters()->numbers()->symbols()],
        ];
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

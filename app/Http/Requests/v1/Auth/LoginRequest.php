<?php

declare(strict_types=1);

namespace App\Http\Requests\v1\Auth;

use Eliseekn\LaravelApiResponse\MakeApiResponse;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Knuckles\Scribe\Attributes\BodyParam;

#[BodyParam('email', 'string', 'Email address.', required: true, example: 'john@doe.com')]
#[BodyParam('password', 'string', 'Password.', required: true, example: 'P@ssw0rd!')]
class LoginRequest extends FormRequest
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
            'email' => ['required', 'email'],
            'password' => 'required',
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

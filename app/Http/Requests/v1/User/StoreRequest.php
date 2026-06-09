<?php

declare(strict_types=1);

namespace App\Http\Requests\v1\User;

use App\Enums\UserRole;
use App\Exceptions\ForbiddenException;
use Eliseekn\LaravelApiResponse\MakeApiResponse;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Knuckles\Scribe\Attributes\BodyParam;

#[BodyParam('name', 'string', 'User full name.', required: true, example: 'Doe')]
#[BodyParam('email', 'string', 'Email address.', required: true, example: 'john@doe.com')]
#[BodyParam('role', 'string', 'User role.', required: true, example: UserRole::ADMIN->value, enum: UserRole::class)]
class StoreRequest extends FormRequest
{
    use MakeApiResponse;

    public function authorize(): bool
    {
        return $this->user('sanctum')?->role === UserRole::ADMIN->value;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'role' => ['required', Rule::enum(UserRole::class)],
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

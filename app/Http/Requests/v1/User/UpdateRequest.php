<?php

declare(strict_types=1);

namespace App\Http\Requests\v1\User;

use App\Enums\HttpResponseStatus;
use App\Enums\UserRole;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Knuckles\Scribe\Attributes\BodyParam;

#[BodyParam('name', 'string', 'User full name.', required: false, example: 'Doe')]
#[BodyParam('email', 'string', 'Email address.', required: false, example: 'john@doe.com')]
#[BodyParam('role', 'string', 'User role.', required: false, example: UserRole::ADMIN, enum: UserRole::class)]
class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user('sanctum')?->role === UserRole::ADMIN;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'max:255'],
            'email' => ['sometimes', 'email', 'max:255', 'unique:users,email,'.$this->route('user')?->id],
            'role' => ['sometimes', Rule::in([UserRole::ADMIN, UserRole::USER])],
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

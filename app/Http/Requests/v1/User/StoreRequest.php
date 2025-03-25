<?php

declare(strict_types=1);

namespace App\Http\Requests\v1\User;

use App\Enums\HttpResponseStatus;
use App\Enums\UserRole;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user('sanctum')->role === UserRole::ADMIN;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'role' => ['required', Rule::in([UserRole::ADMIN, UserRole::USER])],
        ];
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

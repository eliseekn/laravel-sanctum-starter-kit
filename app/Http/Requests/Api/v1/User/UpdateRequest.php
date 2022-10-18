<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\v1\User;

use App\Enums\UserRole;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return
            $this->user('sanctum')->isRole(UserRole::USER->value) &&
            $this->route('user')->id === $this->user('sanctum')->id;
    }

    public function rules(): array
    {
        return [
            'email' => ['sometimes', 'required', 'email'],
            'name' => ['sometimes', 'required'],
            'password' => ['sometimes', 'required', 'min:8'],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(
                $validator->errors(), 422
            )
        );
    }
}

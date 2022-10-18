<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\v1\User;

use App\Enums\UserRole;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this
            ->user('sanctum')
            ->isRole(UserRole::ADMIN->value);
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'name' => 'required',
            'role' => ['required', Rule::in(UserRole::getValues())],
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

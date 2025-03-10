<?php

declare(strict_types=1);

namespace App\Http\Requests\v1\User;

use App\Enums\UserRole;
use Eliseekn\LaravelApiResponse\MakeApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    use MakeApiResponse;

    public function authorize(): bool
    {
        return $this
            ->user('sanctum')
            ->isRole(UserRole::ADMIN);
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'unique:users'],
            'name' => 'required',
            'role' => ['required', Rule::in([UserRole::ADMIN, UserRole::USER])],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->errorResponse($validator->errors()->toArray(), 400)
        );
    }
}

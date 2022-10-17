<?php
declare(strict_types=1);

namespace App\Http\Requests\Api\v1\Authentication;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ResetPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'token' => 'required',
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'confirmed'],
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

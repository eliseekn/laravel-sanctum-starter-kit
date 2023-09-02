<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\v1\Authentication;

use App\Http\Shared\MakeApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    use MakeApiResponse;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', Password::min(8)->letters()->numbers()->mixedCase()->symbols()],
            'name' => 'required',
        ];
    }

    protected function passedValidation(): void
    {
        $this->replace([
            'password' => bcrypt($this->get('password')),
        ]);
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->errorResponse($validator->errors()->toArray(), 422)
        );
    }
}

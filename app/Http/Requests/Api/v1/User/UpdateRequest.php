<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\v1\User;

use App\Http\Shared\MakeApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Password;

class UpdateRequest extends FormRequest
{
    use MakeApiResponse;

    public function authorize(): bool
    {
        return $this->route('user')->id === $this->user('sanctum')->id;
    }

    public function rules(): array
    {
        return [
            'email' => ['sometimes', 'required', 'email', 'unique:users,email,'.$this->route('user')->id],
            'name' => ['sometimes', 'required'],
            'password' => ['sometimes', 'required', Password::min(8)->letters()->numbers()->mixedCase()->symbols()],
        ];
    }

    protected function passedValidation(): void
    {
        if (! is_null($this->get('password'))) {
            $this->replace([
                'password' => bcrypt($this->get('password')),
            ]);
        }
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->errorResponse($validator->errors()->toArray(), 422)
        );
    }
}

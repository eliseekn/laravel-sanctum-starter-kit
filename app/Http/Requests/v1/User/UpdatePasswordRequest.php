<?php

declare(strict_types=1);

namespace App\Http\Requests\v1\User;

use App\Enums\HttpResponseStatus;
use Closure;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UpdatePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (int) $this->user('sanctum')?->id === (int) $this->route('user')?->id; // @phpstan-ignore-line
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'old_password' => ['required', function (string $attribute, mixed $value, Closure $fail) {
                $user = $this->user('sanctum');

                if (! Hash::check($value, $user?->password)) {
                    $fail('Invalid password');
                }
            }],
            'new_password' => ['required', 'max:255', Password::min(8)->mixedCase()->letters()->numbers()->symbols()],
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

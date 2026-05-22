<?php

declare(strict_types=1);

namespace App\Http\Requests\v1\Profile;

use App\Exceptions\ForbiddenException;
use Eliseekn\LaravelApiResponse\MakeApiResponse;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Knuckles\Scribe\Attributes\BodyParam;

#[BodyParam('name', 'string', 'User full name.', required: false, example: 'Doe')]
#[BodyParam('email', 'string', 'Email address.', required: false, example: 'john@doe.com')]
class UpdateRequest extends FormRequest
{
    use MakeApiResponse;

    public function authorize(): bool
    {
        return (int) $this->user('sanctum')?->id === (int) $this->route('user')?->id;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'max:255'],
            'email' => ['sometimes', 'email', 'max:255', 'unique:users,email,'.$this->route('user')?->id],
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

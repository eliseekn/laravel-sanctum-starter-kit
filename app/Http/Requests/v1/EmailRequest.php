<?php

declare(strict_types=1);

namespace App\Http\Requests\v1;

use Eliseekn\LaravelApiResponse\MakeApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Knuckles\Scribe\Attributes\BodyParam;

#[BodyParam('email', 'string', 'Email address.', required: true, example: 'john@doe.com')]
class EmailRequest extends FormRequest
{
    use MakeApiResponse;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
        ];
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

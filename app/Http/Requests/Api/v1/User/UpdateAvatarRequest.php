<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\v1\User;

use App\Http\Shared\MakeApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\File;

class UpdateAvatarRequest extends FormRequest
{
    use MakeApiResponse;

    public function authorize(): bool
    {
        return $this->route('user')->id === $this->user('sanctum')->id;
    }

    public function rules(): array
    {
        return [
            'avatar' => ['required', File::types(['png', 'jpg', 'jpeg'])->max(1024 * 5)],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->errorResponse($validator->errors()->toArray(), 422)
        );
    }
}

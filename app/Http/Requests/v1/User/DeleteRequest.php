<?php

declare(strict_types=1);

namespace App\Http\Requests\v1\User;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;

class DeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user('sanctum')->role === UserRole::ADMIN;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}

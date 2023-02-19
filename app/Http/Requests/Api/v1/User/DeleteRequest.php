<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\v1\User;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;

class DeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this
            ->user('sanctum')
            ->hasRole(UserRole::ADMIN->value);
    }

    public function rules(): array
    {
        return [];
    }
}

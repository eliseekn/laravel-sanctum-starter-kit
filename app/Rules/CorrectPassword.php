<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Translation\PotentiallyTranslatedString;

class CorrectPassword implements ValidationRule
{
    /**
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $user = auth('sanctum')->user();

        if (! Hash::check($value, $user?->password)) { // @phpstan-ignore-line
            $fail('Incorrect password');
        }
    }
}

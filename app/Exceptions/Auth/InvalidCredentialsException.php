<?php

declare(strict_types=1);

namespace App\Exceptions\Auth;

use Eliseekn\LaravelApiResponse\MakeApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;

class InvalidCredentialsException extends Exception
{
    use MakeApiResponse;

    public function __construct(?string $message = null)
    {
        parent::__construct($message ?? 'Invalid email or password');
    }

    public function render(): JsonResponse
    {
        return $this->errorJsonResponse($this->getMessage(), 401);
    }
}

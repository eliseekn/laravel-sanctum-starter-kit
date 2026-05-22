<?php

declare(strict_types=1);

namespace App\Exceptions;

use Eliseekn\LaravelApiResponse\MakeApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;

class ResetPasswordException extends Exception
{
    use MakeApiResponse;

    public function __construct(string $message)
    {
        parent::__construct($message);
    }

    public function render(): JsonResponse
    {
        return $this->errorJsonResponse($this->getMessage(), 500);
    }
}

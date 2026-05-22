<?php

declare(strict_types=1);

namespace App\Exceptions;

use Eliseekn\LaravelApiResponse\MakeApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;

class ForbiddenException extends Exception
{
    use MakeApiResponse;

    public function __construct(?string $message = null)
    {
        parent::__construct($message ?? 'Forbidden');
    }

    public function render(): JsonResponse
    {
        return $this->errorJsonResponse($this->getMessage(), 403);
    }
}

<?php

declare(strict_types=1);

namespace App\Enums;

enum HttpResponseStatus: string
{
    const SUCCESS = 'success';

    const ERROR = 'error';
}

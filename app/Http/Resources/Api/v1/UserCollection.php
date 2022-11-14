<?php

declare(strict_types=1);

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return ['data' => $this->collection];
    }
}

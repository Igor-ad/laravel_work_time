<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

abstract class AbstractResourceCollection extends ResourceCollection
{
    abstract protected function getMessage(): string;

    public function toArray(Request $request): array
    {
        return [
            'message' => $this->getMessage(),
            'count' => $this->count(),
            'data' => $this->collection,
        ];
    }
}

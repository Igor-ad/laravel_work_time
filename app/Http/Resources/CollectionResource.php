<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CollectionResource extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'count' => $this->collection->count(),
            'data' => $this->collection,
        ];
    }
}

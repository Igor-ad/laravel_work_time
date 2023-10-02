<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ModelCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
            'meta' => [
                'from' => $this->firstItem(),
                'to' => $this->lastItem(),
                'current_page' => $this->currentPage(),
                'last_page' => $this->lastPage(),
                'per_page' => $this->perPage(),
                'total' => $this->total(),
                'link' => [
                    'path' => $this->path(),
                    'first_page_url' => $this->url(1),
                    'prev_page_url' => $this->previousPageUrl(),
                    'next_page_url' => $this->nextPageUrl(),
                    'last_page_url' => $this->url($this->lastPage()),
                ],
            ],
        ];
    }
}

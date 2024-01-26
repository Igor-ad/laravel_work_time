<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;

class WorkerJobHistoryResource extends AbstractResourceCollection
{
    protected function getMessage(): string
    {
        return __('work_time.worker_history', ['name' => $this->collection->get('name')]);
    }

    public function toArray(Request $request): array
    {
        return [
            'message' => $this->getMessage(),
            'data' => $this->collection->except('name'),
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

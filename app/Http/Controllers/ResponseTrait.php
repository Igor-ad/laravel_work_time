<?php

namespace App\Http\Controllers;

use App\Http\Resources\CollectionResource;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\ModelResource;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection as Collect;
use JsonSerializable;
use Symfony\Component\HttpFoundation\Response;

trait ResponseTrait
{
    protected string|null $key = null;
    protected Collect|null $model = null;
    protected Collection|LengthAwarePaginator|null $collection = null;

    public function commonResponse(JsonSerializable $jsonSerializable, int $status): JsonResponse
    {
        return response()->json([
            $this->key => $jsonSerializable,
        ],
            status: $status,
            options: JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT,
        );
    }

    public function paginateCollect(): JsonResponse
    {
        $jsonSerializable = new PaginateResource($this->collection);

        return $this->commonResponse($jsonSerializable, Response::HTTP_OK);
    }

    public function responseCollect(): JsonResponse
    {
        $jsonSerializable = new CollectionResource($this->collection);

        return $this->commonResponse($jsonSerializable, Response::HTTP_OK);
    }

    public function responseResource(): JsonResponse
    {
        $jsonSerializable = new ModelResource($this->model);

        return $this->commonResponse($jsonSerializable, Response::HTTP_OK);
    }

    public function responseCreate(): JsonResponse
    {
        $jsonSerializable = new ModelResource($this->model);

        return $this->commonResponse($jsonSerializable, Response::HTTP_CREATED);
    }

    public function responseError(): JsonResponse
    {
        $jsonSerializable = new ModelResource($this->model);

        return $this->commonResponse($jsonSerializable, Response::HTTP_NOT_IMPLEMENTED);
    }
}

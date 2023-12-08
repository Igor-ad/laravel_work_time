<?php

namespace App\Http\Requests\Api;

class WorkerRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'worker' => ['required', 'string', 'exists:workers,name'],
            'page' => ['integer'],
            'per_page' => ['integer'],
        ];
    }
}

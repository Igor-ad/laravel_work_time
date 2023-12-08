<?php

namespace App\Http\Requests\Api;

class CycleRequest extends ApiFormRequest
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
            'machine' => ['required', 'integer', 'exists:machines,id'],
        ];
    }
}

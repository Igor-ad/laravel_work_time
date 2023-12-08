<?php

namespace App\Http\Requests\Api;

class MachineRequest extends ApiFormRequest
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
            'machine' => ['required', 'integer', 'exists:machines,id'],
        ];
    }
}

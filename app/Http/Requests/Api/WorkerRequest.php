<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class WorkerRequest extends FormRequest
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

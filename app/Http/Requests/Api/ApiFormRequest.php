<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

abstract class ApiFormRequest extends FormRequest
{
    /**
     * @param Validator $validator
     * @return mixed
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            response: response()->json(
                data: [
                    'errors' => $errors,
                ],
                status: Response::HTTP_UNPROCESSABLE_ENTITY,
                options: JSON_PRETTY_PRINT,
            ));
    }

    abstract function authorize();

    abstract function rules();

}

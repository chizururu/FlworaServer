<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

abstract class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation error when which field is nullable.
     * */
    protected function failedValidation(Validator $validator)
    {
        $payload = [
            'status' => false,
            'message' => 'Kesalahan validasi',
            'errors' => $validator->errors(),
        ];

        throw new HttpResponseException(
            response()->json($payload, Response::class::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}

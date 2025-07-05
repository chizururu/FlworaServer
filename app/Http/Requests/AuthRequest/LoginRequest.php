<?php

namespace App\Http\Requests\AuthRequest;

use App\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|max:12',
        ];
    }

    /**
     * Initialization a errors message with each rules
     *
     * @return array<String>
     * */
    public function messages(): array
    {
        return [
            'required' => ':Attribute wajib diisi',
            'email' => ':Attribute tidak valid',
            'max:12' => ':Attribute tidak boleh lebih dari 12 karakter'
        ];
    }
}

<?php

namespace App\Http\Requests\AuthRequest;

use App\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|max:12',
            'confirm_password' => 'required|max:12|same:password'
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
            'unique' => ':Attribute sudah dibuat sebelumnya',
            'email' => ':Attribute tidak valid',
            'same' => ':Attribute harus sama',
            'max' => ':Attribute maksimal 12 karakter',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class DeviceRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'required',
            'name' => 'required',
            'sector_id' => 'required|integer|exists:sectors,id'
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
            'sector_id.exists' => ':Attribute tidak ditemukan'
        ];
    }
}

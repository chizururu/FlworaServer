<?php

namespace App\Http\Requests\Device;

use App\Http\Requests\BaseRequest;

class Request extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'sector_id' => 'required|integer|exists:sectors,id'
        ];
    }

    /*
     * Get error message with each rules
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

<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SectorRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', Rule::unique('sectors', 'name')->where(fn($q) => $q->where('user_id', Auth::id()))]
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
            'unique' => ':Attribute sudah dibuat sebelumnya'
        ];
    }
}

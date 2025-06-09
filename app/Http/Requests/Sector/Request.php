<?php

namespace App\Http\Requests\Sector;

use App\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
            'name' => ['required', Rule::unique('sectors', 'name')->where(fn($query) => $query->where('user_id', Auth::id()))]
        ];
    }

    /*
     * Get error message with each rules
     * */
    public function messages(): array
    {
        return [
            'required' => ':Attribute wajib diisi',
            'unique' => ':Attribute sudah dibuat sebelumnya'
        ];
    }
}

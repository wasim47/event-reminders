<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmailStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'address' => ['required', 'email', 'unique:emails,address'],
            'created_by' => ['required', 'exists:users,id'],
            'updated_by' => ['nullable', 'exists:users,id'],
            'deleted_by' => ['nullable', 'exists:users,id'],
        ];
    }
}

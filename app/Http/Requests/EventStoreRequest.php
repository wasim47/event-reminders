<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventStoreRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:100'],
            'type' => ['required', 'in:Upcoming,Completed'],
            'event_id' => ['required', 'string', 'max:20', 'unique:events,event_id'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'integer', 'in:1,0'],
            'event_time' => ['required', 'date'],
            'created_by' => ['required', 'exists:users,id'],
            'updated_by' => ['nullable', 'exists:users,id'],
            'deleted_by' => ['nullable', 'exists:users,id'],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventUpdateRequest extends FormRequest
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
        $eventId = $this->route('event'); // Assuming 'event' is the parameter name in the route
        return [
            'name' => ['required', 'string', 'max:100'],
            'type' => ['required', 'in:Upcoming,Completed'],
            'event_id' => [
                'required',
                'string',
                'max:20',
                // Ensure the event_id is unique except for the current event
                'unique:events,event_id,' . $eventId,
            ],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'integer', 'in:1,0'],
            'event_time' => ['required', 'date'],
            'created_by' => ['required', 'exists:users,id'],
            'updated_by' => ['nullable', 'exists:users,id'],
            'deleted_by' => ['nullable', 'exists:users,id'],
        ];
    }
}

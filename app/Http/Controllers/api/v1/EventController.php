<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;

use App\Http\Requests\EventUpdateRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Services\EventService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    protected $service;

    public function __construct(EventService $service)
    {
        $this->service = $service;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'type' => ['required', 'in:Upcoming,Completed'],
            'event_id' => ['required', 'string', 'max:20', 'unique:events,event_id'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'integer', 'in:1,0'],
            'event_time' => ['required', 'date'],
        ]);

        // Create the event
        $event = Event::create([
            'event_id' => $request->event_id,
            'name' => $request->name,
            'type' => $request->type,
            'status' => $request->status,
            'description' => $request->description,
            'event_time' => $request->event_time,
            'created_by' => 1
            
        ]);

        // Return a JSON response
        return response()->json([
            'success' => true,
            'message' => 'Event stored successfully',
            'event' => $event,
        ], 201);
    }
}

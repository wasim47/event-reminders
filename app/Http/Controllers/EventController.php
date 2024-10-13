<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EventStoreRequest;
use App\Http\Requests\EventUpdateRequest;
use App\Http\Resources\EventResource;
use App\Services\EventService;

class EventController extends Controller
{
    protected $service;

    public function __construct(EventService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function offline()
    {
        $eventList = EventResource::collection($this->service->index());
        return view('event.offline', compact('eventList'));
    }

    public function index()
    {
        $eventList = EventResource::collection($this->service->index());
        return view('event.index', compact('eventList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {        
        $eventID =$this->generateEventEventId();
        return view('event.form_action', compact('eventID'));
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param  \App\Http\Requests\EventStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventStoreRequest $request)
    {
        $this->service->store($request->validated());        
        return redirect()->route('event.index')
            ->with('success', 'Event created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\View\View
     */
    public function show(int $id)
    {
        $event = $this->service->find($id); 
        return view('event.view', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\View\View
     */
    public function edit(int $id)
    {
        $event = $this->service->find($id); 
        return view('event.form_action', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param  \App\Http\Requests\EventStoreRequest  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EventUpdateRequest $request, string $id)
    {
        // dd($request->all());
        $event = $this->service->update($id, $request->validated());
        return redirect()->route('event.index')
            ->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        // Delete the event using the service layer
        $this->service->delete($id);

        return redirect()->route('event.index')
            ->with('success', 'Event deleted successfully.');
    }


    private function generateEventEventId()
    {
        return 'REM-' . date('Y') . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
    }
}

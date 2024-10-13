<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EmailStoreRequest;
use App\Http\Requests\EmailUpdateRequest;
use App\Http\Resources\EmailResource;
use App\Models\Email;
use App\Services\EmailService;

class EmailController extends Controller
{
    protected $service;

    public function __construct(EmailService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $emailList = EmailResource::collection($this->service->index());
        return view('email.index', compact('emailList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {        
        return view('email.form_action');
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param  \App\Http\Requests\EmailStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmailStoreRequest $request)
    {
        $this->service->store($request->validated());        
        return redirect()->route('email.index')
            ->with('success', 'Email created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\View\View
     */
    public function show(int $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\View\View
     */
    public function edit(int $id)
    {
        $email = $this->service->find($id); 
        return view('email.form_action', compact('email'));
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param  \App\Http\Requests\EmailStoreRequest  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmailUpdateRequest $request, string $id)
    {
        // dd($request->all());
        $email = $this->service->update($id, $request->validated());
        return redirect()->route('email.index')
            ->with('success', 'Email updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        // Delete the Email using the service layer
        $this->service->delete($id);

        return redirect()->route('email.index')
            ->with('success', 'Email deleted successfully.');
    }
}

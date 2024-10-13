<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Event;
use App\Models\Email;
use App\Jobs\EmailJob;
use App\Mail\ReminderMail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function sendMail()
    {
        $events = Event::whereBetween('event_time', [now(), now()->addDay()])->get();
        $emails = Email::pluck('address')->toArray();

        foreach ($events as $event) {
            Mail::to($emails)->send(new ReminderMail($event));
        }
        
        return redirect()->route('email.index')
            ->with('success', 'Email sent successfully.');
    }
}

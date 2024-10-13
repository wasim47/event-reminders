<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReminderMail;
use App\Models\Event;
use App\Models\Email;
use Illuminate\Foundation\Queue\Queueable;

class EmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $event;

    /**
     * Create a new job instance.
     *
     * @param \App\Models\Event $event
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Get all email addresses from the Email model
        $emails = Email::all(); // Remove dd($emails);
        
        foreach ($emails as $email) {
            // Send email to each recipient
            Mail::to($email->address)->send(new ReminderMail($this->event));
        }
    }
}

<?php

namespace App\Console\Commands;

use App\Jobs\EmailJob;
use App\Models\Event;
use Illuminate\Console\Command;

class ReminderEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:reminder-mails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder emails for upcoming events';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Filter events happening within the next 24 hours
        $events = Event::whereBetween('event_time', [now(), now()->addDay()])->get();

        if ($events->isEmpty()) {
            $this->info('No events found for reminders.');
            return;
        }

        foreach ($events as $event) {
            // Dispatch job to send reminder emails
            EmailJob::dispatch($event);
            $this->info("Reminder email dispatched for event: {$event->name}");
        }

        $this->info('Event Reminder emails have been dispatched.');
    }
}

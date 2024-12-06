<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\EventRemindersMail;
use Illuminate\Support\Facades\Mail;

class EventReminders implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {

        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $email = new EventRemindersMail($this->data);
        Mail::to($this->data['email'])->send($email);
    }
}

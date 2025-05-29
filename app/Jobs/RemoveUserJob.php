<?php

namespace App\Jobs;

use App\Mail\RemoveUserMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class RemoveUserJob implements ShouldQueue
{
    use Queueable, SerializesModels;
    protected $user;
    /**
     * Create a new job instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->user['email'])->send(
            new RemoveUserMail((object) $this->user)
        );
    }
}

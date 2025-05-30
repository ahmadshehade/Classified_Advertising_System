<?php

namespace App\Jobs;

use App\Mail\RemoveUserMail;
use Illuminate\Bus\Queueable as BusQueueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class RemoveUserJob implements ShouldQueue
{
    use BusQueueable, SerializesModels;

    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function handle(): void
    {
        try {
            Mail::to($this->user['email'])->send(
                new RemoveUserMail((object) $this->user)
            );

            echo " Email sent to: {$this->user['email']}" . PHP_EOL;
        } catch (Throwable $e) {
            Log::error('Fail Send Message',[
                'user'=>$this->user,
                'error'=>$e->getMessage()
            ]);
        }
    }
}

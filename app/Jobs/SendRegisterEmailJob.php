<?php

namespace App\Jobs;

use App\Mail\EndRegisterMail;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendRegisterEmailJob implements ShouldQueue
{
    use Queueable, SerializesModels;
    protected $user;
    protected $password;
    /**
     * Create a new job instance.
     */
    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
      try{
             Mail::to($this->user->email)->send(
            new EndRegisterMail(
                $this->user,
                $this->password
            )
        );
      }catch(Exception  $e){
           Log::error('Failed to send registration email', [
            'user' => $this->user,
            'error' => $e->getMessage()
        ]);
      }
    }
}

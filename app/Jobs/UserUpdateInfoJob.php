<?php

namespace App\Jobs;

use App\Mail\UserUpdateAdsMail;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UserUpdateInfoJob implements ShouldQueue
{
    use Queueable;

    protected  $ads;
    /**
     * Create a new job instance.
     */
    public function __construct($ads)
    {
        $this->ads = $ads;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try{
          Mail::to($this->ads->user->email)->send(new UserUpdateAdsMail($this->ads));
        }catch(Exception $e){
         Log::error('Sen Email Error',
         [
            'user'=>$this->ads->user,
          'error' => $e->getMessage()
        ]);
        }
    }
}

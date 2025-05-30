<?php

namespace App\Jobs;

use App\Mail\NewAdsMail;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NewAdsJob implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    protected $ads;
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
        try {
            Mail::to($this->ads->user->email)->send(new NewAdsMail($this->ads));
        } catch (Exception  $e) {
            Log::error(
                'Sen Email Error',
                [
                    'user' => $this->ads->user,
                    'error' => $e->getMessage()
                ]
            );
        }
    }
}

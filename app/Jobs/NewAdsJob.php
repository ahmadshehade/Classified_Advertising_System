<?php

namespace App\Jobs;

use App\Mail\NewAdsMail;
use App\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class NewAdsJob implements ShouldQueue
{
    use Queueable, SerializesModels;

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


        Mail::to($this->ads->user->email)->send(new NewAdsMail($this->ads));
    }
}

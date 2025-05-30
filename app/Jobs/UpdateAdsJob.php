<?php

namespace App\Jobs;

use App\Mail\UpdateAdsMail;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UpdateAdsJob implements ShouldQueue
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
        try {
            $users = User::all();
            foreach ($users as $user) {
                Mail::to($user->email)->send(new UpdateAdsMail($this->ads));
            }
        } catch (Exception $e) {
            Log::error('UpdateAdsJob failed Send Email', [
                'error' => $e->getMessage()
            ]);
        }
    }
}

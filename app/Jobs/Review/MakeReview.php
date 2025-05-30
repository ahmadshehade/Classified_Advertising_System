<?php

namespace App\Jobs\Review;

use App\Mail\Review\MakeMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Exception;

class MakeReview implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $review;

    /**
     * Create a new job instance.
     */
    public function __construct($review)
    {
        $this->review = $review;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $ad = $this->review->ad;
            if (!$ad) {
                Log::warning('No ad associated with review.', ['review_id' => $this->review->id]);
                return;
            }

            $reviewers = $ad->reviews()
                ->with('user')
                ->get()
                ->pluck('user')
                ->filter()
                ->unique('id');

            $owner = $ad->user;
            if ($owner) {
                $reviewers->push($owner);
            }

            $recipients = $reviewers->filter()
                ->unique('id')
                ->values();

            foreach ($recipients as $user) {
                if ($user && $user->email) {
                    Mail::to($user->email)->queue(new MakeMail($this->review));
                }
            }

            Log::info('MakeReview job executed successfully.', [
                'review_id' => $this->review->id,
                'recipient_count' => $recipients->count()
            ]);
        } catch (Exception $e) {
            Log::error('MakeReview job failed.', [
                'review_id' => $this->review->id ?? null,
                'error' => $e->getMessage()
            ]);
        }
    }
}


<?php

namespace App\Mail\Review;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MakeMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $review;
    /**
     * Create a new message instance.
     */
    public function __construct($review)
    {
        $this->review = $review;
    }

    public function build()
    {
        $this->subject('Add New Review')
            ->view('email.Reviews.makeReview')
            ->with([
                'review' => $this->review
            ]);
    }
}

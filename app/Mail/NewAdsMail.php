<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewAdsMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $ads;
    /**
     * Create a new message instance.
     */
    public function __construct($ads)
    {
        $this->ads = $ads;
    }

    public function build()
    {
        return $this->subject('Add New Ads')
            ->view('email.Ads.add_new_ads')
            ->with([
                'ads' => $this->ads
            ]);
    }
}

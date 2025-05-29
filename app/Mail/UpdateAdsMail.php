<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UpdateAdsMail extends Mailable
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
        $this->subject('Update Ads')
            ->view('email.Ads.update_ads')
            ->with([
                'ads' => $this->ads
            ]);
    }
}

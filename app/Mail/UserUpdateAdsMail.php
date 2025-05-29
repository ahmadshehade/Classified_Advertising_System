<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserUpdateAdsMail extends Mailable
{
    use Queueable, SerializesModels;
    protected  $ads;
    /**
     * Create a new message instance.
     */
    public function __construct($ads)
    {
        $this->ads = $ads;
    }

    public function build()
    {
        return $this->subject('Update Ads info')
            ->view('email.Ads.UpdateInfo')->with([
                'ads' => $this->ads
            ]);
    }
}

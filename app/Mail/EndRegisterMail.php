<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EndRegisterMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $password;
    /**
     * Create a new message instance.
     */
    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    public function build()
    {
        return  $this->subject('Add New User To System ')
            ->view('email.users.add_new_user')
            ->with([
                'user' => $this->user,
                'password' => $this->password
            ]);
    }
}

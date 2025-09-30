<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GenericMessageMail extends Mailable
{
    public $messageTemplate;
    public $user;

    public function __construct($messageTemplate, $user)
    {
        $this->messageTemplate = $messageTemplate;
        $this->user = $user;
    }

    public function build()
    {
        $body = str_replace('{name}', $this->user->first_name, $this->messageTemplate->body);

        return $this->subject($this->messageTemplate->subject)
                    ->view('emails.generic')
                    ->with(['body' => $body]);
    }
}


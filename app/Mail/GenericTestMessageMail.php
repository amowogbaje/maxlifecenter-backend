<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GenericTestMessageMail extends Mailable
{
    public $messageTemplate;

    public function __construct($messageTemplate)
    {
        $this->messageTemplate = $messageTemplate;
    }

    public function build()
    {
        $body = $this->messageTemplate->body;

        return $this->subject($this->messageTemplate->subject)
                    ->view('emails.generic')
                    ->with(['body' => $body]);
    }
}


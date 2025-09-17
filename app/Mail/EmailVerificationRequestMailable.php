<?php

namespace App\Mail;

use App\Models\UserDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailVerificationRequestMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    private $notifiable;
    private $minutes;
    
    /**
     * Create a new message instance.
     * @param object $notifiable
     * @param string $otp
     */
    public function __construct($notifiable, string $otp, int $minutes)
    {
        $this->notifiable = $notifiable;
        $this->otp = $otp;
        $this->minutes = $minutes;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verify your Email Address',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $notifiable = $this->notifiable;
        $otp = $this->otp;
        $minutes = $this->minutes;
        return new Content(markdown: 'emails.email_verification_notification',
            with: [
                'user' => $notifiable,
                'otp' => $otp,
                'minutes' => $minutes,
            ]);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

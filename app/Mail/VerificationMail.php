<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $verificationUrl;
    public $userName;

    /**
     * Create a new message instance.
     */
    public function __construct($verificationUrl,$userName)
    {
        $this->verificationUrl = $verificationUrl;
        $this->userName = $userName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verify Your Email Address',
        );
    }

    /**
     * Build the message.
     */
    public function build()
    {
        // dd($this->verificationUrl,$this->userName);
        return $this->view('emails.verification')
            ->with([
                'verificationUrl' => $this->verificationUrl,
                'userName' => $this->userName
            ]);
    }
}

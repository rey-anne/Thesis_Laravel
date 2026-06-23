<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $otpCode;
    public string $purposeLabel;

    public function __construct(string $otpCode, string $purpose)
    {
        $this->otpCode = $otpCode;
        $this->purposeLabel = $purpose === 'password_reset'
            ? 'reset your password'
            : 'verify your email address';
    }

    public function build()
    {
        return $this->subject('VeriFyre Verification Code')
            ->view('emails.otp');
    }
}

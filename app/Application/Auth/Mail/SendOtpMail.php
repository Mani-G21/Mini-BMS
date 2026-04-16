<?php

namespace App\Application\Auth\Mail;

use App\Application\Auth\DTOs\OtpSendDTO;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public OtpSendDTO $dto)
    {
        //
    }

    public function build() 
    {
        return $this->subject('Your OTP Code')
                    ->view('emails.otp')
                    ->with(['otp' => $this->dto->otp]);
    }
}

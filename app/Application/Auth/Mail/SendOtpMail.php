<?php
    namespace App\Application\Auth\Mail;

use App\Application\Auth\DTOs\OtpSendDTO;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

    class SendOtpMail extends Mailable{
        use Queueable, SerializesModels;

        public function __construct(public OtpSendDTO $dto)
        {
            
        }

        public function build(){
            return $this->subject('Your OTP code')
                        ->view('emails.otp')
                        ->with(['otp' => $this->dto->otp]);
        }

    }
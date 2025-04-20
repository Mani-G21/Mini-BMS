<?php
    namespace App\Application\Auth\DTOs;

    class OtpSendDTO{
        public string  $email;
        public ?string $otp;

        public function __construct(array $data)
        {  
            $this->email = $data['email'];
            $this->otp = $data['otp'] ?? '0000';
        }
    }
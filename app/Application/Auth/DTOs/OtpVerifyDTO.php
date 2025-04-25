<?php

namespace App\Application\Auth\DTOs;

class OtpVerifyDTO{
    public string $email;
    public string $otp;
    public ?string $name;

    public function __construct(array $data)
    {
        $this->email = $data['email'];
        $this->otp = $data['otp'];
        $this->name = $data['name'] ?? 'Anonymous';
    }
}

<?php
namespace App\Infrastructure\Auth\Services;
use App\Application\Auth\DTOs\OtpSendDTO;
use App\Application\Auth\Mail\SendOtpMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

class OtpService{
    public function sendOtp(OtpSendDTO $dto): void{
        $otp = random_int(1000, 9999);
        $key = "otp:{$dto->email}";

        $dto->otp = $otp;

        Redis::setex($key, 300, $otp);
        Mail::to($dto->email)->send(new SendOtpMail($dto));
    }
}
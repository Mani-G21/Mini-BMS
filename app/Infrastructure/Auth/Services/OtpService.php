<?php
namespace App\Infrastructure\Auth\Services;
use App\Application\Auth\DTOs\OtpSendDTO;
use App\Application\Auth\DTOs\OtpVerifyDTO;
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

    public function verifyOtp(OtpVerifyDTO $dto){
        $key = "otp:{$dto->email}";
        $cachedOtp = Redis::get($key);

        if($cachedOtp === $dto->otp){
            Redis::expire($key, -1);
            return true;
        }

        return false;
    }
}
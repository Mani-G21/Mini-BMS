<?php
namespace App\Domain\Movie\Exceptions;

use Exception;

class MovieNotFoundException extends Exception{
    public function __construct(string $message = "Movie not found", int $code = 404, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
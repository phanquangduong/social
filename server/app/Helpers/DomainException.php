<?php

namespace App\Helpers;

use Exception;

class DomainException extends Exception
{
    protected int $httpStatus = 400;
    protected mixed $errors = null;
    protected int $errorCode = 0;

    public function __construct(string $message = '', int $httpStatus = 400, int $errorCode = 0, mixed $errors = null)
    {
        $this->httpStatus = $httpStatus;
        $this->errors = $errors;
        $this->errorCode = $errorCode;

        parent::__construct($message, $errorCode);
    }

    public function getHttpStatus(): int
    {
        return $this->httpStatus;
    }

    public function getErrors(): mixed
    {
        return $this->errors;
    }

    public function getErrorCode(): int
    {
        return $this->errorCode;
    }
}

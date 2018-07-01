<?php

namespace MyApp\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class MyAppException extends \Exception
{
    /**
     * @var array
     */
    protected $context;

    /**
     * @var string|null
     */
    protected $userMessage;

    /**
     * @var int
     */
    protected $statusCode;

    /**
     * @param string $message  Message to be reported.
     * @param array $context  Additional context to be reported.
     * @param string|null $userMessage  Message to be displayed for client.
     * @param int $statusCode  The http status code.
     * @param \Throwable|null $previous  The previous throwable used for the exception chaining.
     * @param int $code  The Exception code.
     */
    public function __construct(
        string $message = '',
        array $context = [],
        ?string $userMessage = null,
        int $statusCode = 500,
        ?\Throwable $previous = null,
        int $code = 0
    )
    {
        parent::__construct($message, $code, $previous);
        $this->context = $context;
        $this->userMessage = $userMessage;
        $this->statusCode = $statusCode;
    }

    /**
     * @return array
     */
    public function getContext(): array
    {
        return $this->context;
    }

    /**
     * @return HttpException
     */
    public function toHttpException(): HttpException
    {
        return new HttpException(
            $this->statusCode,
            $this->userMessage ?? $this->getMessage(),
            $this->getPrevious(),
            [],
            $this->code
        );
    }
}

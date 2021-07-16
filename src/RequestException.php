<?php

declare(strict_types = 1);

namespace Minibase\Net;

use Psr\Http\Client\RequestExceptionInterface;
use Psr\Http\Message\RequestInterface;
use RuntimeException;
use Throwable;

/**
 * To be thrown when a request fails to be sent.
 *
 * @author Jordan Brauer
 * @since 0.0.1
 */
final class RequestException extends RuntimeException implements RequestExceptionInterface
{
    /**
     * Create a new instance of the failed request exception.
     *
     * @param RequestInterface $request The request instance that caused the error
     * @param string $message An (optional) message to use for output and logging
     * @param int $code An (optional) error code to help classify the error
     * @param Throwable|null $previous If caught, the previously handled error that lead to this one
     */
    public function __construct(
        private RequestInterface $request,
        string $message = 'Request was unable to be sent',
        int $code = 1,
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @inheritDoc
     */
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }
}

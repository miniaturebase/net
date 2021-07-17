<?php

declare(strict_types = 1);

/**
 * This file is part of the minibase-app/net PHP library.
 *
 * @copyright 2021 Jordan Brauer <18744334+jordanbrauer@users.noreply.github.com>
 * @license MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Minibase\Net;

use Psr\Http\Client\RequestExceptionInterface;
use Psr\Http\Message\RequestInterface;
use RuntimeException;
use Throwable;

/**
 * To be thrown when a request fails to be sent.
 *
 * @author Jordan Brauer <18744334+jordanbrauer@users.noreply.github.com>
 * @since 0.0.1
 */
final class RequestFailure extends RuntimeException implements RequestExceptionInterface
{
    /**
     * Create a new instance of the failed request exception.
     *
     * @param RequestInterface $request  The request instance that caused the error
     * @param string           $message  An (optional) message to use for output and logging
     * @param int              $code     An (optional) error code to help classify the error
     * @param Throwable|null   $previous If caught, the previously handled error that lead to this one
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

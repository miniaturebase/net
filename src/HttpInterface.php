<?php

declare(strict_types = 1);

namespace Minibase\Net;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

interface HttpInterface
{
    public const GET = 'GET';

    public const HEAD = 'HEAD';

    public const POST = 'POST';

    public const PUT = 'PUT';

    public const PATCH = 'PATCH';

    public const DELETE = 'DELETE';

    public const CONNECT = 'CONNECT';

    public const OPTIONS = 'OPTIONS';

    public const TRACE = 'TRACE';

    /**
     * Informational response code.
     */
    public const CONTINUE = 100;

    /**
     * Informational response code.
     */
    public const SWITCHING_PROTOCOLS = 101;

    /**
     * Informational response code.
     */
    public const PROCESSING = 102;

    /**
     * Informational response code.
     */
    public const EARLY_HINTS = 103;

    /**
     * Successful response code.
     */
    public const OK = 200;

    /**
     * Successful response code.
     */
    public const CREATED = 201;

    /**
     * Successful response code.
     */
    public const ACCEPTED = 202;

    /**
     * Successful response code.
     */
    public const NON_AUTHORITATIVE_INFO = 203;

    /**
     * Successful response code.
     */
    public const NO_CONTENT = 204;

    /**
     * Successful response code.
     */
    public const RESET_CONTENT = 205;

    /**
     * Successful response code.
     */
    public const PARTIAL_CONTENT = 206;

    /**
     * Successful response code.
     */
    public const MULTI_STATUS = 207;

    /**
     * Successful response code.
     */
    public const ALREADY_REPORTED = 208;

    /**
     * Successful response code.
     */
    public const IM_USED = 226;

    /**
     * Redirection response code.
     */
    public const MULTIPLE_CHOICES = 300;

    /**
     * Redirection response code.
     */
    public const MOVED_PERMANENTLY = 301;

    /**
     * Redirection response code.
     */
    public const FOUND = 302;

    /**
     * Redirection response code.
     */
    public const SEE_OTHER = 303;

    /**
     * Redirection response code.
     */
    public const NOT_MODIFIED = 304;

    /**
     * Redirection response code.
     */
    public const USE_PROXY = 305;

    // TODO: 4XX codes

    /**
     * Server error response code.
     */
    public const INTERNAL_SERVER_ERROR = 500;

    /**
     * Server error response code.
     */
    public const NOT_IMPLEMENTED = 501;

    /**
     * Server error response code.
     */
    public const BAD_GATEWAY = 502;

    /**
     * Server error response code.
     */
    public const SERVICE_UNAVAILABLE = 503;

    /**
     * Server error response code.
     */
    public const GATEWAY_TIMEOUT = 504;

    /**
     * Server error response code.
     */
    public const HTTP_VERSION_NOT_SUPPORTED = 505;

    /**
     * Server error response code.
     */
    public const VARIANT_ALSO_NEGOTIATES = 506;

    /**
     * Server error response code.
     */
    public const INSUFFICIENT_STORAGE = 507;

    /**
     * Server error response code.
     */
    public const LOOP_DETECTED = 508;

    /**
     * Server error response code.
     */
    public const NOT_EXTENDED= 510;

    /**
     * Server error response code.
     */
    public const NETWORK_AUTHENTICATION_REQUIRED = 511;

    /**
     * HTTP status code reason map.
     *
     * @var array<int,string>
     */
    public const REASONS = [
        self::CONTINUE => 'Continue',
        self::SWITCHING_PROTOCOLS => 'Switching Protocols',
        self::PROCESSING => 'Processing',
        self::EARLY_HINTS => 'Early Hints',
        // TODO: ...
    ];

    /**
     * Issue an HTTP `GET` request to the given URI.
     */
    public function get(UriInterface $uri): ResponseInterface;

    /**
     * Issue an HTTP `HEAD` request to the given URI.
     */
    public function head(UriInterface $uri): ResponseInterface;

    /**
     * Issue an HTTP `POST` request to the given URI.
     */
    public function post(UriInterface $uri, string $contentType, string|StreamInterface $body): ResponseInterface;

    /**
     * Issue an HTTP `PUT` request to the given URI.
     */
    public function put(UriInterface $uri, string $contentType, string|StreamInterface $body): ResponseInterface;

    /**
     * Issue an HTTP `PATCH` request to the given URI.
     */
    public function patch(UriInterface $uri, string $contentType, string|StreamInterface $body): ResponseInterface;

    /**
     * Issue an HTTP `DELETE` request to the given URI.
     */
    public function delete(UriInterface $uri): ResponseInterface;

    /**
     * Issue an HTTP `CONNECT` request to the given URI.
     */
    public function connect(UriInterface $uri): ResponseInterface;

    /**
     * Issue an HTTP `OPTIONS` request to the given URI.
     */
    public function options(UriInterface $uri): ResponseInterface;

    /**
     * Issue an HTTP `TRACE` request to the given URI.
     */
    public function trace(UriInterface $uri): ResponseInterface;
}

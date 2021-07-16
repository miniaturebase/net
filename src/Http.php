<?php

declare(strict_types = 1);

namespace Minibase\Net;

use Closure;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use RuntimeException;
use TypeError;

/**
 * Make HTTP network requests
 */
final class Http implements ClientInterface, HttpInterface
{
    /**
     * Create a new HTTP handler.
     *
     * @param Closure<RequestInterface> $request PSR-7 request instance factory
     * @param Closure<ResponseInterface> $request PSR-7 response instance factory
     */
    public function __construct(
        /**
         * PSR-7 request instance factory.
         *
         * @var Closure<RequestInterface>
         */
        private Closure $request,

        /**
         * PSR-7 response instance factory.
         *
         * @var Closure<ResponseInterface>
         */
        private Closure $response,
    ) {
        // ...
    }

    /**
     * New request factory.
     */
    public function request(string $method = '', ?UriInterface $uri = null): RequestInterface
    {
        $response = ($this->request)($method, $uri);

        if (!empty(trim($method))) {
            $response = $response->withMethod($method);
        }

        if ($uri) {
            $response = $response->withUri($uri);
        }

        return $response;
    }

    /**
     * New response factory.
     *
     * @param string|resource|StreamInterface $body
     * @param int $code
     * @param array<string,mixed> $headers
     */
    public function response(mixed $body, int $code, array $headers = []): ResponseInterface
    {
        if (!\is_string($body) and !\is_resource($body) and !$body instanceof StreamInterface) {
            throw new TypeError(sprintf(
                'Arguments 1 passed to %s must be of the type %s, %s given',
                __FUNCTION__,
                implode('|', ['string', 'resource', StreamInterface::class]),
                gettype($body),
            ));
        }

        return ($this->response)($body, $code, $headers);
    }

    /**
     * @inheritDoc
     */
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $handle = curl_init((string) $request->getUri());

        if (false === $handle) {
            // FIXME: interface PSR-18 exception
            throw new RuntimeException('Unable to make request!');
        }

        $method = strtoupper($request->getMethod());
        $headers = $request->getHeaders();

        if ($method === self::GET) {
            curl_setopt($handle, CURLOPT_HTTPGET, true);
        } else if (self::POST === $method) {
            curl_setopt($handle, CURLOPT_POST, true);
        } else {
            curl_setopt($handle, CURLOPT_CUSTOMREQUEST, $method);
        }

        if (in_array($method, [self::POST, self::PUT, self::PATCH], true)) {
            curl_setopt($handle, CURLOPT_POSTFIELDS, $request->getBody()->getContents());
        }

        curl_setopt_array($handle, [
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 8,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER => array_map(
                static fn (string $header, array $values) => sprintf(
                    '%s: %s',
                    $header,
                    implode(',', $values),
                ),
                array_keys($headers),
                $headers,
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
        ]);

        $response = curl_exec($handle);
        $error = array_filter([curl_errno($handle), curl_error($handle)]);

        curl_close($handle);

        if (false === $response or !empty($error)) {
            // FIXME: interface PSR-18 exception
            throw new RuntimeException('Unable to complete request!');
        }
        # CURLINFO_EFFECTIVE_URL
        # CURLINFO_REQUEST_SIZE

        return $this->response($response, curl_getinfo($handle, CURLINFO_RESPONSE_CODE), []);
    }

    /**
     * @inheritDoc
     */
    public function get(UriInterface $uri): ResponseInterface
    {
        return $this->sendRequest($this->request()->withMethod(self::GET)->withUri($uri));
    }

    /**
     * @inheritDoc
     */
    public function head(UriInterface $uri): ResponseInterface
    {
        return $this->sendRequest($this->request()->withMethod(self::HEAD)->withUri($uri));
    }

    /**
     * @inheritDoc
     */
    public function post(UriInterface $uri, string $contentType, string|StreamInterface $body): ResponseInterface
    {
        $request = $this
            ->request()
            ->withMethod(self::POST)
            ->withUri($uri)
            ->withHeader('content-type', $contentType);

        if (\is_string($body)) {
            $request->getBody()->write($body);
            $request->getBody()->rewind();
        } else {
            $request->withBody($body);
        }

        return $this->sendRequest($request);
    }

    /**
     * @inheritDoc
     */
    public function put(UriInterface $uri, string $contentType, string|StreamInterface $body): ResponseInterface
    {
        return $this->sendRequest($this->request());
    }

    /**
     * @inheritDoc
     */
    public function patch(UriInterface $uri, string $contentType, string|StreamInterface $body): ResponseInterface
    {
        return $this->sendRequest($this->request());
    }

    /**
     * @inheritDoc
     */
    public function delete(UriInterface $uri): ResponseInterface
    {
        return $this->sendRequest($this->request());
    }

    /**
     * @inheritDoc
     */
    public function connect(UriInterface $uri): ResponseInterface
    {
        return $this->sendRequest($this->request());
    }

    /**
     * @inheritDoc
     */
    public function options(UriInterface $uri): ResponseInterface
    {
        return $this->sendRequest($this->request());
    }

    /**
     * @inheritDoc
     */
    public function trace(UriInterface $uri): ResponseInterface
    {
        return $this->sendRequest($this->request());
    }
}

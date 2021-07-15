<?php

declare(strict_types = 1);

namespace Minibase\Net;

use Closure;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;

final class Http implements ClientInterface, HttpInterface
{
    public function __construct(
        private Closure $request,
        private Closure $response,
    ) {
        // ...
    }

    /**
     * New request factory.
     */
    public function request(): RequestInterface
    {
        return ($this->request)();
    }

    /**
     * New response factory.
     */
    public function response($body, int $code, array $headers = []): ResponseInterface
    {
        return ($this->response)($body, $code, $headers);
    }

    /**
     * @inheritDoc
     */
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        # dd($request);

        $curl = curl_init((string) $request->getUri());

        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
        ]);

        $response = curl_exec($curl);

        return $this->response($response, curl_getinfo($curl, CURLINFO_RESPONSE_CODE), []);
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
    public function post(UriInterface $uri, string $contentType, StreamInterface $body): ResponseInterface
    {
        return $this->sendRequest(
            $this->request()
                ->withMethod(self::POST)
                ->withUri($uri)
                ->withAddedHeader('content-type', $contentType)
                ->withBody($body)
        );
    }

    /**
     * @inheritDoc
     */
    public function put(UriInterface $uri, string $contentType, StreamInterface $body): ResponseInterface
    {
    }

    /**
     * @inheritDoc
     */
    public function patch(UriInterface $uri, string $contentType, StreamInterface $body): ResponseInterface
    {
    }

    /**
     * @inheritDoc
     */
    public function delete(UriInterface $uri): ResponseInterface
    {
    }

    /**
     * @inheritDoc
     */
    public function connect(UriInterface $uri): ResponseInterface
    {
    }

    /**
     * @inheritDoc
     */
    public function options(UriInterface $uri): ResponseInterface
    {
    }

    /**
     * @inheritDoc
     */
    public function trace(UriInterface $uri): ResponseInterface
    {
    }
}

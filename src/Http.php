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

use Closure;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;
use TypeError;

/**
 * Make HTTP network requests.
 *
 * @author Jordan Brauer <18744334+jordanbrauer@users.noreply.github.com>
 * @since 0.0.1
 */
final class Http implements HttpSpecification, ClientInterface, RequestFactoryInterface, ResponseFactoryInterface
{
    # /**
    #  * Network transport implementation, such as cURL, streams, etc.
    #  */
    # private $transport;

    private ?string $body;

    /**
     * Create a new HTTP handler.
     *
     * @param Closure<RequestInterface>  $request PSR-17 request instance factory which generates PSR-7 requests
     * @param Closure<ResponseInterface> $request PSR-17 response instance factory which generates PSR-7 responses
     */
    public function __construct(
        private Closure $request,
        private Closure $response,
    ) {
        # $this->transport = new Curl();
    }

    /**
     * @inheritDoc
     */
    public function connect(UriInterface $uri): ResponseInterface
    {
        return $this->sendRequest($this->createRequest(self::CONNECT, $uri));
    }

    /**
     * @inheritDoc
     */
    public function createRequest(string $method, $uri): RequestInterface
    {
        if (!\is_string($uri) and !$uri instanceof UriInterface) {
            throw new TypeError(sprintf(
                'Arguments 2 passed to %s must be of the type %s, %s given',
                __FUNCTION__,
                implode('|', ['string', UriInterface::class]),
                gettype($uri),
            ));
        }

        return ($this->request)($method, $uri);
    }

    /**
     * @inheritDoc
     */
    public function createResponse(int $code = 200, string $reasonPhrase = ''): ResponseInterface
    {
        return ($this->response)($this->body, $code, $reasonPhrase);
    }

    /**
     * @inheritDoc
     */
    public function delete(UriInterface $uri): ResponseInterface
    {
        return $this->sendRequest($this->createRequest(self::DELETE, $uri));
    }

    /**
     * @inheritDoc
     */
    public function get(UriInterface $uri): ResponseInterface
    {
        return $this->sendRequest($this->createRequest(self::GET, $uri));
    }

    /**
     * @inheritDoc
     */
    public function head(UriInterface $uri): ResponseInterface
    {
        return $this->sendRequest($this->createRequest(self::HEAD, $uri));
    }

    /**
     * @inheritDoc
     */
    public function options(UriInterface $uri): ResponseInterface
    {
        return $this->sendRequest($this->createRequest(self::OPTIONS, $uri));
    }

    /**
     * @inheritDoc
     */
    public function patch(UriInterface $uri, string|StreamInterface $body): ResponseInterface
    {
        return $this->mutation($this->createRequest(self::PATCH, $uri), $body);
    }

    /**
     * @inheritDoc
     */
    public function post(UriInterface $uri, string|StreamInterface $body): ResponseInterface
    {
        return $this->mutation($this->createRequest(self::POST, $uri), $body);
    }

    /**
     * @inheritDoc
     */
    public function put(UriInterface $uri, string|StreamInterface $body): ResponseInterface
    {
        return $this->mutation($this->createRequest(self::PUT, $uri), $body);
    }

    /**
     * @inheritDoc
     */
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        # IDEA: abstract transports akin to Guzzle handlers (curl, streams, etc)
        $handle = curl_init((string) $request->getUri());

        if (false === $handle) {
            throw new RequestFailure($request);
        }

        $method = strtoupper(trim($request->getMethod()));
        $headers = $request->getHeaders();

        if (self::GET === $method) {
            curl_setopt($handle, CURLOPT_HTTPGET, true);
        } elseif (self::POST === $method) {
            curl_setopt($handle, CURLOPT_POST, true);
        } else {
            curl_setopt($handle, CURLOPT_CUSTOMREQUEST, $method);
        }

        if (in_array($method, [self::POST, self::PUT, self::PATCH], true)) {
            curl_setopt(
                $handle,
                CURLOPT_POSTFIELDS,
                $request->getBody()->getContents()
            );
        }

        curl_setopt_array($handle, [
            CURLOPT_ENCODING     => '',
            CURLOPT_MAXREDIRS    => 8,
            CURLOPT_TIMEOUT      => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER   => array_map(
                static fn (string $header, array $values) => sprintf('%s: %s', $header, implode(',', $values)),
                array_keys($headers),
                $headers,
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => self::HEAD === $method, # TODO: parse headers manually
        ]);

        $transfer = curl_exec($handle);
        $code = curl_errno($handle);
        $error = array_filter([$code, (0 < $code) ? curl_strerror($code) : null]);

        curl_close($handle);

        if (false === $transfer or !empty($error)) {
            throw new NetworkError(
                $request,
                sprintf('(%d) %s', $error[0], $error[1]),
                $error[0],
            );
        }

        # CURLINFO_EFFECTIVE_URL
        # CURLINFO_REQUEST_SIZE
        $code = curl_getinfo($handle, CURLINFO_RESPONSE_CODE);
        $this->body = $transfer;

        return $this->createResponse($code, self::PHRASES[$code] ?? '');
    }

    /**
     * @inheritDoc
     */
    public function trace(UriInterface $uri): ResponseInterface
    {
        return $this->sendRequest($this->createRequest(self::TRACE, $uri));
    }

    private function mutation(RequestInterface $request, string|StreamInterface $body): ResponseInterface
    {
        if ($body instanceof StreamInterface) {
            $request->withBody($body);
        } else {
            $request->getBody()->write($body);
            $request->getBody()->rewind();
        }

        return $this->sendRequest($request);
    }
}

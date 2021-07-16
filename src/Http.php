<?php

declare(strict_types = 1);

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
 * @author Jordan Brauer
 * @since 0.0.1
 */
final class Http implements HttpInterface, ClientInterface, RequestFactoryInterface, ResponseFactoryInterface
{
    # /**
    #  * Network transport implementation, such as cURL, streams, etc.
    #  */
    # private $transport;

    private $body;

    /**
     * Create a new HTTP handler.
     *
     * @param Closure<RequestInterface> $request PSR-17 request instance factory which generates PSR-7 requests
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
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        # IDEA: abstract transports akin to Guzzle handlers (curl, streams, etc)
        $handle = curl_init((string) $request->getUri());

        if (false === $handle) {
            throw new RequestException($request);
        }

        $method = strtoupper(trim($request->getMethod()));
        $headers = $request->getHeaders();

        if ($method === self::GET) {
            curl_setopt($handle, CURLOPT_HTTPGET, true);
        } else if (self::POST === $method) {
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
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 8,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER => array_map(
                static fn (string $header, array $values) =>
                    sprintf('%s: %s', $header, implode(',', $values)),
                array_keys($headers),
                $headers,
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => self::HEAD === $method, # TODO: parse headers manually
        ]);

        $transfer = curl_exec($handle);
        $code = curl_errno($handle);
        $error = array_filter([$code, (0 < $code) ? curl_strerror($code) : null]);

        curl_close($handle);

        if (false === $transfer or !empty($error)) {
            throw new NetworkException(
                $request,
                sprintf('(%d) %s', $error[0], $error[1]),
                $error[0],
            );
        }

        # CURLINFO_EFFECTIVE_URL
        # CURLINFO_REQUEST_SIZE
        $code = curl_getinfo($handle, CURLINFO_RESPONSE_CODE);
        $this->body = $transfer;
        $response = $this->createResponse($code, self::PHRASES[$code] ?? '');

        return $response;
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
    public function post(UriInterface $uri, string|StreamInterface $body): ResponseInterface
    {
        $request = $this->createRequest(self::POST, $uri);

        if ($body instanceof StreamInterface) {
            $request->withBody($body);
        } else {
            $request->getBody()->write($body);
            $request->getBody()->rewind();
        }

        return $this->sendRequest($request);
    }

    /**
     * @inheritDoc
     */
    public function put(UriInterface $uri, string|StreamInterface $body): ResponseInterface
    {
        $request = $this->createRequest(self::PUT, $uri);

        if ($body instanceof StreamInterface) {
            $request->withBody($body);
        } else {
            $request->getBody()->write($body);
            $request->getBody()->rewind();
        }

        return $this->sendRequest($request);
    }

    /**
     * @inheritDoc
     */
    public function patch(UriInterface $uri, string|StreamInterface $body): ResponseInterface
    {
        $request = $this->createRequest(self::PATCH, $uri);

        if ($body instanceof StreamInterface) {
            $request->withBody($body);
        } else {
            $request->getBody()->write($body);
            $request->getBody()->rewind();
        }

        return $this->sendRequest($request);
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
    public function connect(UriInterface $uri): ResponseInterface
    {
        return $this->sendRequest($this->createRequest(self::CONNECT, $uri));
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
    public function trace(UriInterface $uri): ResponseInterface
    {
        return $this->sendRequest($this->createRequest(self::TRACE, $uri));
    }

    /**
     * Issue a GraphQL query request.
     *
     * @param string $query The GraphQL query string
     * @param array<string,mixed> $variables Query variables to be included
     * @param string $operationName Specified operation. Only required if multiple operations are present in the query
     */
    public function graphql(string $query, array $variables = [], string $operationName = ''): ResponseInterface
    {
        # FIXME: request factory doesn't work so hot here for the URI
        return $this->post(
            $this->createRequest(self::POST, '')->getUri(),
            'application/json',
            json_encode(array_filter(compact(
                'query',
                'variables',
                'operationName'
            ))),
        );
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
}

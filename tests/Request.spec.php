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

use Laminas\Diactoros\Request;
use Laminas\Diactoros\Response\TextResponse;
use Laminas\Diactoros\Uri;
use Minibase\Net\Http;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

/**
 * This file is part of the minibase-app/net PHP library.
 *
 * @copyright 2021 Jordan Brauer <18744334+jordanbrauer@users.noreply.github.com>
 * @license MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
it('creates requests', function (string $method): void {
    $http = new Http(
        fn (string $verb, string $uri): RequestInterface => new Request($uri, $verb),
        fn () => null,
    );
    $uri = 'http://localhost';
    $request = $http->createRequest($method, $uri);

    expect($request)
        ->toBeInstanceOf(Request::class)
        ->and($request->getMethod())
        ->toBe($method)
        ->and((string) $request->getUri())
        ->toBe($uri);
})->with(
    'verbs',
);

it('sends requests', function (string $method): void {
    match ($method) {
        Http::HEAD    => $this->markTestSkipped('seems to cause infinite loop with dev server'),
        Http::CONNECT => $this->markTestSkipped('hangs forever with dev server – need to address'),
        default       => null,
    };

    $http = new Http(
        fn (string $verb, UriInterface $uri): RequestInterface => new Request($uri, $verb),
        fn (string|StreamInterface $body): ResponseInterface => new TextResponse($body),
    );
    $uri = new Uri('http://localhost/');
    $request = $http->createRequest($method, $uri->withPort(8080));
    $response = $http->sendRequest($request);

    expect($response)
        ->toBeInstanceOf(TextResponse::class)
        ->and($response->getStatusCode())
        ->toBe(Http::OK)
        ->and($response->getHeaderLine('content-type'))
        ->toContain('text/plain')
        ->and($response->getBody()->getContents())
        ->toBe("Hello, World!\n");
})->skip(
    serverless(),
    'Requires the dev server to be running',
)->with(
    'verbs',
);

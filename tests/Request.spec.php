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
use Laminas\Diactoros\Response;
use Minibase\Net\Http;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

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
        fn (): ResponseInterface => new Response(),
    );
    $uri = 'https://google.ca';
    $request = $http->createRequest($method, $uri);

    expect($request)
        ->toBeInstanceOf(Request::class)
        ->and($request->getMethod())
        ->toBe($method)
        ->and((string) $request->getUri())
        ->toBe($uri);
})->with([
    Http::GET     => [Http::GET],
    Http::POST    => [Http::POST],
    Http::PUT     => [Http::PUT],
    Http::PATCH   => [Http::PATCH],
    Http::HEAD    => [Http::HEAD],
    Http::OPTIONS => [Http::OPTIONS],
    Http::TRACE   => [Http::TRACE],
    Http::CONNECT => [Http::CONNECT],
]);

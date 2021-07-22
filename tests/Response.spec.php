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
it('creates responses', function (int $code, string $reason): void {
    $http = new Http(
        fn (): RequestInterface => new Request(),
        fn ($_, int $status): ResponseInterface => new Response(status: $status),
    );
    $response = $http->createResponse($code, $reason);

    expect($response)
        ->toBeInstanceOf(Response::class)
        ->and($response->getStatusCode())
        ->toBe($code)
        ->and($response->getReasonPhrase())
        ->toBe($reason);
})->with(
    'codes.all',
);

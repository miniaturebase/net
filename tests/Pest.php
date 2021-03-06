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
use Minibase\Net\NetworkError;

/**
 * This file is part of the minibase-app/net PHP library.
 *
 * @copyright 2021 Jordan Brauer <18744334+jordanbrauer@users.noreply.github.com>
 * @license MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Return a closure that checks if the dev server is running.
 */
function serverless(): Closure
{
    $http = new Http(
        fn ($verb, $uri) => new Request($uri, $verb),
        fn ($body, $code) => new TextResponse($body, $code),
    );
    $server = new Uri('http://localhost:8080');

    return function () use ($http, $server) {
        $serverless = false;

        try {
            $http->get($server);
        } catch (NetworkError $caught) {
            $serverless = true;
        }

        return $serverless;
    };
}

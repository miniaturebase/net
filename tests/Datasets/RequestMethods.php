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

use Minibase\Net\Http;

dataset('verbs', fn (): Generator => yield from [
    Http::CONNECT => Http::CONNECT,
    Http::DELETE  => Http::DELETE,
    Http::GET     => Http::GET,
    Http::HEAD    => Http::HEAD,
    Http::OPTIONS => Http::OPTIONS,
    Http::PATCH   => Http::PATCH,
    Http::POST    => Http::POST,
    Http::PUT     => Http::PUT,
    Http::TRACE   => Http::TRACE,
]);

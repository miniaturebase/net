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
use Minibase\Net\Http;
use PhpBench\Attributes as Bench;

class HttpBench
{
    #[Bench\Assert('mode(variant.time.avg) < 200 ms')]
    public function benchCreateRequests()
    {
        $http = new Http(fn () => new Request(), fn () => null);
        $http->createRequest(Http::GET, 'http://localhost');
    }
}

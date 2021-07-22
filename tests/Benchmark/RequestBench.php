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
use Laminas\Diactoros\Uri;
use Minibase\Net\Http;
use PhpBench\Attributes as Bench;

class RequestBench
{
    private Http $http;

    private Request $request;

    private Uri $uri;

    public function setUp(): void
    {
        $this->uri = new Uri('http://localhost:8080');
        $this->http = new Http(
            fn (string $method, Uri $uri): Request => new Request($uri, $method),
            fn ($_, int $code): Response => new Response(status: $code),
        );
    }

    #[Bench\BeforeMethods('setUp')]
    #[Bench\Assert('mode(variant.time.avg) < 200 ms')]
    public function benchCreateRequest()
    {
        $this->http->createRequest(Http::GET, $this->uri);
    }

    #[Bench\BeforeMethods('setUp')]
    #[Bench\Assert('mode(variant.time.avg) < 200 ms')]
    public function benchSendRequest()
    {
        $this->http->sendRequest($this->makeRequest());
    }

    private function makeRequest(): Request
    {
        return $this->request ??= $this->http->createRequest(Http::GET, $this->uri);
    }
}

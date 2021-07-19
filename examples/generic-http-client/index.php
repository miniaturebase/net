<?php

declare(strict_types = 1);

require_once __DIR__ . '/../../vendor/autoload.php';

use Laminas\Diactoros\Request;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Uri;
use Minibase\Net\Http;

$http = new Http(
    fn (string $method, Uri $uri): Request => new Request($uri, $method),
    function (string $body, int $code): Response {
        $response = new Response(status: $code);

        $response->getBody()->write($body);
        $response->getBody()->rewind();

        return $response;
    }
);

$google = new Uri('https://www.google.ca');

$response = $http->get($google);

dump($response->getStatusCode());

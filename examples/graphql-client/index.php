<?php

declare(strict_types = 1);

require_once __DIR__ . '/../../vendor/autoload.php';

use Laminas\Diactoros\Request;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\Uri;
use Minibase\Net\Http;

# store a generic Http instance and your API details in some container
$config = [
    'graphql' => 'https://countries.trevorblades.com/'
];
$container = [
    'http' => new Http(
        fn (string $method, Uri $uri): Request => new Request($uri, $method, headers: ['content-type' => 'application/json']),
        fn (string $data, int $code): JsonResponse => new JsonResponse(json_decode($data), $code),
    ),
    'graphql' => new Uri($config['graphql']),
];

# abstract HTTP with some kind of GraphQL service
function graphql(string $query, array $variables = [], string $operationName = ''): mixed
{
    # fetch Http & Uri instances from container
    /**
     * @var Http $http
     * @var Uri $graphql
     */
    global $container;

    $http = $container['http'];
    $graphql = $container['graphql'];

    /**
     * @var JsonResponse $response
     */
    $response = $http->post($graphql, json_encode(compact('query', 'variables', 'operationName')));

    return $response->getPayload();
}

$query = file_get_contents(__DIR__ . '/currency.query.graphql');
$variables = ['country' => 'CA'];

dump(graphql($query, $variables));

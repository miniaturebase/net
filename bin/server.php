<?php

declare(strict_types = 1);

use Laminas\Diactoros\ServerRequestFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$request = ServerRequestFactory::fromGlobals($_SERVER, $_GET, $_POST, $_COOKIE, $_FILES);

print_r(json_encode([
    'server' => $request->getServerParams(),
    'headers' => $request->getHeaders(),
    'input' => file_get_contents('php://input'),
    'query' => $request->getQueryParams(),
]));

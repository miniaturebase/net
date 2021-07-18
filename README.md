# Net

A small, modern, [PSR-7](https://www.php-fig.org/psr/psr-7/) compatible
[PSR-17](https://www.php-fig.org/psr/psr-17/) and
[PSR-18](https://www.php-fig.org/psr/psr-18/) network library for PHP, inspired
by [Go's `net`](https://pkg.go.dev/golang.org/x/net) package.

**Features:**

- No hard dependencies;
- Favours a [BYOB](https://en.wikipedia.org/wiki/BYOB) approach to requests & responses;
- _Zero configuration_ – pure data and interfaces;
- Testing with third-party APIs made easy;

## Setup

Some basic instructions on how to use this in your own project, or contribute to it as a develper.

### Requirements

- PHP `>=8.0`;
- _Any_ PSR-7 HTTP message implementation;

### Installation

Use composer and access it via your autoloader.

```bash
composer require minibase-app/net
```

**For Contributors:**

Clone the repository and install the development tools to begin running tests for your features & bug fixes.

```bash
git clone https://github.com/minibase-app/net.git \
  && cd ./net \
  && make vendor;
```

## Usage

Here is a snippet which details the most basic setup and usage of the library.

As mentioned earlier in the _Requirements_ and _Features_, you can use any PSR-7
implementation of your choosing. In all examples from here on out we use Laminas
for demonstration, but anything is fine, either hand-rolled or from another library.

```php
use Laminas\Diactoros\{ Request, Response, Uri };
use Minibase\Net\Http;
use Psr\Http\Message\{ RequestInterface, ResponseInterface, UriInterface };

# Initiate a new HTTP instance with PSR-17 requesst & response factory closures
$http = new Http(
    fn (string $method, UriInterface $uri): RequestInterface =>
        new Request($uri, $method),
    fn (mixed $body, int $code, string $reason): ResponseInterface =>
        new Response($body, $code),
);

# Store and fetch a URI instance of your API base URL
$api = new Uri('http://localhost/api');

# Make a request to (any) API and specify resources, queries, etc.
$response = $http->get($api->withPath('users')->withQuery('?_limit=1'));

# Introspect your response
$successful = Http::OK === $response->getStatusCode();
```

If this isn't a good enough explanation of how this works, don't worry – we will
cover each piece in detail next.

### Creating a New HTTP Instance

Because this library does not provide (yet another) PSR-7 implemenation, you
**MUST** supply one yourself. This means you can make one, use your
company's implementation, or pick your favourite package from the community –
in any case it doesn't matter, we only care about the interface.

Once you have a PSR-7 implementation it is time to tell the `Http` class how it
should create requests and responses. This is probably the best part of the
library; unlike traditional PHP HTTP "client" libraries, this one does not try
to abstract the request/response away into array-based configuration, but
instead uses them **_as_** a configuration. In other words, _your request is
 it's command_, literally...

Let's take a look.

```php
# Here we will make a simple JSON REST API implementation
# Notice that $request and $response are merely PSR-17 factories!
$request = fn (string $method, UriInterface $uri): RequestInterface =>
    new Request($method, $uri, headers: ['content-type' => 'application/json']);
$response = fn (array $body, int $code, string $reason): ResponseInterface =>
    new JsonResponse($body, $code);
$http = new Http($request, $response);
```

The astute of you, however, will have noticed that the `$response` closure does
not quite adhere to the [PSR-17 `ResponseFactoryInterface`](https://www.php-fig.org/psr/psr-17/),
as it actually receives a body before it gets the code and reason. Rest assured,
this interface violation is only present here at the constructor – the
`Http::createResponse` method is implemented as expected, and is done so that
you can format as per your requirements.

### APIs as URIs

Most HTTP "client" libraries will have some sort of method signature that asks
for a URL/endpoint as a string, and provide optional parameters for a query
(`GET` parameters). Often, this can lead to improper use the library by
developers placing query parameters directly into the URL/endpoint parameter,
using varrying methods of string concatenation and interpolation, leading to
unstandardized, and messy code.

In an attempt to prevent this sort of inconsistency from happening (among others
you may have experienced), URLs have been done away with in favour of
first-class `UriInterface` instances.

```php
# Store this or a factory for it anywhere along with other API details, like
# auth, headers, etc.!
$github = new Uri('https://api.github.com');
```

Seems underwhelming at first, but when used with an `Http` instance configured
with some kind of JSON response, we get a fluid and well read set of API calls
in our code.

### Making Requests

Continuing with the examples from above, let's make a request for a GitHub user
profile with ease and style.

```php
$user = $http
  ->get($github->withPath('users/tpope'))
  ->getPayload();
```

This reads exceptionally well and can be further abstracted as needed, providing
an experience much closer to Redis, query builders, and fluid interfaces alike,
as opposed to traditional HTTP "client" packages.

## Motivation

> _Yeah, but like ... why?_

Good question, and similarly answered; _why not_? More specifically, and perhaps
more seriously, HTTP clients in PHP appear to have a history of being designed
very similarily, create their own array-based configuartions, throw exceptions
for valid HTTP responses, and have a "top down" approach to creating a client
  (e.g., `new Client('http://api.acme.io')`) that can force you to need multiple
instances for multiple APIs, all resulting in a cumbersome developer &
maintenance experience.

Another point that this library attempts to address is _The "Client"_. We've all
had the experience of importing multiple `Client` classes, aliasing and
extending all over the place. "Client" is an amiguous term, similarly to `data`,
and `params`, essentially meaningless and not even HTTP specific (a client of
_what_?). Inspired by Go's `net` package, `Http` just seems like a perfect fit.

Aside from design & usage differences, Net attempts to maintain a slim,
concrete, no dependency (PSRs aside), based API that won't result in dependency
conflicts during a large-scale project upgrade, that can often happen with
legacy projects catching up with latest versions.

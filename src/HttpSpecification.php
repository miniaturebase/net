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

namespace Minibase\Net;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

/**
 * An HTTP communication specification.
 *
 * @author Jordan Brauer <18744334+jordanbrauer@users.noreply.github.com>
 * @since v0.0.1
 */
interface HttpSpecification
{
    /**
     * The HyperText Transfer Protocol (HTTP) 202 Accepted response status code
     * indicates that the request has been accepted for processing, but the
     * processing has not been completed; in fact, processing may not have
     * started yet. The request might or might not eventually be acted upon, as
     * it might be disallowed when processing actually takes place.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/202
     */
    public const ACCEPTED = 202;

    /**
     * Used inside a <dav:propstat> response element to avoid repeatedly
     * enumerating the internal members of multiple bindings to the same
     * collection.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     * @see https://httpstatuses.com/208
     */
    public const ALREADY_REPORTED = 208;

    /**
     * The HyperText Transfer Protocol (HTTP) 502 Bad Gateway server error
     * response code indicates that the server, while acting as a gateway or
     * proxy, received an invalid response from the upstream server.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/502
     */
    public const BAD_GATEWAY = 502;

    /**
     * The HyperText Transfer Protocol (HTTP) 400 Bad Request response status
     * code indicates that the server cannot or will not process the request due
     * to something that is perceived to be a client error (e.g., malformed
     * request syntax, invalid request message framing, or deceptive request
     * routing).
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/400
     */
    public const BAD_REQUEST = 400;

    /**
     * A non-standard status code introduced by nginx for the case when a client
     * closes the connection while nginx is processing the request.
     *
     * @see https://httpstatuses.com/499
     */
    public const CLIENT_CLOSED_REQUEST = 499;

    /**
     * The HTTP 409 Conflict response status code indicates a request conflict
     * with current state of the target resource.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/409
     */
    public const CONFLICT = 409;

    /**
     * The HTTP CONNECT method starts two-way communications with the requested
     * resource. It can be used to open a tunnel.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/CONNECT
     */
    public const CONNECT = 'CONNECT';

    /**
     * A non-standard status code used to instruct nginx to close the connection
     * without sending a response to the client, most commonly used to deny
     * malicious or malformed requests.
     *
     * @see https://httpstatuses.com/444
     */
    public const CONNECTION_CLOSED_WITHOUT_RESPONSE = 444;

    /**
     * The HTTP 100 Continue informational status response code indicates that
     * everything so far is OK and that the client should continue with the
     * request or ignore it if it is already finished.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/100
     */
    public const CONTINUE = 100;

    /**
     * The HTTP 201 Created success status response code indicates that the
     * request has succeeded and has led to the creation of a resource. The new
     * resource is effectively created before this response is sent back and the
     * new resource is returned in the body of the message, its location being
     * either the URL of the request, or the content of the Location header.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/201
     */
    public const CREATED = 201;

    /**
     * The HTTP DELETE request method deletes the specified resource.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/DELETE
     */
    public const DELETE = 'DELETE';

    /**
     * The HTTP 103 Early Hints information response status code is primarily
     * intended to be used with the Link header to allow the user agent to start
     * preloading resources while the server is still preparing a response.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/103
     */
    public const EARLY_HINTS = 103;

    /**
     * The HTTP 417 Expectation Failed client error response code indicates that
     * the expectation given in the request's Expect header could not be met.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/417
     */
    public const EXPECTATION_FAILED = 417;

    /**
     * The method could not be performed on the resource because the requested
     * action depended on another action and that action failed.
     *
     * @see https://httpstatuses.com/424
     */
    public const FAILED_DEPENDENCY = 424;

    /**
     * The HTTP 403 Forbidden client error status response code indicates that
     * the server understood the request but refuses to authorize it.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/403
     */
    public const FORBIDDEN = 403;

    /**
     * The HyperText Transfer Protocol (HTTP) 302 Found redirect status response
     * code indicates that the resource requested has been temporarily moved to
     * the URL given by the Location header. A browser redirects to this page
     * but search engines don't update their links to the resource (in
     * 'SEO-speak', it is said that the 'link-juice' is not sent to the new
     * URL).
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/302
     */
    public const FOUND = 302;

    /**
     * The HyperText Transfer Protocol (HTTP) 504 Gateway Timeout server error
     * response code indicates that the server, while acting as a gateway or
     * proxy, did not get a response in time from the upstream server that it
     * needed in order to complete the request.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/504
     */
    public const GATEWAY_TIMEOUT = 504;

    /**
     * The **HTTP `GET` method** requests a representation of the specified
     * resource. Requests using `GET` should only be used to request data (they
     * shouldn't include data).
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/GET
     */
    public const GET = 'GET';

    /**
     * The HyperText Transfer Protocol (HTTP) 410 Gone client error response
     * code indicates that access to the target resource is no longer available
     * at the origin server and that this condition is likely to be permanent.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/410
     */
    public const GONE = 410;

    /**
     * The HTTP HEAD method requests the headers that would be returned if the
     * HEAD request's URL was instead requested with the HTTP GET method. For
     * example, if a URL might produce a large download, a HEAD request could
     * read its Content-Length header to check the filesize without actually
     * downloading the file.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/HEAD
     */
    public const HEAD = 'HEAD';

    /**
     * The HyperText Transfer Protocol (HTTP) 505 HTTP Version Not Supported
     * response status code indicates that the HTTP version used in the request
     * is not supported by the server.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/505
     */
    public const HTTP_VERSION_NOT_SUPPORTED = 505;

    /**
     * The HTTP 418 I'm a teapot client error response code indicates that the
     * server refuses to brew coffee because it is, permanently, a teapot. A
     * combined coffee/tea pot that is temporarily out of coffee should instead
     * return 503.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/418
     */
    public const IM_A_TEAPOT = 418;

    /**
     * The server has fulfilled a GET request for the resource, and the response
     * is a representation of the result of one or more instance-manipulations
     * applied to the current instance.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     * @see https://httpstatuses.com/226
     */
    public const IM_USED = 226;

    /**
     * The HyperText Transfer Protocol (HTTP) 507 Insufficient Storage response
     * status code may be given in the context of the Web Distributed Authoring
     * and Versioning (WebDAV) protocol (see RFC 4918).
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/507
     * @see https://datatracker.ietf.org/doc/html/rfc4918
     */
    public const INSUFFICIENT_STORAGE = 507;

    // TODO: 4XX codes

    /**
     * The HyperText Transfer Protocol (HTTP) 500 Internal Server Error server
     * error response code indicates that the server encountered an unexpected
     * condition that prevented it from fulfilling the request.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/500
     */
    public const INTERNAL_SERVER_ERROR = 500;

    /**
     * The HyperText Transfer Protocol (HTTP) 411 Length Required client error
     * response code indicates that the server refuses to accept the request
     * without a defined Content-Length header.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/411
     */
    public const LENGTH_REQUIRED = 411;

    /**
     * The source or destination resource of a method is locked.
     *
     * @see https://httpstatuses.com/423
     */
    public const LOCKED = 423;

    /**
     * The HyperText Transfer Protocol (HTTP) 508 Loop Detected response status
     * code may be given in the context of the Web Distributed Authoring and
     * Versioning (WebDAV) protocol.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/508
     */
    public const LOOP_DETECTED = 508;

    /**
     * The HyperText Transfer Protocol (HTTP) 405 Method Not Allowed response
     * status code indicates that the request method is known by the server but
     * is not supported by the target resource.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/405
     */
    public const METHOD_NOT_ALLOWED = 405;

    /**
     * The request was directed at a server that is not able to produce a
     * response. This can be sent by a server that is not configured to produce
     * responses for the combination of scheme and authority that are included
     * in the request URI.
     *
     * @see https://httpstatuses.com/421
     */
    public const MISDIRECTED_REQUEST = 421;

    /**
     * The HyperText Transfer Protocol (HTTP) 301 Moved Permanently redirect
     * status response code indicates that the resource requested has been
     * definitively moved to the URL given by the Location headers. A browser
     * redirects to this page and search engines update their links to the
     * resource (in 'SEO-speak', it is said that the 'link-juice' is sent to the
     * new URL).
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/301
     */
    public const MOVED_PERMANENTLY = 301;

    /**
     * Conveys information about multiple resources, for situations where
     * multiple status codes might be appropriate (WebDav).
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     * @see https://httpstatuses.com/207
     */
    public const MULTI_STATUS = 207;

    /**
     * The HTTP 300 Multiple Choices redirect status response code indicates
     * that the request has more than one possible responses. The user-agent or
     * the user should choose one of them. As there is no standardized way of
     * choosing one of the responses, this response code is very rarely used.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/300
     */
    public const MULTIPLE_CHOICES = 300;

    /**
     * The HTTP 511 Network Authentication Required response status code
     * indicates that the client needs to authenticate to gain network access.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/511
     */
    public const NETWORK_AUTHENTICATION_REQUIRED = 511;

    /**
     * The HTTP 204 No Content success status response code indicates that a
     * request has succeeded, but that the client doesn't need to navigate away
     * from its current page.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/204
     */
    public const NO_CONTENT = 204;

    /**
     * The HTTP 203 Non-Authoritative Information response status indicates that
     * the request was successful but the enclosed payload has been modified by
     * a transforming proxy from that of the origin server's 200 (OK) response .
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/203
     */
    public const NON_AUTHORITATIVE_INFO = 203;

    /**
     * The HyperText Transfer Protocol (HTTP) 406 Not Acceptable client error
     * response code indicates that the server cannot produce a response
     * matching the list of acceptable values defined in the request's proactive
     * content negotiation headers, and that the server is unwilling to supply a
     * default representation.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/406
     * @link https://www.youtube.com/watch?v=Q-WHRJPlL5g
     */
    public const NOT_ACCEPTABLE = 406;

    /**
     * The HyperText Transfer Protocol (HTTP)  510 Not Extended response status
     * code is sent in the context of the HTTP Extension Framework, defined in
     * RFC 2774.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/510
     * @see https://datatracker.ietf.org/doc/html/rfc2774
     */
    public const NOT_EXTENDED = 510;

    /**
     * The HTTP 404 Not Found client error response code indicates that the
     * server can't find the requested resource. Links that lead to a 404 page
     * are often called broken or dead links and can be subject to link rot.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/404
     * @see https://en.wikipedia.org/wiki/Link_rot
     */
    public const NOT_FOUND = 404;

    /**
     * The HyperText Transfer Protocol (HTTP) 501 Not Implemented server error
     * response code means that the server does not support the functionality
     * required to fulfill the request.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/501
     */
    public const NOT_IMPLEMENTED = 501;

    /**
     * The HTTP 304 Not Modified client redirection response code indicates that
     * there is no need to retransmit the requested resources. It is an implicit
     * redirection to a cached resource. This happens when the request method is
     * safe, like a GET or a HEAD request, or when the request is conditional
     * and uses a If-None-Match or a If-Modified-Since header.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/304
     */
    public const NOT_MODIFIED = 304;

    /**
     * The HTTP 200 OK success status response code indicates that the request
     * has succeeded. A 200 response is cacheable by default.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/200
     */
    public const OK = 200;

    /**
     * The HTTP OPTIONS method requests permitted communication options for a
     * given URL or server. A client can specify a URL with this method, or an
     * asterisk (*) to refer to the entire server.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/OPTIONS
     */
    public const OPTIONS = 'OPTIONS';

    /**
     * The HTTP 206 Partial Content success status response code indicates that
     * the request has succeeded and has the body contains the requested ranges
     * of data, as described in the Range header of the request.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/206
     */
    public const PARTIAL_CONTENT = 206;

    /**
     * The **HTTP `PATCH` request method** applies partial modifications to a
     * resource.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/PATCH
     */
    public const PATCH = 'PATCH';

    /**
     * The HTTP 413 Payload Too Large response status code indicates that the
     * request entity is larger than limits defined by server; the server might
     * close the connection or return a Retry-After header field.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/413
     */
    public const PAYLOAD_TOO_LARGE = 413;

    /**
     * The HTTP 402 Payment Required is a nonstandard client error status
     * response code that is reserved for future use. Sometimes, this code
     * indicates that the request can not be processed until the client makes a
     * payment.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/402
     */
    public const PAYMENT_REQUIRED = 402;

    /**
     * This means that the resource is now permanently located at another URI,
     * specified by the `Location:` HTTP Response header. This has the same
     * semantics as the `301 Moved Permanently` HTTP response code, with the
     * exception that the user agent _must not_ change the HTTP method used: If
     * a `POST` was used in the first request, a `POST` must be used in the
     * second request.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status#redirection_messages
     */
    public const PERMANENT_REDIRECT = 308;

    /**
     * HTTP status code reason map.
     *
     * @var array<int,string>
     */
    public const PHRASES = [
        self::CONTINUE                           => 'Continue',
        self::SWITCHING_PROTOCOLS                => 'Switching Protocols',
        self::PROCESSING                         => 'Processing',
        self::EARLY_HINTS                        => 'Early Hints',
        self::OK                                 => 'OK',
        self::CREATED                            => 'Created',
        self::ACCEPTED                           => 'Accepted',
        self::NON_AUTHORITATIVE_INFO             => 'Non-Authoritative Information',
        self::NO_CONTENT                         => 'No Content',
        self::RESET_CONTENT                      => 'Reset Content',
        self::PARTIAL_CONTENT                    => 'Partial Content',
        self::MULTI_STATUS                       => 'Multi-Status',
        self::ALREADY_REPORTED                   => 'Already Reported',
        self::IM_USED                            => 'IM Used',
        self::MULTIPLE_CHOICES                   => 'Multiple Choices',
        self::MOVED_PERMANENTLY                  => 'Moved Permanently',
        self::FOUND                              => 'Found',
        self::SEE_OTHER                          => 'See Other',
        self::NOT_MODIFIED                       => 'Not Modified',
        self::USE_PROXY                          => 'Use Proxy',
        self::SWITCH_PROXY                       => 'Switch Proxy',
        self::TEMPORARY_REDIRECT                 => 'Temporary Redirect',
        self::PERMANENT_REDIRECT                 => 'Permanent Redirect',
        self::BAD_REQUEST                        => 'Bad Request',
        self::UNAUTHORIZED                       => 'Unauthorized',
        self::PAYMENT_REQUIRED                   => 'Payment Required',
        self::FORBIDDEN                          => 'Forbidden',
        self::NOT_FOUND                          => 'Not Found',
        self::METHOD_NOT_ALLOWED                 => 'Method Not Allowed',
        self::NOT_ACCEPTABLE                     => 'Not Acceptable',
        self::PROXY_AUTHENTICATION_REQUIRED      => 'Proxy Authentication Required',
        self::REQUEST_TIMEOUT                    => 'Request Timeout',
        self::CONFLICT                           => 'Conflict',
        self::GONE                               => 'Gone',
        self::LENGTH_REQUIRED                    => 'Length Required',
        self::PRECONDITION_FAILED                => 'Precondition Failed',
        self::PAYLOAD_TOO_LARGE                  => 'Payload Too Large',
        self::URI_TOO_LONG                       => 'URI Too Long',
        self::UNSUPPORTED_MEDIA_TYPE             => 'Unsupported Media Type',
        self::REQUESTED_RANGE_NOT_SATISFIABLE    => 'Range Not Satisfiable',
        self::EXPECTATION_FAILED                 => 'Expectation Failed',
        self::IM_A_TEAPOT                        => 'I\'m a teapot',
        self::MISDIRECTED_REQUEST                => 'Misdirected Request',
        self::UNPROCESSABLE_ENTITY               => 'Unprocessable Entity',
        self::LOCKED                             => 'Locked',
        self::FAILED_DEPENDENCY                  => 'Failed Dependency',
        self::TOO_EARLY                          => 'Too Early',
        self::UPGRADE_REQURED                    => 'Upgrade Required',
        self::PRECONDITION_REQUIRED              => 'Precondition Required',
        self::TOO_MANY_REQUESTS                  => 'Too Many Requests',
        self::REQUEST_HEADER_FIELDS_TOO_LARGE    => 'Request Header Fields Too Large',
        self::CONNECTION_CLOSED_WITHOUT_RESPONSE => 'Connection Closed Without Response',
        self::UNAVAILABLE_FOR_LEGAL_REASONS      => 'Unavailable For Legal Reasons',
        self::CLIENT_CLOSED_REQUEST              => 'Client Closed Request',
        self::INTERNAL_SERVER_ERROR              => 'Internal Server Error',
        self::NOT_IMPLEMENTED                    => 'Not Implemented',
        self::BAD_GATEWAY                        => 'Bad Gateway',
        self::SERVICE_UNAVAILABLE                => 'Service Unavailable',
        self::GATEWAY_TIMEOUT                    => 'Gateway Timeout',
        self::HTTP_VERSION_NOT_SUPPORTED         => 'HTTP Version Not Supported',
        self::VARIANT_ALSO_NEGOTIATES            => 'Variant Also Negotiates',
        self::INSUFFICIENT_STORAGE               => 'Insufficient Storage',
        self::LOOP_DETECTED                      => 'Loop Detected',
        self::NOT_EXTENDED                       => 'Not Extended',
        self::NETWORK_AUTHENTICATION_REQUIRED    => 'Network Authentication Required',
    ];

    /**
     * The HTTP POST method sends data to the server. The type of the body of
     * the request is indicated by the Content-Type header.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/POST
     */
    public const POST = 'POST';

    /**
     * The HyperText Transfer Protocol (HTTP) 412 Precondition Failed client
     * error response code indicates that access to the target resource has been
     * denied. This happens with conditional requests on methods other than GET
     * or HEAD when the condition defined by the If-Unmodified-Since or
     * If-None-Match headers is not fulfilled.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/412
     */
    public const PRECONDITION_FAILED = 412;

    /**
     * The HTTP 428 Precondition Required response status code indicates that
     * the server requires the request to be conditional.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/428
     */
    public const PRECONDITION_REQUIRED = 428;

    /**
     * An interim response used to inform the client that the server has
     * accepted the complete request, but has not yet completed it.
     *
     * @see https://httpstatuses.com/102
     */
    public const PROCESSING = 102;

    /**
     * The HTTP 407 Proxy Authentication Required client error status response
     * code indicates that the request has not been applied because it lacks
     * valid authentication credentials for a proxy server that is between the
     * browser and the server that can access the requested resource.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/407
     */
    public const PROXY_AUTHENTICATION_REQUIRED = 407;

    /**
     * The HTTP PUT request method creates a new resource or replaces a
     * representation of the target resource with the request payload.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/PUT
     */
    public const PUT = 'PUT';

    /**
     * The HTTP 431 Request Header Fields Too Large response status code
     * indicates that the server refuses to process the request because the
     * request’s HTTP headers are too long. The request may be resubmitted after
     * reducing the size of the request headers.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/431
     */
    public const REQUEST_HEADER_FIELDS_TOO_LARGE = 431;

    /**
     * The HyperText Transfer Protocol (HTTP) 408 Request Timeout response
     * status code means that the server would like to shut down this unused
     * connection. It is sent on an idle connection by some servers, even
     * without any previous request by the client.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/408
     */
    public const REQUEST_TIMEOUT = 408;

    /**
     * The HyperText Transfer Protocol (HTTP) 416 Range Not Satisfiable error
     * response code indicates that a server cannot serve the requested ranges.
     * The most likely reason is that the document doesn't contain such ranges,
     * or that the Range header value, though syntactically correct, doesn't
     * make sense.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/416
     */
    public const REQUESTED_RANGE_NOT_SATISFIABLE = 416;

    /**
     * The HTTP 205 Reset Content response status tells the client to reset the
     * document view, so for example to clear the content of a form, reset a
     * canvas state, or to refresh the UI.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/205
     */
    public const RESET_CONTENT = 205;

    /**
     * The HyperText Transfer Protocol (HTTP) 303 See Other redirect status
     * response code indicates that the redirects don't link to the newly
     * uploaded resources, but to another page (such as a confirmation page or
     * an upload progress page). This response code is usually sent back as a
     * result of PUT or POST. The method used to display this redirected page is
     * always GET.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/303
     */
    public const SEE_OTHER = 303;

    /**
     * The HyperText Transfer Protocol (HTTP) 503 Service Unavailable server
     * error response code indicates that the server is not ready to handle the
     * request.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/503
     */
    public const SERVICE_UNAVAILABLE = 503;

    /**
     * This response code is no longer used; it is just reserved. It was used
     * in a previous version of the HTTP/1.1 specification.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status#redirection_messages
     */
    public const SWITCH_PROXY = 306;

    /**
     * The HTTP 101 Switching Protocols response code indicates the protocol the
     * server is switching to as requested by a client which sent the message
     * including the Upgrade request header.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/101
     */
    public const SWITCHING_PROTOCOLS = 101;

    /**
     * The server sends this response to direct the client to get the requested
     * resource at another URI with same method that was used in the prior
     * request. This has the same semantics as the `302 Found` HTTP response
     * code, with the exception that the user agent _must not_ change the HTTP
     * method used: If a `POST` was used in the first request, a `POST` must be
     * used in the second request.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status#redirection_messages
     */
    public const TEMPORARY_REDIRECT = 307;

    /**
     * The HyperText Transfer Protocol (HTTP) 425 Too Early response status code
     * indicates that the server is unwilling to risk processing a request that
     * might be replayed, which creates the potential for a replay attack.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/425
     */
    public const TOO_EARLY = 425;

    /**
     * The HTTP 429 Too Many Requests response status code indicates the user
     * has sent too many requests in a given amount of time ("rate limiting").
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/429
     */
    public const TOO_MANY_REQUESTS = 429;

    /**
     * The HTTP TRACE method performs a message loop-back test along the path to
     * the target resource, providing a useful debugging mechanism.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/TRACE
     */
    public const TRACE = 'TRACE';

    /**
     * The HTTP 401 Unauthorized client error status response code indicates
     * that the request has not been applied because it lacks valid
     * authentication credentials for the target resource.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/401
     */
    public const UNAUTHORIZED = 401;

    /**
     * The HyperText Transfer Protocol (HTTP) 451 Unavailable For Legal Reasons
     * client error response code indicates that the user requested a resource
     * that is not available due to legal reasons, such as a web page for which
     * a legal action has been issued.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/451
     */
    public const UNAVAILABLE_FOR_LEGAL_REASONS = 451;

    /**
     * The HyperText Transfer Protocol (HTTP) 422 Unprocessable Entity response
     * status code indicates that the server understands the content type of the
     * request entity, and the syntax of the request entity is correct, but it
     * was unable to process the contained instructions.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/422
     */
    public const UNPROCESSABLE_ENTITY = 422;

    /**
     * The HTTP 415 Unsupported Media Type client error response code indicates
     * that the server refuses to accept the request because the payload format
     * is in an unsupported format.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/415
     */
    public const UNSUPPORTED_MEDIA_TYPE = 415;

    /**
     * The HTTP 426 Upgrade Required client error response code indicates that
     * the server refuses to perform the request using the current protocol but
     * might be willing to do so after the client upgrades to a different
     * protocol.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/426
     */
    public const UPGRADE_REQURED = 426;

    /**
     * The HTTP 414 URI Too Long response status code indicates that the URI
     * requested by the client is longer than the server is willing to
     * interpret.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/414
     */
    public const URI_TOO_LONG = 414;

    /**
     * Defined in a previous version of the HTTP specification to indicate that
     * a requested response must be accessed by a proxy.
     *
     * @deprecated Due to security concerns regarding in-band configuration of a proxy.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status#redirection_messages
     */
    public const USE_PROXY = 305;

    /**
     * The HyperText Transfer Protocol (HTTP) 506 Variant Also Negotiates
     * response status code may be given in the context of Transparent Content
     * Negotiation (see RFC 2295). This protocol enables a client to retrieve
     * the best variant of a given resource, where the server supports multiple
     * variants.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/506
     * @see https://datatracker.ietf.org/doc/html/rfc2295
     */
    public const VARIANT_ALSO_NEGOTIATES = 506;

    /**
     * Issue an HTTP `CONNECT` request to the given URI.
     */
    public function connect(UriInterface $uri): ResponseInterface;

    /**
     * Issue an HTTP `DELETE` request to the given URI.
     */
    public function delete(UriInterface $uri): ResponseInterface;

    /**
     * Issue an HTTP `GET` request to the given URI.
     */
    public function get(UriInterface $uri): ResponseInterface;

    /**
     * Issue an HTTP `HEAD` request to the given URI.
     */
    public function head(UriInterface $uri): ResponseInterface;

    /**
     * Issue an HTTP `OPTIONS` request to the given URI.
     */
    public function options(UriInterface $uri): ResponseInterface;

    /**
     * Issue an HTTP `PATCH` request to the given URI.
     */
    public function patch(UriInterface $uri, string|StreamInterface $body): ResponseInterface;

    /**
     * Issue an HTTP `POST` request to the given URI.
     */
    public function post(UriInterface $uri, string|StreamInterface $body): ResponseInterface;

    /**
     * Issue an HTTP `PUT` request to the given URI.
     */
    public function put(UriInterface $uri, string|StreamInterface $body): ResponseInterface;

    /**
     * Issue an HTTP `TRACE` request to the given URI.
     */
    public function trace(UriInterface $uri): ResponseInterface;
}

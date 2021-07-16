<?php

declare(strict_types = 1);

namespace Minibase\Net;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

/**
 * An HTTP communication specification.
 *
 * @author Jordan Brauer
 * @since v0.0.1
 */
interface HttpInterface
{
    /**
     * The **HTTP `GET` method** requests a representation of the specified
     * resource. Requests using `GET` should only be used to request data (they
     * shouldn't include data).
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/GET
     */
    public const GET = 'GET';

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
     * The HTTP POST method sends data to the server. The type of the body of
     * the request is indicated by the Content-Type header.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/POST
     */
    public const POST = 'POST';

    /**
     * The HTTP PUT request method creates a new resource or replaces a
     * representation of the target resource with the request payload.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/PUT
     */
    public const PUT = 'PUT';

    /**
     * The **HTTP `PATCH` request method** applies partial modifications to a
     * resource.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/PATCH
     */
    public const PATCH = 'PATCH';

    /**
     * The HTTP DELETE request method deletes the specified resource.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/DELETE
     */
    public const DELETE = 'DELETE';

    /**
     * The HTTP CONNECT method starts two-way communications with the requested
     * resource. It can be used to open a tunnel.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/CONNECT
     */
    public const CONNECT = 'CONNECT';

    /**
     * The HTTP OPTIONS method requests permitted communication options for a
     * given URL or server. A client can specify a URL with this method, or an
     * asterisk (*) to refer to the entire server.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/OPTIONS
     */
    public const OPTIONS = 'OPTIONS';

    /**
     * The HTTP TRACE method performs a message loop-back test along the path to
     * the target resource, providing a useful debugging mechanism.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/TRACE
     */
    public const TRACE = 'TRACE';

    /**
     * The HTTP 100 Continue informational status response code indicates that
     * everything so far is OK and that the client should continue with the
     * request or ignore it if it is already finished.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/100
     */
    public const CONTINUE = 100;

    /**
     * The HTTP 101 Switching Protocols response code indicates the protocol the
     * server is switching to as requested by a client which sent the message
     * including the Upgrade request header.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/101
     */
    public const SWITCHING_PROTOCOLS = 101;

    /**
     * An interim response used to inform the client that the server has
     * accepted the complete request, but has not yet completed it.
     *
     * @see https://httpstatuses.com/102
     */
    public const PROCESSING = 102;

    /**
     * The HTTP 103 Early Hints information response status code is primarily
     * intended to be used with the Link header to allow the user agent to start
     * preloading resources while the server is still preparing a response.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/103
     */
    public const EARLY_HINTS = 103;

    /**
     * The HTTP 200 OK success status response code indicates that the request
     * has succeeded. A 200 response is cacheable by default.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/200
     */
    public const OK = 200;

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
     * The HTTP 203 Non-Authoritative Information response status indicates that
     * the request was successful but the enclosed payload has been modified by
     * a transforming proxy from that of the origin server's 200 (OK) response .
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/203
     */
    public const NON_AUTHORITATIVE_INFO = 203;

    /**
     * The HTTP 204 No Content success status response code indicates that a
     * request has succeeded, but that the client doesn't need to navigate away
     * from its current page.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/204
     */
    public const NO_CONTENT = 204;

    /**
     * The HTTP 205 Reset Content response status tells the client to reset the
     * document view, so for example to clear the content of a form, reset a
     * canvas state, or to refresh the UI.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/205
     */
    public const RESET_CONTENT = 205;

    /**
     * The HTTP 206 Partial Content success status response code indicates that
     * the request has succeeded and has the body contains the requested ranges
     * of data, as described in the Range header of the request.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/206
     */
    public const PARTIAL_CONTENT = 206;

    /**
     * Conveys information about multiple resources, for situations where
     * multiple status codes might be appropriate (WebDav).
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     * @see https://httpstatuses.com/207
     */
    public const MULTI_STATUS = 207;

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
     * The server has fulfilled a GET request for the resource, and the response
     * is a representation of the result of one or more instance-manipulations
     * applied to the current instance.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
     * @see https://httpstatuses.com/226
     */
    public const IM_USED = 226;

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
     * Defined in a previous version of the HTTP specification to indicate that
     * a requested response must be accessed by a proxy.
     *
     * @deprecated Due to security concerns regarding in-band configuration of a proxy.
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status#redirection_messages
     */
    public const USE_PROXY = 305;

    /**
     * This response code is no longer used; it is just reserved. It was used
     * in a previous version of the HTTP/1.1 specification.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status#redirection_messages
     */
    public const UNUSED = 306;

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
     * The HyperText Transfer Protocol (HTTP) 501 Not Implemented server error
     * response code means that the server does not support the functionality
     * required to fulfill the request.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/501
     */
    public const NOT_IMPLEMENTED = 501;

    /**
     * The HyperText Transfer Protocol (HTTP) 502 Bad Gateway server error
     * response code indicates that the server, while acting as a gateway or
     * proxy, received an invalid response from the upstream server.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/502
     */
    public const BAD_GATEWAY = 502;

    /**
     * The HyperText Transfer Protocol (HTTP) 503 Service Unavailable server
     * error response code indicates that the server is not ready to handle the
     * request.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/503
     */
    public const SERVICE_UNAVAILABLE = 503;

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
     * The HyperText Transfer Protocol (HTTP) 505 HTTP Version Not Supported
     * response status code indicates that the HTTP version used in the request
     * is not supported by the server.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/505
     */
    public const HTTP_VERSION_NOT_SUPPORTED = 505;

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
     * The HyperText Transfer Protocol (HTTP) 507 Insufficient Storage response
     * status code may be given in the context of the Web Distributed Authoring
     * and Versioning (WebDAV) protocol (see RFC 4918).
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/507
     * @see https://datatracker.ietf.org/doc/html/rfc4918
     */
    public const INSUFFICIENT_STORAGE = 507;

    /**
     * The HyperText Transfer Protocol (HTTP) 508 Loop Detected response status
     * code may be given in the context of the Web Distributed Authoring and
     * Versioning (WebDAV) protocol.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/508
     */
    public const LOOP_DETECTED = 508;

    /**
     * The HyperText Transfer Protocol (HTTP)  510 Not Extended response status
     * code is sent in the context of the HTTP Extension Framework, defined in
     * RFC 2774.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/510
     * @see https://datatracker.ietf.org/doc/html/rfc2774
     */
    public const NOT_EXTENDED= 510;

    /**
     * The HTTP 511 Network Authentication Required response status code
     * indicates that the client needs to authenticate to gain network access.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/511
     */
    public const NETWORK_AUTHENTICATION_REQUIRED = 511;

    /**
     * HTTP status code reason map.
     *
     * @var array<int,string>
     */
    public const PHRASES = [
        # 1XX – Informational Codes
        self::CONTINUE => 'Continue',
        self::SWITCHING_PROTOCOLS => 'Switching Protocols',
        self::PROCESSING => 'Processing',
        self::EARLY_HINTS => 'Early Hints',
        # 2XX – Success Codes
        self::OK => 'OK',
        self::CREATED => 'Created',
        self::ACCEPTED => 'Accepted',
        self::NON_AUTHORITATIVE_INFO => 'Non-Authoritative Information',
        self::NO_CONTENT => 'No Content',
        self::RESET_CONTENT => 'Reset Content',
        self::PARTIAL_CONTENT => 'Partial Content',
        self::MULTI_STATUS => 'Multi-Status',
        self::ALREADY_REPORTED => 'Already Reported',
        self::IM_USED => 'IM Used',
        # 3XX – Redirect Codes
        self::MULTIPLE_CHOICES => 'Multiple Choice',
        self::MOVED_PERMANENTLY => 'Moved Permanently',
        self::FOUND => 'Found',
        self::SEE_OTHER => 'See Other',
        self::NOT_MODIFIED => 'Not Modified',
        self::USE_PROXY => 'Use Proxy',
        self::UNUSED => 'unused',
        self::TEMPORARY_REDIRECT => 'Temporary Redirect',
        self::PERMANENT_REDIRECT => 'Permanent Redirect',
        # TODO: 4XX – Client Error Codes
        # 5XX – Server Error Codes
        self::INTERNAL_SERVER_ERROR => 'Internal Server Error',
        self::NOT_IMPLEMENTED => 'Not Implemented',
        self::BAD_GATEWAY => 'Bad Gateway',
        self::SERVICE_UNAVAILABLE => 'Service Unavailable',
        self::GATEWAY_TIMEOUT => 'Gateway Timeout',
        self::HTTP_VERSION_NOT_SUPPORTED => 'HTTP Version Not Supported',
        self::VARIANT_ALSO_NEGOTIATES => 'Variant Also Negotiates',
        self::INSUFFICIENT_STORAGE => 'Insufficient Storage',
        self::LOOP_DETECTED => 'Loop Detected',
        self::NOT_EXTENDED => 'Not Extended',
        self::NETWORK_AUTHENTICATION_REQUIRED => 'Network Authentication Required',
    ];

    /**
     * Issue an HTTP `GET` request to the given URI.
     */
    public function get(UriInterface $uri): ResponseInterface;

    /**
     * Issue an HTTP `HEAD` request to the given URI.
     */
    public function head(UriInterface $uri): ResponseInterface;

    /**
     * Issue an HTTP `POST` request to the given URI.
     */
    public function post(UriInterface $uri, string $contentType, string|StreamInterface $body): ResponseInterface;

    /**
     * Issue an HTTP `PUT` request to the given URI.
     */
    public function put(UriInterface $uri, string $contentType, string|StreamInterface $body): ResponseInterface;

    /**
     * Issue an HTTP `PATCH` request to the given URI.
     */
    public function patch(UriInterface $uri, string $contentType, string|StreamInterface $body): ResponseInterface;

    /**
     * Issue an HTTP `DELETE` request to the given URI.
     */
    public function delete(UriInterface $uri): ResponseInterface;

    /**
     * Issue an HTTP `CONNECT` request to the given URI.
     */
    public function connect(UriInterface $uri): ResponseInterface;

    /**
     * Issue an HTTP `OPTIONS` request to the given URI.
     */
    public function options(UriInterface $uri): ResponseInterface;

    /**
     * Issue an HTTP `TRACE` request to the given URI.
     */
    public function trace(UriInterface $uri): ResponseInterface;
}

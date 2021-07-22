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

$reason = static fn (int $code): array => [$code, Http::PHRASES[$code]];

dataset('codes.informational', fn () => yield from [
    Http::CONTINUE            => $reason(Http::CONTINUE),
    Http::SWITCHING_PROTOCOLS => $reason(Http::SWITCHING_PROTOCOLS),
    Http::PROCESSING          => $reason(Http::PROCESSING),
    Http::EARLY_HINTS         => $reason(Http::EARLY_HINTS),
]);

dataset('codes.success', fn () => yield from [
    Http::OK                     => $reason(Http::OK),
    Http::CREATED                => $reason(Http::CREATED),
    Http::ACCEPTED               => $reason(Http::ACCEPTED),
    Http::NON_AUTHORITATIVE_INFO => $reason(Http::NON_AUTHORITATIVE_INFO),
    Http::NO_CONTENT             => $reason(Http::NO_CONTENT),
    Http::RESET_CONTENT          => $reason(Http::RESET_CONTENT),
    Http::PARTIAL_CONTENT        => $reason(Http::PARTIAL_CONTENT),
    Http::MULTI_STATUS           => $reason(Http::MULTI_STATUS),
    Http::ALREADY_REPORTED       => $reason(Http::ALREADY_REPORTED),
    Http::IM_USED                => $reason(Http::IM_USED),
]);

dataset('codes.redirection', fn () => yield from [
    Http::MULTIPLE_CHOICES         => $reason(Http::MULTIPLE_CHOICES),
    Http::MOVED_PERMANENTLY        => $reason(Http::MOVED_PERMANENTLY),
    Http::FOUND                    => $reason(Http::FOUND),
    Http::SEE_OTHER                => $reason(Http::SEE_OTHER),
    Http::NOT_MODIFIED             => $reason(Http::NOT_MODIFIED),
    Http::USE_PROXY                => $reason(Http::USE_PROXY),
    Http::SWITCH_PROXY             => $reason(Http::SWITCH_PROXY),
    Http::TEMPORARY_REDIRECT       => $reason(Http::TEMPORARY_REDIRECT),
    Http::PERMANENT_REDIRECT       => $reason(Http::PERMANENT_REDIRECT),
]);

dataset('codes.client', fn () => yield from [
    Http::BAD_REQUEST                        => $reason(Http::BAD_REQUEST),
    Http::UNAUTHORIZED                       => $reason(Http::UNAUTHORIZED),
    Http::PAYMENT_REQUIRED                   => $reason(Http::PAYMENT_REQUIRED),
    Http::FORBIDDEN                          => $reason(Http::FORBIDDEN),
    Http::NOT_FOUND                          => $reason(Http::NOT_FOUND),
    Http::METHOD_NOT_ALLOWED                 => $reason(Http::METHOD_NOT_ALLOWED),
    Http::NOT_ACCEPTABLE                     => $reason(Http::NOT_ACCEPTABLE),
    Http::PROXY_AUTHENTICATION_REQUIRED      => $reason(Http::PROXY_AUTHENTICATION_REQUIRED),
    Http::REQUEST_TIMEOUT                    => $reason(Http::REQUEST_TIMEOUT),
    Http::CONFLICT                           => $reason(Http::CONFLICT),
    Http::GONE                               => $reason(Http::GONE),
    Http::LENGTH_REQUIRED                    => $reason(Http::LENGTH_REQUIRED),
    Http::PRECONDITION_FAILED                => $reason(Http::PRECONDITION_FAILED),
    Http::PAYLOAD_TOO_LARGE                  => $reason(Http::PAYLOAD_TOO_LARGE),
    Http::URI_TOO_LONG                       => $reason(Http::URI_TOO_LONG),
    Http::UNSUPPORTED_MEDIA_TYPE             => $reason(Http::UNSUPPORTED_MEDIA_TYPE),
    Http::REQUESTED_RANGE_NOT_SATISFIABLE    => $reason(Http::REQUESTED_RANGE_NOT_SATISFIABLE),
    Http::EXPECTATION_FAILED                 => $reason(Http::EXPECTATION_FAILED),
    Http::IM_A_TEAPOT                        => $reason(Http::IM_A_TEAPOT),
    Http::MISDIRECTED_REQUEST                => $reason(Http::MISDIRECTED_REQUEST),
    Http::UNPROCESSABLE_ENTITY               => $reason(Http::UNPROCESSABLE_ENTITY),
    Http::LOCKED                             => $reason(Http::LOCKED),
    Http::FAILED_DEPENDENCY                  => $reason(Http::FAILED_DEPENDENCY),
    Http::TOO_EARLY                          => $reason(Http::TOO_EARLY),
    Http::UPGRADE_REQURED                    => $reason(Http::UPGRADE_REQURED),
    Http::PRECONDITION_REQUIRED              => $reason(Http::PRECONDITION_REQUIRED),
    Http::TOO_MANY_REQUESTS                  => $reason(Http::TOO_MANY_REQUESTS),
    Http::REQUEST_HEADER_FIELDS_TOO_LARGE    => $reason(Http::REQUEST_HEADER_FIELDS_TOO_LARGE),
    Http::CONNECTION_CLOSED_WITHOUT_RESPONSE => $reason(Http::CONNECTION_CLOSED_WITHOUT_RESPONSE),
    Http::UNAVAILABLE_FOR_LEGAL_REASONS      => $reason(Http::UNAVAILABLE_FOR_LEGAL_REASONS),
    Http::CLIENT_CLOSED_REQUEST              => $reason(Http::CLIENT_CLOSED_REQUEST),
]);

dataset('codes.server', fn () => yield from [
    Http::INTERNAL_SERVER_ERROR           => $reason(Http::INTERNAL_SERVER_ERROR),
    Http::NOT_IMPLEMENTED                 => $reason(Http::NOT_IMPLEMENTED),
    Http::BAD_GATEWAY                     => $reason(Http::BAD_GATEWAY),
    Http::SERVICE_UNAVAILABLE             => $reason(Http::SERVICE_UNAVAILABLE),
    Http::GATEWAY_TIMEOUT                 => $reason(Http::GATEWAY_TIMEOUT),
    Http::HTTP_VERSION_NOT_SUPPORTED      => $reason(Http::HTTP_VERSION_NOT_SUPPORTED),
    Http::VARIANT_ALSO_NEGOTIATES         => $reason(Http::VARIANT_ALSO_NEGOTIATES),
    Http::INSUFFICIENT_STORAGE            => $reason(Http::INSUFFICIENT_STORAGE),
    Http::LOOP_DETECTED                   => $reason(Http::LOOP_DETECTED),
    Http::NOT_EXTENDED                    => $reason(Http::NOT_EXTENDED),
    Http::NETWORK_AUTHENTICATION_REQUIRED => $reason(Http::NETWORK_AUTHENTICATION_REQUIRED),
]);

# NOTE: combining all datasets causes OOM
dataset('codes.all', fn () => yield from [
    # 1XX - Informational
    Http::CONTINUE            => $reason(Http::CONTINUE),
    Http::SWITCHING_PROTOCOLS => $reason(Http::SWITCHING_PROTOCOLS),
    Http::PROCESSING          => $reason(Http::PROCESSING),
    Http::EARLY_HINTS         => $reason(Http::EARLY_HINTS),
    # 2XX – Success
    Http::OK                     => $reason(Http::OK),
    Http::CREATED                => $reason(Http::CREATED),
    Http::ACCEPTED               => $reason(Http::ACCEPTED),
    Http::NON_AUTHORITATIVE_INFO => $reason(Http::NON_AUTHORITATIVE_INFO),
    Http::NO_CONTENT             => $reason(Http::NO_CONTENT),
    Http::RESET_CONTENT          => $reason(Http::RESET_CONTENT),
    Http::PARTIAL_CONTENT        => $reason(Http::PARTIAL_CONTENT),
    Http::MULTI_STATUS           => $reason(Http::MULTI_STATUS),
    Http::ALREADY_REPORTED       => $reason(Http::ALREADY_REPORTED),
    Http::IM_USED                => $reason(Http::IM_USED),
    # 3XX – Redirection
    Http::MULTIPLE_CHOICES   => $reason(Http::MULTIPLE_CHOICES),
    Http::MOVED_PERMANENTLY  => $reason(Http::MOVED_PERMANENTLY),
    Http::FOUND              => $reason(Http::FOUND),
    Http::SEE_OTHER          => $reason(Http::SEE_OTHER),
    Http::NOT_MODIFIED       => $reason(Http::NOT_MODIFIED),
    Http::USE_PROXY          => $reason(Http::USE_PROXY),
    Http::SWITCH_PROXY       => $reason(Http::SWITCH_PROXY),
    Http::TEMPORARY_REDIRECT => $reason(Http::TEMPORARY_REDIRECT),
    Http::PERMANENT_REDIRECT => $reason(Http::PERMANENT_REDIRECT),
    # 4XX – Client Errors
    Http::BAD_REQUEST                        => $reason(Http::BAD_REQUEST),
    Http::UNAUTHORIZED                       => $reason(Http::UNAUTHORIZED),
    Http::PAYMENT_REQUIRED                   => $reason(Http::PAYMENT_REQUIRED),
    Http::FORBIDDEN                          => $reason(Http::FORBIDDEN),
    Http::NOT_FOUND                          => $reason(Http::NOT_FOUND),
    Http::METHOD_NOT_ALLOWED                 => $reason(Http::METHOD_NOT_ALLOWED),
    Http::NOT_ACCEPTABLE                     => $reason(Http::NOT_ACCEPTABLE),
    Http::PROXY_AUTHENTICATION_REQUIRED      => $reason(Http::PROXY_AUTHENTICATION_REQUIRED),
    Http::REQUEST_TIMEOUT                    => $reason(Http::REQUEST_TIMEOUT),
    Http::CONFLICT                           => $reason(Http::CONFLICT),
    Http::GONE                               => $reason(Http::GONE),
    Http::LENGTH_REQUIRED                    => $reason(Http::LENGTH_REQUIRED),
    Http::PRECONDITION_FAILED                => $reason(Http::PRECONDITION_FAILED),
    Http::PAYLOAD_TOO_LARGE                  => $reason(Http::PAYLOAD_TOO_LARGE),
    Http::URI_TOO_LONG                       => $reason(Http::URI_TOO_LONG),
    Http::UNSUPPORTED_MEDIA_TYPE             => $reason(Http::UNSUPPORTED_MEDIA_TYPE),
    Http::REQUESTED_RANGE_NOT_SATISFIABLE    => $reason(Http::REQUESTED_RANGE_NOT_SATISFIABLE),
    Http::EXPECTATION_FAILED                 => $reason(Http::EXPECTATION_FAILED),
    Http::IM_A_TEAPOT                        => $reason(Http::IM_A_TEAPOT),
    Http::MISDIRECTED_REQUEST                => $reason(Http::MISDIRECTED_REQUEST),
    Http::UNPROCESSABLE_ENTITY               => $reason(Http::UNPROCESSABLE_ENTITY),
    Http::LOCKED                             => $reason(Http::LOCKED),
    Http::FAILED_DEPENDENCY                  => $reason(Http::FAILED_DEPENDENCY),
    Http::TOO_EARLY                          => $reason(Http::TOO_EARLY),
    Http::UPGRADE_REQURED                    => $reason(Http::UPGRADE_REQURED),
    Http::PRECONDITION_REQUIRED              => $reason(Http::PRECONDITION_REQUIRED),
    Http::TOO_MANY_REQUESTS                  => $reason(Http::TOO_MANY_REQUESTS),
    Http::REQUEST_HEADER_FIELDS_TOO_LARGE    => $reason(Http::REQUEST_HEADER_FIELDS_TOO_LARGE),
    Http::CONNECTION_CLOSED_WITHOUT_RESPONSE => $reason(Http::CONNECTION_CLOSED_WITHOUT_RESPONSE),
    Http::UNAVAILABLE_FOR_LEGAL_REASONS      => $reason(Http::UNAVAILABLE_FOR_LEGAL_REASONS),
    Http::CLIENT_CLOSED_REQUEST              => $reason(Http::CLIENT_CLOSED_REQUEST),
    # 5XX - Server Errors
    Http::INTERNAL_SERVER_ERROR           => $reason(Http::INTERNAL_SERVER_ERROR),
    Http::NOT_IMPLEMENTED                 => $reason(Http::NOT_IMPLEMENTED),
    Http::BAD_GATEWAY                     => $reason(Http::BAD_GATEWAY),
    Http::SERVICE_UNAVAILABLE             => $reason(Http::SERVICE_UNAVAILABLE),
    Http::GATEWAY_TIMEOUT                 => $reason(Http::GATEWAY_TIMEOUT),
    Http::HTTP_VERSION_NOT_SUPPORTED      => $reason(Http::HTTP_VERSION_NOT_SUPPORTED),
    Http::VARIANT_ALSO_NEGOTIATES         => $reason(Http::VARIANT_ALSO_NEGOTIATES),
    Http::INSUFFICIENT_STORAGE            => $reason(Http::INSUFFICIENT_STORAGE),
    Http::LOOP_DETECTED                   => $reason(Http::LOOP_DETECTED),
    Http::NOT_EXTENDED                    => $reason(Http::NOT_EXTENDED),
    Http::NETWORK_AUTHENTICATION_REQUIRED => $reason(Http::NETWORK_AUTHENTICATION_REQUIRED),
]);

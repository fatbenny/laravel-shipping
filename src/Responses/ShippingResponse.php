<?php

namespace PangPang\Shipping\Responses;

use Throwable;
use Psr\Http\Message\ResponseInterface;

class ShippingResponse
{
    public function __construct(
        public bool $success,
        public ?array $data = null,
        public ?string $statusCode = null,
        public ?array $errors = null
    ) {
    }

    public static function success(ResponseInterface $response, ?callable $handler = null): self
    {
        $parsedData = [];

        try {
            $body = (string) $response->getBody();
            $data = json_decode($body, true);
            $parsedData = $handler ? $handler($data) : $data;

            return new self(true, $parsedData, $response->getStatusCode());
        } catch (Throwable $e) {
            return self::error($e);
        }
    }

    public static function error(Throwable $exception): self
    {
        $code = method_exists($exception, 'getCode') ? (string) $exception->getCode() : 'UNKNOWN_ERROR';
        $message = json_decode((string) $exception->getResponse()->getBody(), true);
        return new self(false, null, $code, $message);
    }
}
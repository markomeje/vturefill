<?php declare(strict_types=1);

namespace VTURefill\Http;


final class Response {

    public function statusCode(int $code = 0) {
        return empty($code) ? http_response_code() : http_response_code($code);
    }

}
<?php declare(strict_types=1);

namespace VTURefill\Core;
use VTURefill\Http\{Request, Response};
use VTURefill\Core\Router;
use VTURefill\Exceptions\ParserException;


final class Parser {

    public $router;

    public function __construct(Request $request) {
        try {
            $url = isset($request->get()['route']) ? $request->get()['route'] : '';
            $url = empty($url) ? [] : (array)explode('/', filter_var(rtrim(strtolower($url), '/'), FILTER_SANITIZE_URL));
            $controller = (isset($url[0]) && $url[0] !== '') ? ucwords($url[0]) : DEFAULT_CONTROLLER;
            array_shift($url);
            $method = (isset($url[0]) && $url[0] !== '') ? $url[0] : DEFAULT_METHOD;
            array_shift($url);
            $arguments = empty($url) ? '' : array_values($url);
            $this->router = new Router($controller, $method, $arguments);
        } catch (ParserException $error) {
            (new Response)->statusCode($error->code);
            exit(View::render('frontend', 'codes/error', ['title' => $error->getMessage(), 'code' => $error->code, 'message' => $error->getMessage()]));
        }
    }

}
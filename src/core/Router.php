<?php
namespace Vanilla\core;

class Router
{
    public array $post;
    public array $get;

    private array $supportedHttpMethods = [
        "GET",
        "POST"
    ];

    public function __construct()
    {
        $this->post = [];
        $this->get = [];
    }

    public function __call($name, $args)
    {
        [$route, $method] = $args;

        if (!in_array(strtoupper($name), $this->supportedHttpMethods, true)) {
            $this->invalidMethodHandler();
        }

        $this->{strtolower($name)}[$this->formatRoute($route)] = $method;
    }

    // Removes trailing forward slashes from the right of the route.
    private function formatRoute($route): string
    {
        $result = rtrim($route, '/');
        if ($result === '') {
            return '/';
        }
        return $result;
    }

    // non-supported method
    private function invalidMethodHandler(): void
    {
        $protocol = App::$request->serverProtocol;
        header("{$protocol} 405 Method Not Allowed");
    }

    // non-declared route
    private function defaultRequestHandler(): void
    {
        $protocol = App::$request->serverProtocol;
        header("{$protocol} 404 Not Found");
    }

    /**
     * Resolves a route
     */
    public function resolve(): void
    {
        $methodDictionary = $this->{strtolower(App::$request->requestMethod)};
        $formattedRoute = $this->formatRoute(App::$request->requestUri);

        // if invalid method
        if(is_null($methodDictionary)) {
            $this->invalidMethodHandler();
        }

        // if route does not exist
        if(!array_key_exists($formattedRoute,$methodDictionary)) {
            $this->defaultRequestHandler();
            return;
        }

        // output
        echo call_user_func($methodDictionary[$formattedRoute],App::$request);
    }

    // resolve route and output when Router is garbage collected
    public function __destruct()
    {
        $this->resolve();
    }
}
<?php
namespace Vanilla\core;

use Vanilla\utils\File;

class Request implements IRequest
{

    public function __construct()
    {
        $this->bootstrap();
    }

    /** @return File[] */
    public function files(): array
    {
        $files = [];
        foreach($_FILES as $key => $file) {
            $files[$key] = new File($file);
        }

        return $files;
    }

    private function bootstrap(): void
    {
        foreach($_SERVER as $key => $value) {
            $this->{$this->toCamelCase($key)} = $value;
        }
    }

    public function getBody()
    {
        if($this->requestMethod === "GET")
        {
            return;
        }


        if ($this->requestMethod === "POST")
        {

            $body = [];
            foreach($_POST as $key => $value)
            {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }

            return $body;
        }
    }

    private function toCamelCase($string)
    {
        $result = strtolower($string);

        preg_match_all('/_[a-z]/', $result, $matches);

        foreach($matches[0] as $match)
        {
            $c = str_replace('_', '', strtoupper($match));
            $result = str_replace($match, $c, $result);
        }

        return $result;
    }
}
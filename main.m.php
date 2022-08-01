<?php
/*  * Copyright (c) 2022 ณวสันต์ วิศิษฏ์ศิงขร
    *
    * This source code is licensed under the MIT license found in the
    * LICENSE file in the root directory of this source tree.
*/
class Wexpress
{
    public static function showError(bool $show = true): void
    {
        if (!$show) {
            error_reporting(0);
        } else {
            error_reporting();
        }
    }
    public static function origin(array $url = ['*']): void
    {
        if ($url[0] == '*') {
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Headers: *");
        } elseif (isset($_SERVER['HTTP_ORIGIN'])) {
            $http_origin = $_SERVER['HTTP_ORIGIN'];
            if (in_array($http_origin, $url)) {
                header("Access-Control-Allow-Origin: $http_origin");
                header("Access-Control-Allow-Headers: *");
            }
        }
    }
    // check path url
    public static function getPath(): string
    {
        $path = "$_SERVER[REQUEST_URI]";
        $real_path = '/';
        $str_len = strlen($path);
        for ($i = 1; $i < $str_len; $i++) {
            if ($path[$i] == '?') {
                break;
            } else {
                $real_path .= $path[$i];
            }
        }
        return $real_path;
    }
    // Route to check METHOD type , Path, and return callback function
    public static function Route(string $method, string $path, callable $callback): null | callable
    {
        if ("$_SERVER[REQUEST_METHOD]" != $method) return null; // check method

        if ($path == '*') return $callback; // check path universel
        // convert to array
        $get_path = explode('/', $path);
        $get_route = explode('/', Wexpress::getPath());

        if (sizeof($get_path) != sizeof($get_route)) return null; // check array size
        for ($i = 0; $i < sizeof($get_route); $i++) {
            // compare and check ':'
            if ($get_path[$i] != $get_route[$i] && $get_path[$i] != ':') return null;
        }
        return $callback;
    }

    // method [  GET ] to get user request
    public static function get(string $path, callable $callback): void
    {
        $value = Wexpress::Route('GET', $path, $callback);
        if ($value) {
            echo $value(Wexpress::request(), Wexpress::response());
            exit;
        }
    }
    // method [  POST ] to get user request
    public static function post(string $path, callable $callback): void
    {
        $value = Wexpress::Route('POST', $path, $callback);
        if ($value) {
            echo $value(Wexpress::request(), Wexpress::response());
            exit;
        }
    }
    // method [  PUT ] to get user request
    public static function put(string $path, callable $callback): void
    {
        $value = Wexpress::Route('PUT', $path, $callback);
        if ($value) {
            echo $value(Wexpress::request(), Wexpress::response());
            exit;
        }
    }
    // method [  DELETE ] to get user request
    public static function delete(string $path, callable $callback): void
    {
        $value = Wexpress::Route('DELETE', $path, $callback);
        if ($value) {
            echo $value(Wexpress::request(), Wexpress::response());
            exit;
        }
    }

    // use for input to method function
    // response to return class obj to use function inside
    public static function request(): object
    {  // to return class obj
        return new class
        {
            public static function body(): string
            { // get value from body
                return file_get_contents('php://input');
            }
            public static function query(): array
            { // get value from url
                $url = "$_SERVER[REQUEST_URI]";
                $parts = parse_url($url);
                $output = [];
                parse_str($parts['query'], $output);
                return $output;
            }
            public static function params(int $position = -1): string
            {
                $path = "$_SERVER[REQUEST_URI]";
                $real_path = '/';
                $str_len = strlen($path);
                for ($i = 1; $i < $str_len; $i++) {
                    if ($path[$i] == '?') {
                        break;
                    } else {
                        $real_path .= $path[$i];
                    }
                }
                $params = explode('/', substr($real_path, 1));
                if ($position > -1) {
                    return str_replace('%20', ' ', $params[$position]);
                } else {
                    return str_replace('%20', ' ', $params[sizeof($params) - 1]);
                }
            }
        }; // obj end
    }
    // use for input to method function 
    // response to return class obj to use function inside
    public static function response(): object
    {
        return new class
        { // return obj
            public static function send(string $value): void
            {
                echo $value;
            }
            public static function status(int $status): void
            {
                http_response_code($status);
            }
            public static function json(object | array $value): void
            {
                echo json_encode($value);
            }
        }; // obj end
    }
};


class Req
{
    public static function body(): string
    { // get value from body
        return file_get_contents('php://input');
    }
    public static function query(): array
    { // get value from url
        $url = "$_SERVER[REQUEST_URI]";
        $parts = parse_url($url);
        $output = [];
        parse_str($parts['query'], $output);
        return $output;
    }
    public static function params(int $position = -1): string
    {
        $path = "$_SERVER[REQUEST_URI]";
        $real_path = '/';
        $str_len = strlen($path);
        for ($i = 1; $i < $str_len; $i++) {
            if ($path[$i] == '?') {
                break;
            } else {
                $real_path .= $path[$i];
            }
        }
        $params = explode('/', substr($real_path, 1));
        if ($position > -1) {
            return str_replace('%20', ' ', $params[$position]);
        } else {
            return str_replace('%20', ' ', $params[sizeof($params) - 1]);
        }
    }
}

class Res
{ // return obj
    public static function send(string $value): void
    {
        echo $value;
    }
    public static function status(int $status): void
    {
        http_response_code($status);
    }
    public static function json(object | array $value): void
    {
        echo json_encode($value);
    }
}

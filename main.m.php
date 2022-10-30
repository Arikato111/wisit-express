<?php
/*  * Copyright (c) 2022 ณวสันต์ วิศิษฏ์ศิงขร
    *
    * This source code is licensed under the MIT license found in the
    * LICENSE file in the root directory of this source tree.
*/
return new class
{
    public function showError($show = true)
    {
        if (!$show) {
            error_reporting(0);
        } else {
            error_reporting();
        }
    }
    public function origin($url = ['*'])
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
    public function getPath()
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
    public function Route($method, $path, $callback)
    {
        if ("$_SERVER[REQUEST_METHOD]" != $method) return; // check method

        if ($path != '*') {

            $get_path = explode('/', $path);
            $get_route = explode('/', $this->getPath());

            if (sizeof($get_path) != sizeof($get_route)) return; // check array size
            for ($i = 0; $i < sizeof($get_route); $i++) {
                // compare and check ':'
                if ($get_path[$i] != $get_route[$i] && $get_path[$i] != ':') return;
            }        // convert to array
        }
        echo $callback($this->request(), $this->response());
        exit;
    }

    // method [  GET ] to get user request
    public function get($path, $callback)
    {
        $this->Route('GET', $path, $callback);
    }
    // method [  POST ] to get user request
    public function post($path, $callback)
    {
        $this->Route('POST', $path, $callback);
    }
    // method [  PUT ] to get user request
    public function put($path, $callback)
    {
        $this->Route('PUT', $path, $callback);
    }
    // method [  DELETE ] to get user request
    public function delete($path, $callback)
    {
        $this->Route('DELETE', $path, $callback);
    }
    // method [  ALL ] to get user request
    public function all($path, $callback)
    {
        $this->Route("$_SERVER[REQUEST_METHOD]", $path, $callback);
    }

    // use for input to method function
    // response to return class obj to use function inside
    public function request()
    {  // to return class obj
        return new class
        {
            function header()
            {
                return apache_request_headers();
            }
            function body()
            { // get value from body
                return file_get_contents('php://input');
            }
            function query()
            { // get value from url
                $url = "$_SERVER[REQUEST_URI]";
                $parts = parse_url($url);
                $output = [];
                parse_str($parts['query'], $output);
                return $output;
            }
            function params($position = -1)
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
    public function response()
    {
        return new class
        { // return obj
            function set($field, $value)
            {
                header("{$field}: {$value}");
            }
            function send($value)
            {
                header('Content-Type: text/html;charset=UTF-8');
                echo $value;
            }
            function status($status)
            {
                http_response_code($status);
            }
            function json($value)
            {
                header('Content-Type: application/json;charset=UTF-8');
                echo json_encode($value);
            }
        }; // obj end
    }
};


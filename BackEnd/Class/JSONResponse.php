<?php

class JSONResponse {
    public static function Error($message) {
        header("HTTP/1.1 400 Bad Request");
        return json_encode(array("status" => "error", "message" => $message));
    }

    public static function NotFound() {
        header("HTTP/1.1 404 Not Found");
        return json_encode(array("status" => "error", "message" => "Not Found"));
    }

    public static function Forbidden() {
        header("HTTP/1.1 403 Forbidden");
        return json_encode(array("status" => "error", "message" => "Forbidden"));
    }

    public static function Unauthorized() {
        header("HTTP/1.1 401 Unauthorized");
        return json_encode(array("status" => "error", "message" => "Unauthorized"));
    }

    public static function Success($data) {
        header("HTTP/1.1 200 OK");
        return json_encode(array("status" => "success", "data" => $data));
    }

    public static function Redirect($url) {
        header("HTTP/1.1 306 Redirect");
        return json_encode(array("status" => "success", "redirect" => $url));
    }
}
<?php

class HttpResponse {

    public function __construct() {}

    public static function handleException(Throwable $exception): void
    {
        http_response_code(500);
        echo json_encode([
            "code" => $exception->getCode(),
            "message" => $exception->getMessage(),
            "file" => $exception->getFile(),
            "line" => $exception->getLine()
        ]);
        exit;
    }

    public static function Ok( array|object|string $responseData ) : void 
    {
        http_response_code(200);
        echo json_encode([
            "date_time" => date("d/m/Y h:i:sa"),
            "version" => "1.0.0",
            "status" => "ok",
            "data" => $responseData
        ]);
        exit;
    }
    
    public static function Created( string $message) : void 
    {
        http_response_code(201);
        echo json_encode([
            "date_time" => date("d/m/Y h:i:sa"),
            "version" => "1.0.0",
            "status" => "success",
            "message" => $message
        ]);
        exit;
    }

    public static function badRequest( string $message) : void 
    {
         http_response_code(400);
         echo json_encode([
             "date" => date("d/m/Y h:i:sa"),
             "version" => "1.0.0",
             "error-type" => "Invalid Parameter",
             "message" => $message
         ]);
         exit;
    }

}



<?php

class HttpResponse {

    public function __construct() {}

    public static function Ok($responseData) {
        http_response_code(200);
        echo json_encode([
            "date_time" => date("d/m/Y h:i:sa"),
            "version" => "1.0.0",
            "status" => "ok",
            "data" => $responseData
        ]);
        exit;
    }
    
    public static function Created($message) {
        http_response_code(201);
        echo json_encode([
            "date_time" => date("d/m/Y h:i:sa"),
            "version" => "1.0.0",
            "status" => "success",
            "message" => $message
        ]);
        exit;
    }

    public static function badRequest($message) {
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



<?php
/**
 * Load successfully
 */
http_response_code(200);
echo json_encode([
    "date_time" => date("d/m/Y h:i:sa"),
    "version" => "1.0.0",
    "status" => "ok",
    "data" => "Success"
]);
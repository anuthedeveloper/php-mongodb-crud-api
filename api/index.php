<?php 
require __DIR__ . '/config.php';

$user = new User();

if ( $_SERVER['REQUEST_METHOD'] === "GET" ) :
    try {
        $result = $user->findAllUser();
        // 
        HttpResponse::OK($result);
    } catch (\Throwable $th) {
        HttpResponse::badRequest($th->getMessage());
    }
endif;
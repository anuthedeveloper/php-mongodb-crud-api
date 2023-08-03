<?php 
require __DIR__ . '/config.php';

$user = new User();

if ( $_SERVER['REQUEST_METHOD'] === "GET" ) :
    try {
        if ( isset($_GET['email']) ) {
            $result = $user->findUser( trim($_GET['email']) );
        } else {
            $result = $user->findAllUser();
        }
        HttpResponse::OK($result);
    } catch (\Throwable $th) {
        HttpResponse::badRequest($th->getMessage());
    }
endif;


if ( $_SERVER['REQUEST_METHOD'] === "POST" ) :
    $data = json_decode(file_get_contents('php://input'),true);
    try {        
        $result = $user->createUser(array(
            'fullname' => $data['fullname'],
            'email' => $data['email'],
            'gender' => $data['gender'],
        ));

        HttpResponse::Created($result);
    } catch (\Throwable $th) {
        HttpResponse::badRequest($th->getMessage());
    }
endif;

if ( $_SERVER['REQUEST_METHOD'] === "PATCH" ) :
   $data = json_decode(file_get_contents('php://input'),true);
   try {
        $result = $user->updateUser(array(
            'fullname' => $data['fullname'],
            'email' => $data['email'],
            'gender' => $data['gender'],
        ));

        HttpResponse::Ok($result);
    } catch (\Throwable $th) {
        HttpResponse::badRequest($th->getMessage());
    }
endif;


if ( $_SERVER['REQUEST_METHOD'] === "DELETE" ) :
    $data = json_decode(file_get_contents('php://input'),true);
    try {
        $result = $user->deleteUser($data['email']);

        HttpResponse::Ok($result);
    } catch (\Throwable $th) {
        HttpResponse::badRequest($th->getMessage());
    }
endif;
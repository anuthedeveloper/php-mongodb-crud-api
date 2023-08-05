<?php 
require __DIR__ . '/config.php';

$product = new Product();

if ( $_SERVER['REQUEST_METHOD'] === "GET" ) :
    try {
        if ( isset($_GET['name']) ) {
            $result = $product->findProduct( trim($_GET['name']) );
        } else {
            $result = $product->findAllProduct();
        }
        HttpResponse::OK($result);
    } catch (\Throwable $th) {
        HttpResponse::badRequest($th->getMessage());
    }
endif;


if ( $_SERVER['REQUEST_METHOD'] === "POST" ) :
    $data = json_decode(file_get_contents('php://input'),true);
    try {        
        $result = $product->createProduct(array(
            'name' => $data['name'],
            'image' => $data['image'],
        ));
        // $result = $product->loadProducts($data['products']);
        HttpResponse::Created($result);
    } catch (\Throwable $th) {
        HttpResponse::badRequest($th->getMessage());
    }
endif;

if ( $_SERVER['REQUEST_METHOD'] === "PATCH" ) :
   $data = json_decode(file_get_contents('php://input'),true);
   try {
        $result = $product->updateProduct(array(
            'name' => $data['name'],
            'image' => $data['image'],
        ));

        HttpResponse::Ok($result);
    } catch (\Throwable $th) {
        HttpResponse::badRequest($th->getMessage());
    }
endif;


if ( $_SERVER['REQUEST_METHOD'] === "DELETE" ) :
    $data = json_decode(file_get_contents('php://input'),true);
    try {
        $result = $product->deleteProduct($data['name']);

        HttpResponse::Ok($result);
    } catch (\Throwable $th) {
        HttpResponse::badRequest($th->getMessage());
    }
endif;
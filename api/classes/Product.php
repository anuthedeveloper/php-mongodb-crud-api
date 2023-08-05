<?php 

class Product
{
    /** string collection */
    private $collection = "products";

    public $productColl;

    public function __construct() {
        global $db;
        // 
        $this->productColl = $db->selectCollection($this->collection);
    }

    public function findProduct( string $name ) : object|null
    {
        $result = $this->productColl->findOne(['name' => $name]);
        
        return $result; // returns null if not found
    }

    public function findAllProduct() : array
    {
        $cursor = $this->productColl->find(
            [],
            [
                'limit' => 6,
                'sort' => ['pop' => -1],
            ]
        );

        $results = [];
        foreach ($cursor as $docs) $results[] = $docs;

        return $results;
    }

    public function loadProducts( array $args = [] ) : string
    {
        $insertManyRes = $this->productColl->insertMany($args);
        // printf("Inserted %d document\n", $insertManyRes->getInsertedCount());
        return "success";
    }

    public function createProduct( array $args = [] ) : string
    {
        $name      = isset($args['name']) ? trim($args['name']) : "";
        $image     = isset($args['image']) ? trim($args['image']) : "";

        if ( !$name || !$image ) throw new Exception("Parameters are empty!", 1);

        $file_arr = explode(".", $image);
        $ext = end($file_arr);

        if ( !in_array($ext, ["jpg", "jpeg", "png"]) ) throw new Exception("Server expected a file, string given!", 1);
        
        if ( $this->findProduct($name) !== null ) throw new Exception("Product already exists!", 1);
        
        $insertRes = $this->productColl->insertOne([
            'name' => $name,
            'image' => $image
        ]);

        // printf("Inserted %d document\n", $insertRes->getInsertedCount());

        return "success";
    }

    public function updateProduct( array $args = [] ) : string
    {
        $name      = isset($args['name']) ? trim($args['name']) : "";
        $image     = isset($args['image']) ? trim($args['image']) : "";

        if ( is_array($args) && count($args) < 1 ) throw new Exception("Parameters are empty!", 1);

        // if ( !$name || !$image ) throw new Exception("Parameters are empty!", 1);

        if ( $this->findProduct($name) === null ) throw new Exception("Product does not exists!", 1);

        $file_arr = explode(".", $image);
        $ext = end($file_arr);

        if ( !in_array($ext, ["jpg", "jpeg", "png"]) ) throw new Exception("Server expected a file, string given!", 1);
        
        $updateRes = $this->productColl->updateOne(
            ['name' => $name],
            ['$set' => ['image' => $image]]
        );
        
        // printf("Modified %d document\n", $updateRes->getModifiedCount()); # number of document modified

        if ( $updateRes->getModifiedCount() === 0 ) throw new Exception("Updating product: $name failed!", 1);
        
        return "success";
    }

    public function deleteProduct( string $name ) : string
    {        
        $deleteRes = $this->productColl->deleteOne(['name' => $name]);

        // printf("Deleted %d document\n", $deleteRes->getDeletedCount());

        return "success";
    }
}

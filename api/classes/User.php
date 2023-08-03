<?php

class User
{
    public $db;

    private $collection = "users";

    public $userCollection;

    public function __construct() {
        global $db;

        $this->db = $db;

        if ( $this->checkIfCollectionExist() ) {
            $this->userCollection = $db->selectCollection($this->collection);
        } else {
            $this->userCollection = $db->createCollection($this->collection);
        }
    }

    private function checkIfCollectionExist () {
        foreach ($this->db->listCollectionNames() as $collectionName) {
            if ( $collectionName == $this->collection ) return true;
        }
    }

    public function findUser( string $email ) : object|null
    {
        $user = $this->userCollection->findOne(['email' => $email]);
        
        return $user; // returns null if not found
    }

    public function findAllUser() : array
    {
        $results = $this->userCollection->find(
            [],
            [
                'limit' => 5,
                'sort' => ['pop' => -1],
            ]
        );

        $users = [];
        foreach ($results as $docs) $users[] = $docs;

        return $users;
    }

    public function createUser( array $args = [] ) : string
    {
        $fullname   = isset($args['fullname']) ? trim($args['fullname']) : "";
        $email      = isset($args['email']) ? trim($args['email']) : "";
        $gender     = isset($args['gender']) ? trim($args['gender']) : "";

        if ( $this->findUser($email) !== null ) throw new Exception("User already exists!", 1);
         
        $insertRes = $this->userCollection->insertOne([
            'fullname' => $fullname,
            'email' => $email,
            'gender' => $gender
        ]);

        // printf("Inserted %d document\n", $insertRes->getInsertedCount());

        return "success";
    }

    public function updateUser( array $args = [] ) : string
    {
        $fullname   = isset($args['fullname']) ? trim($args['fullname']) : "";
        $email      = isset($args['email']) ? trim($args['email']) : "";
        $gender     = isset($args['gender']) ? trim($args['gender']) : "";

        if ( $this->findUser($email) === null ) throw new Exception("User does not exists!", 1);

        $updateRes = $this->userCollection->updateOne(
            ['email' => $email],
            ['$set' => ['gender' => $gender, 'fullname' => $fullname]]
        );

        // printf("Modified %d document\n", $updateRes->getModifiedCount()); # number of document modified

        return "success";
    }

    public function deleteUser( string $email ) : string
    {        
        $deleteRes = $this->userCollection->deleteOne(['email' => $email]);

        // printf("Deleted %d document\n", $deleteRes->getDeletedCount());

        return "success";
    }
}

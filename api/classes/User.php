<?php

class User
{
    /** string collection */
    private $collection = "users";

    public $userColl;

    public function __construct() {
        global $db;
        // 
        $this->userColl = $db->selectCollection($this->collection);
    }

    public function findUser( string $email ) : object|null
    {
        $user = $this->userColl->findOne(['email' => $email]);
        
        return $user; // returns null if not found
    }

    public function findAllUser() : array
    {
        $results = $this->userColl->find(
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
         
        $insertRes = $this->userColl->insertOne([
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

        $updateRes = $this->userColl->updateOne(
            ['email' => $email],
            ['$set' => ['gender' => $gender, 'fullname' => $fullname]]
        );

        // printf("Modified %d document\n", $updateRes->getModifiedCount()); # number of document modified

        return "success";
    }

    public function deleteUser( string $email ) : string
    {        
        $deleteRes = $this->userColl->deleteOne(['email' => $email]);

        // printf("Deleted %d document\n", $deleteRes->getDeletedCount());

        return "success";
    }
}

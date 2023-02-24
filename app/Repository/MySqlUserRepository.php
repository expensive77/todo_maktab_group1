<?php

namespace App\Repository;

use App\database\QueryBuilder;
use App\Repository\Contracts\RepositoryInterface;

class MySqlUserRepository extends MySqlBaseRepository implements RepositoryInterface {

    public function get() {

    }


    public function add(array $values){
        return QueryBuilder::table('users')
            ->create($values);
    }


    public function find(int $id) {

    }

    public function findByEmail(string $email) {

        return QueryBuilder::table('users')
            ->select(['*'])
            ->where('email', $email)
            ->first();
    }

}
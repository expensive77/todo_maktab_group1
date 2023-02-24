<?php

namespace App\Repository;

use App\database\QueryBuilder;

class MySqlTasksRepository
{
    public function get() {
        return QueryBuilder::table('tasks')->select()
            ->where('user_id', $_SESSION['user_id'])->get();
    }

    public function add(array $values){
        return QueryBuilder::table('tasks')
            ->create($values);
    }

    public function find(int $id) {
        return QueryBuilder::table('tasks')->select()
            ->where('user_id', $_SESSION['user_id'])->where('id', $id)->first();
    }
}
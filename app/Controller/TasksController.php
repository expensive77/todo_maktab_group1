<?php

namespace App\Controller;

use App\Application;
use App\database\QueryBuilder;
use App\helper\Session;
use App\helper\Validation;
use App\Repository\MySqlTasksRepository;

class TasksController
{
    private MySqlTasksRepository $taskRepository;
    public function __construct()
    {
        $this->taskRepository = new MySqlTasksRepository();
    }

    public function index()
    {
        if (!isset($_SESSION['user_id']) && !isset($_COOKIE['user_id'])){
            header('Location: login');
        }

        $tasks = $this->taskRepository->get();

        return Application::$app->router->renderView("task",compact('tasks'));
    }

    public function store()
    {
        $task = array(
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'user_id' => $_SESSION["user_id"]
        );

        $rules = [
            'title' => [Validation::RULE_REQUIRED],
            'description' => [Validation::RULE_REQUIRED]
        ];

        $validate = new Validation($task , $rules);

        if (!$validate->validate()){
            $errors = $validate->errors;
            (new Session)->setFlash('errors' ,$errors);
            return header("Location: /tasks");
        }

        $this->taskRepository->add($task);

        return header('Location: tasks');
    }

//    public function show(int $id)
//    {
//        $this->taskRepository->find($id);
//    }

    public function update()
    {
        $task = array(
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'user_id' => $_SESSION["user_id"]
        );

//        QueryBuilder::table('tasks')->update($task)->where()->execute();

        return header('Location: tasks');
    }
}
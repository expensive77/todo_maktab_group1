<?php

namespace App\Controller;

use App\Application;
use App\helper\Session;
use App\helper\Validation;
use App\Repository\MySqlUserRepository;

class RegisterController
{
    private MySqlUserRepository $userRepository;
    public function __construct()
    {
        $this->userRepository = new MySqlUserRepository();
    }

    public function index(){

        return Application::$app->router->renderView('register' );
    }

    public function store(){
        $user = array(
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => $_POST['password'],
        );

        $rules = [
            'name' => [Validation::RULE_REQUIRED],
            'email' => [Validation::RULE_REQUIRED , Validation::RULE_EMAIL , Validation::RULE_UNIQUE],
            'password' => [Validation::RULE_REQUIRED , [Validation::RULE_MIN , 'min' => 6]]
        ];

        $validate = new Validation($user, $rules);

        if (!$validate->validate()){
            (new Session)->setFlash('errors' ,$validate->errors);
            return header("Location: /register");
        }

        $this->userRepository->add($user);


        return header('Location: home');
    }
}
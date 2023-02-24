<?php

namespace App\Controller;

use App\Application;
use App\helper\Cookie;
use App\helper\Session;
use App\helper\Validation;
use App\Repository\MySqlUserRepository;

class LoginController
{

    private MySqlUserRepository $userRepository;
    private Session $session;
    private Cookie $cookie;
    public function __construct()
    {
        $this->userRepository = new MySqlUserRepository();
    }

    public function index(){
        Application::$app->controller::setLayout('auth');
        return Application::$app->router->renderView('login');
    }

    public function store(){
        $email = $_POST['email'] ?? null;
        $password = $_POST['password'] ?? null;

        $data = [
            'email' => $email,
            'password' => $password
        ];

        $rules = [
            'email' => [Validation::RULE_REQUIRED , Validation::RULE_EMAIL],
            'password' => [Validation::RULE_REQUIRED , [Validation::RULE_MIN , 'min' => 6]]
        ];

        $validate = new Validation($data , $rules);

        $user = $this->userRepository->findByEmail($email);

        if (!$validate->validate()){
            (new Session)->setFlash('errors' ,$validate->errors);
            return header("Location: /tasks");
        }else{
            if(empty($user)){
                (new Session)->setFlash('errors' , 'Wrong info');
                return header('Location: register');
            }

            if($user->password != $password){
                (new Session)->setFlash('errors' , 'Wrong info');
                return header('Location: register');
            }
        }


        (new Session())->setAuthSession($user->id);
        (new Cookie($user->id));

        return header('Location: home');
    }

    public function logout(){
        Session::destroy();
        Cookie::destroy();
        header('Location: login');
    }

}
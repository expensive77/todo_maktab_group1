<?php

namespace App\helper;

class Session
{
    private int $userId;
    protected const FLASH_KEY = "flash_messages";

    public function __construct()
    {
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as $key => &$flashMessage){
            $flashMessage['remove'] = true;
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    public function setFlash($key , $message){
        $_SESSION[self::FLASH_KEY][$key] = [
            'remove' => false,
            'value' => $message
        ];
    }

    public static function getFlash($key){
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }

    public function setAuthSession($user_id){
        $this->userId = $user_id;
        $_SESSION['user_id'] = $this->userId;
    }

    public static function destroy(){
//        echo "<pre>";
//        var_dump($_SESSION['user_id']);
//        echo "</pre>";
//        die();
        session_destroy();
    }

    public function __destruct(){
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as $key => &$flashMessage){
            if ($flashMessage['remove']){
                unset($flashMessages[$key]);
            }
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }


}
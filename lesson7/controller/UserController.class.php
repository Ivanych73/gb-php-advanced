<?php

class UserController extends Controller
{
    public $view = 'auth';
    public $title;

    function __construct()
    {
        parent::__construct();
        $this->title .= ' - авторизация';
    }

    public function login($data)
    {
        if (!$_POST) {
            return ['message' => "Вы пока не авторизованы"];
        } else {
            $user = New User([]);
            $result = $user->login($_POST['login'], $_POST['pass']);
            if (!$result['success']) {
                return ['message' => $result['message']];
            }else header("Location: index.php?path=user/personal");
        }

    }

    public function logoff($data)
    {
        $user = New User([]);
        if ($user->logoff()['success']) header("Location: index.php?path=user/login");
    }

    public function personal($data) {
        if ($_COOKIE['isAuthorized']) {
            return ['message' => "Добро пожаловать, {$_COOKIE['userName']}!"];
        }else header("Location: index.php?path=user/login");
    }

}
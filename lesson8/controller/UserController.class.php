<?php

class UserController extends Controller
{
    public $view = 'user';
    public $title;

    function __construct()
    {
        parent::__construct();
        $this->title .= ' - авторизация';
    }

    public function login($data)
    {
        $fromCart = $_GET['fromCart'];
        if (!$_POST) {
            if ($fromCart) return ['message' => "Для оформления заказа сначала надо авторизоваться!"];
            else return ['message' => "Вы пока не авторизованы"];
        } else {
            $user = New User([]);
            $result = $user->login($_POST['login'], $_POST['pass']);
            if (!$result['success']) {
                return ['message' => $result['message']];
            }else {
                if ($fromCart) header("Location: index.php?path=order/edit");
                else header("Location: index.php?path=user/personal");
            }
        }

    }

    public function logoff($data)
    {
        $user = New User([]);
        if ($user->logoff()['success']) header("Location: index.php?path=user/login");
    }

    public function personal($data) {
        if ($_COOKIE['isAuthorized']) {
            $user = New User([]);
            $orders = New Order([]);
            return [
                'message' => "Добро пожаловать, {$_COOKIE['userName']}!",
                'user' => $user->getInfo(),
                'orders' => $orders->getOrders(['user_id' => $_COOKIE['userId']])
            ];
        }else header("Location: index.php?path=user/login");
    }

}
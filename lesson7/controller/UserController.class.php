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

    public function save($userData) {
        if (!is_array($userData) || count($userData) == 0) return false;
        else {
            $user = New User([]);
            $result = $user->save($userData);
            return $result;
        }
    }

    public function saveAsAjax($data) {
        if ($data['actionSuccess']) $_GET['actionSuccess'] = false;
        $result = $this->save($_POST);
        $_GET['asAjax'] = true;
        $_GET['ErrMsg'] = $result['message'];
        $_GET['actionSuccess'] = $result['success'];
        return $_GET['actionSuccess'];
    }

    public function new($userData) {
        if (!is_array($userData) || count($userData) == 0) return false;
        else {
            $user = New User([]);
            $result = $user->new($userData);
            return $result;
        }
    }

    public function newAsAjax($data) {
        if ($data['actionSuccess']) $_GET['actionSuccess'] = false;
        $result = $this->new($_POST);
        $_GET['asAjax'] = true;
        $_GET['ErrMsg'] = $result['message'];
        $_GET['actionSuccess'] = $result['success'];
        return $_GET['actionSuccess'];
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

    public function register($data) {

    }
}
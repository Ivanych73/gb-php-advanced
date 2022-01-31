<?php

class OrderController extends Controller
{
    public $view = 'order';
    public $title;

    function __construct()
    {
        parent::__construct();
        $this->title .= ' - заказ';
    }

    public function edit() {
        if(!$_COOKIE['isAuthorized']) {
            header("Location: index.php?path=user/login&fromCart=true");
        } else {
            $order = New Order([]);
            return $order->getUnsaved();
        }
    }

    public function show($data) {
        if(!$_COOKIE['isAuthorized']) {
            header("Location: index.php?path=user/login");
        } else {
            $order = New Order([]);
            $result = $order->getDetail($data['id']);
            $cart = New Cart([]);
            $goodsInOrder = $cart->getCart($data['id']);
            $result['goodsInOrder'] = $goodsInOrder;
            if($_GET['asAdmin']) $result['asAdmin'] = true;
            return $result;
        }
    }

    public function changeStatusAsAjax() {
        if ($data['actionSuccess']) $_GET['actionSuccess'] = false;
        $result = $this->changeStatus($_POST['id'], $_POST['status_id']);
        $_GET['asAjax'] = true;
        $_GET['ErrMsg'] = $result['message'];
        $_GET['actionSuccess'] = $result['success'];
        return $_GET['actionSuccess'];
    }

    public function cancel($data) {
        if(!$_COOKIE['isAuthorized']) {
            header("Location: index.php?path=user/login");
        } else {
            $result = $this->changeStatus($data['id'], 5);
        }
        header("Location: {$_SERVER['HTTP_REFERER']}");
    }

    public function changeStatus($id, $newStatusId) {
        if(!$_COOKIE['isAuthorized']) {
            header("Location: index.php?path=user/login");
        } else {
            $order = New Order([]);
            $params = [
                'id' => $id,
                'status_id' => $newStatusId
            ];
            $result = $order->setOrderStatus($params);
            if ($result) $message = "Статус заказа $id успешно изменен!";
            else $message = "Не удается изменть статус заказа $id";
            return [
                'success' => $result,
                'message' => $message
            ];
        }
    }

    public function save() {
        $result = [
            'success' => false,
            'message' => "Ошибка! Не удается сохранить заказ!"
        ];
        if (!$_POST['totalprice']) {
            return $result;
        }else {
            $order = New Order([]);
            if ($order->save($_POST)['success']) {
                $result = [
                    'success' => true,
                    'message' => "Ваш заказ успешно оформлен! Вы можете просмотреть или изменить его в личном кабинете"
                ];
            }
            if ($_POST['saveCustomer']) {
                $user = New User([]);
                $userData['name'] = $_POST['name'];
                $userData['phone'] = $_POST['phone'];
                $userData['email'] = $_POST['email'];
                $userData['address'] = $_POST['address'];
                $userResult = $user->save($userData);
                if(!$userResult.['success']){
                    $result['message'] .= ' '.$userResult['message'];
                }
            }
        }
        return $result;
    }

}
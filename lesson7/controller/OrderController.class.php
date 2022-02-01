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
            return $result;
        }
    }

    public function cancel($data) {
        if(!$_COOKIE['isAuthorized']) {
            header("Location: index.php?path=user/login");
        } else {
            $order = New Order([]);
            $result = $order->cancelByClient($data['id']);
        }
        header("Location: {$_SERVER['HTTP_REFERER']}");
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
                    'message' => "Ваш заказ успешно оформлен! Вы можете просмотреть или изменить его на страничке \"Мои заказы\""
                ];
            }
        }
        return $result;
    }

}
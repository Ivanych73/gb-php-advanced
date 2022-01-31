<?php
class AdminController extends Controller
{
    
    public $view = 'admin';
    public $title;

    function __construct()
    {
        parent::__construct();
        $this->title .= ' - панель управления';
    }

    private function checkPrivileges(){
        if(!$_COOKIE['isAuthorized'] || !$_COOKIE['isAdmin']) {
            header("Location: index.php?path=user/login&toAdmin=true");
        }else return;
    }

    public function orders() {
        $this->checkPrivileges();
        $order = New Order([]);
        if($_POST) {
            //$res['orders']['message'] = $order->getOrders($_POST);
            $res['orders'] = $order->getOrders($_POST);
            $res['asAdmin'] = true;
            $res['datefrom'] = $_POST['datefrom'];
            $res['dateto'] = $_POST['dateto'];
            $res['total_pricefrom'] = $_POST['total_pricefrom'];
            $res['total_priceto'] = $_POST['total_priceto'];
            $res['status_id'] = $_POST['status_id'];
            return $res;
        } else {
            $res['orders'] = $order->getOrders();
            $res['asAdmin'] = true;
            return $res;
        }
    }

    public function goods() {
        $this->checkPrivileges();
        $good = New Good([]);
        $res['goods'] = $good->getGoods();
        $res['asAdmin'] = true;
        return $res;
    }

    public function editgood($data) {
        $this->checkPrivileges();
        $good = New Good(['id' => $data['id']]);
        return $good->getGoodInfo();
    }

    public function saveGood() {
        $this->checkPrivileges();
        if(!$_POST) {
            return [
                'success' => false,
                'message' => "Нет пост-параметров"
            ];
        }else {
            $good = New Good([]);
            return $good->updateGood($_POST);
        }
    }

    public function saveGoodAsAjax() {
        $this->checkPrivileges();
        if ($data['actionSuccess']) $_GET['actionSuccess'] = false;
        $_GET['asAjax'] = true;

        $res = $this->saveGood();
        $_GET['ErrMsg'] = $res['message'];
        $_GET['actionSuccess'] = $res['success'];
        return $_GET['actionSuccess'];
    }

    public function deleteGood($data) {
        $this->checkPrivileges();
        if(!$data['id']) {
            return [
                'success' => false,
                'message' => "Не указан id товара для удаления!"
            ];
        } else {
            $good = New Good([]);
            return $good->deleteGood($data['id']);
        }
    }

    public function deleteGoodAsAjax($data) {
        $this->checkPrivileges();
        if ($data['actionSuccess']) $_GET['actionSuccess'] = false;
        $_GET['asAjax'] = true;

        $res = $this->deleteGood($data);
        $_GET['ErrMsg'] = $res['message'];
        $_GET['actionSuccess'] = $res['success'];
        return $_GET['actionSuccess'];
    }
    
}
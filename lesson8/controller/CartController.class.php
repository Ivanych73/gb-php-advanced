<?php
class CartController extends Controller
{

    public $view = 'cart';
    public $title;

    function __construct()
    {
        parent::__construct();
        $this->title .= ' - корзина';
    }

    public function index($data)
    {
        $cart = New Cart([]);
        return ['cart' => $cart->getCart()];
    }

    public function add($data) {
        if ($data['actionSuccess']) $_GET['actionSuccess'] = false;
        $_GET['asAjax'] = true;   
        if (!$_POST['id_good']) {
            return $_GET['actionSuccess'];
        } else {
            $cart = New Cart([]);
            if($cart->add($_POST['id_good'])) $_GET['actionSuccess'] = true;
            return $_GET['actionSuccess'];
        }
    }

    public function remove($data) {
        if ($data['actionSuccess']) $_GET['actionSuccess'] = false;
        $_GET['asAjax'] = true;   
        if (!$_POST['id_good']) {
            return $_GET['actionSuccess'];
        } else {
            $cart = New Cart([]);
            if($cart->remove($_POST['id_good'])) $_GET['actionSuccess'] = true;
            return $_GET['actionSuccess'];
        }
    }
}
?>
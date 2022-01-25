<?php

class Cart extends Model
{    
    public function add($id_good) {
        $cart = db::getInstance()->Select(
            "SELECT id, good_id, quantity from cart where uuid = :uuid and good_id = :good_id",
            ['uuid' => $_COOKIE['cart_uuid'], 'good_id' => $id_good]
        );
        if (count($cart) == 0) {
            $query = "INSERT INTO cart (good_id, quantity, uuid) values (:good_id, :quantity, :uuid)";
            $params = [
                'good_id' => $id_good,
                'quantity' => 1,
                'uuid' => $_COOKIE['cart_uuid']
            ];
            $res = db::getInstance()->Query($query, $params);
            if ($res == 0) return false;
        } else {
            $query = "UPDATE cart set quantity = quantity+1 where id = :id";
            $params = ['id' => $cart[0]['id']];
            $res = db::getInstance()->Query($query, $params);
            if ($res == 0) return false;
        }
        return true;
    }

    public function remove($id_good) {
        $cart = db::getInstance()->Select(
            "SELECT id, quantity FROM cart WHERE uuid = :uuid and good_id = :good_id",
            ['uuid' => $_COOKIE['cart_uuid'], 'good_id' => $id_good]
        );
        if (count($cart) > 0) {
            if ($cart[0]['quantity'] == 1) {
                $query = "DELETE FROM cart WHERE id = :id";
            } else {
                $query = "UPDATE cart SET quantity = quantity-1 WHERE id = :id";
            }
            $params = ['id' => $cart[0]['id']];
            $res = db::getInstance()->Query($query, $params);
            if (!$res) return false;
            else return true;
        } else {
            return false;
        }        
    }

    public function getCart($orderId = false) {
        if(!$orderId) {
            $select = "SELECT good_id, quantity from cart where uuid = :uuid";
            $params = ['uuid' => $_COOKIE['cart_uuid']];
        } else {
            $select = "SELECT good_id, quantity from cart where order_id = :order_id";
            $params = ['order_id' => $orderId];
        }
        $cart = db::getInstance()->Select($select, $params);
        $result = [];
        foreach ($cart as $value) {
            $item = New Good(['id' => $value['good_id']]);
            $good = $item->getGoodInfo();
            $result[] = [
                'goodId' => $value['good_id'],
                'quantity' => $value['quantity'],
                'goodTitle' => $good['goodTitle'],
                'price' => $good['price'],
                'imageTitle' => $good['imageTitle']
            ];
        }
        return $result;
    }
}

?>
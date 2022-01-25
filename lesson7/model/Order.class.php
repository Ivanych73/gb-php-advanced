<?php

class Order extends Model {
    protected static $table = 'orders';

    private $order_statuses_open = [
        '1' => 'Принят в работу',
        '2' => 'Обрабатывается',
        '3' => 'Передан службе доставки'
    ];
    private $order_statuses_closed = [
        '4' => 'Успешно завершен',
        '5' => 'Отменен клиентом',
        '6' => 'Отменен магазином'
    ];

    protected static function setProperties()
    {
        self::$properties['phone'] = [
            'type' => 'varchar',
            'size' => 512
        ];

        self::$properties['address'] = [
            'type' => 'varchar',
            'size' => 512
        ];

        self::$properties['email'] = [
            'type' => 'float'
        ];
    }

    public function getUnsaved() {
        $cart = New Cart([]);
        $result['goods'] = $cart->getCart();
        $user = New User([]);
        $result['user'] = $user->getInfo();
        return $result;
    }

    public function getOrders($filter = []) {
        if(count($filter) !=0) {
            $filterStr = " WHERE";
            $i = 0;
            foreach($filter as $key => $value) {
                $filterStr .= " $key = :$key";
                $i++;
                if($i<count($filter)) {
                    $filterStr .= " AND";
                }
            }
        }
        $select = "SELECT orders.id, date, order_statuses.status, total_price FROM orders JOIN order_statuses ON order_statuses.id = status_id";
        $select .= $filterStr;
        $res = (db::getInstance()->Select($select, $filter));
        foreach ($res as &$value) {
            if (!in_array($value['status'], $this->order_statuses_closed)) {
                $value['open'] = true;
            }
        }
        return $res;
    }

    public function setOrderStatus($params = []) {
        if (count($params) == 0 || !$params['id'] || !$params['status_id']) return false;
        else {
            $query = "UPDATE orders SET status_id = :status_id WHERE id = :id";
            $result = db::getInstance()->Query($query, $params);
            return $result;
        }
    }

    public function cancelByClient($id = 0) {
        $result = $this->setOrderStatus(['id' => $id, 'status_id' => 5]);
        return $result;
    }

    public function cancelByShop($id = 0) {
        $result = $this->setOrderStatus(['id' => $id, 'status_id' => 6]);
        return $result;
    }

    public function delivered($id = 0) {
        $result = $this->setOrderStatus(['id' => $id, 'status_id' => 4]);
        return $result;
    }

    public function getDetail($id = 0) {
        $select = "SELECT orders.id, date, order_statuses.status, total_price, name, email, phone, address, comments FROM orders JOIN order_statuses ON order_statuses.id = status_id WHERE orders.id = :id";
        $params = ['id' => $id];
        $order = db::getInstance()->Select($select, $params)[0];
        if (!in_array($order['status'], $this->order_statuses_closed)) {
            $order['open'] = true;
        }
        return $order;
    }

    public function save($params) {
        $query = "INSERT INTO orders (user_id, status_id, date, total_price, name, email, phone, address, comments) VALUES (:user_id, 1, :date, :total_price, :name, :email, :phone, :address, :comments)";
        $params = [
            'user_id' => $_COOKIE['userId'],
            'date' => date("Y-m-d"),
            'total_price' => $_POST['totalprice'],
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'phone' => $_POST['phone'],
            'address' => $_POST['address'],
            'comments' => $_POST['comments']
        ];
        if (!db::getInstance()->Query($query, $params)) {
            return ['success' => false];
        } else {
            $select = "SELECT id FROM orders WHERE user_id = :user_id AND date = :date AND total_price = :total_price AND name = :name AND email = :email AND phone = :phone AND address = :address AND status_id = 1";
            $params = [
                'user_id' => $_COOKIE['userId'],
                'date' => date("Y-m-d"),
                'total_price' => $_POST['totalprice'],
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone'],
                'address' => $_POST['address']
            ];
            $orderId = db::getInstance()->Select($select, $params);
            if (count($orderId) == 0) {
                return ['success' => false];
            } else {
                $query = "UPDATE cart  SET user_id = :user_id, order_id = :order_id, uuid = NULL WHERE uuid = :uuid";
                $params = [
                    'user_id' => $_COOKIE['userId'],
                    'order_id' => $orderId[0]['id'],
                    'uuid' => $_COOKIE['cart_uuid']
                ];
                if(!db::getInstance()->Query($query, $params)) {
                    return ['success' => false];
                } else {
                    return ['success' => true];
                }
            }
        }
    }
}

?>
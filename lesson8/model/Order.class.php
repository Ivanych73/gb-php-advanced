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

    private function parseFilter($filter){
        $arrToStr = [];
        $arrParams = [];
        foreach ($filter as $key => $value) {
            if ($value !== ''){
                switch ($key) {
                    case 'datefrom':
                        $arrToStr[] = "date >= :datefrom";
                        $arrParams['datefrom'] = $value;
                        break;
                    case 'dateto':
                        $arrToStr[] = "date <= :dateto";
                        $arrParams['dateto'] = $value;
                        break; 
                    case 'date':
                        $arrToStr[] = "date = :date";
                        $arrParams['date'] = $value;
                        break; 
                    case 'total_pricefrom':
                        $arrToStr[] = "total_price >= :total_pricefrom";
                        $arrParams['total_pricefrom'] = $value;
                        break;
                    case 'total_priceto':
                        $arrToStr[] = "total_price <= :total_priceto";
                        $arrParams['total_priceto'] = $value;
                        break;
                    case 'total_price':
                        $arrToStr[] = "total_price = :total_price";
                        $arrParams['total_price'] = $value;
                        break; 
                    case 'user_id':
                        $arrToStr[] = "user_id = :user_id";
                        $arrParams['user_id'] = $value;
                        break;
                    case 'status_id':
                        if (is_array($value)){
                            $pdoVarsArr=[];
                            for ($i=0;$i<count($value); $i++){
                                $pdoVarName = "status_id$i";
                                $pdoVarsArr[] = ":$pdoVarName";
                                $arrParams[$pdoVarName] = $value[$i];
                            }
                            $addStr = "status_id in (";
                            $addStr .= implode(', ',$pdoVarsArr);
                            $addStr .= ")";
                            $arrToStr[] = $addStr;
                        } else {
                            $arrToStr[] = "status_id = :status_id";
                            $arrParams['status_id'] = $value;  
                        }
                        break;
                }
            }
        }
        if (count($arrToStr) >0) {
            $filterStr = " WHERE ";
            $filterStr .= implode(' AND ', $arrToStr);
        }
        
        return ['filterStr' => $filterStr, 'params' => $arrParams];
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
            $filterStr = $this->parseFilter($filter)['filterStr'];
            $params = $this->parseFilter($filter)['params'];
        }else $params = $filter;
        
        $select = "SELECT orders.id, date, order_statuses.status, total_price, status_id FROM orders JOIN order_statuses ON order_statuses.id = status_id";
        $select .= $filterStr;
        $res = (db::getInstance()->Select($select, $params));
        foreach ($res as &$value) {
            if (!in_array($value['status'], $this->order_statuses_closed)) {
                $value['open'] = true;
            }
        }
        return $res;
        //return $filterStr;
    }

    public function setOrderStatus($params = []) {
        if (count($params) == 0 || !$params['id'] || !$params['status_id']) return false;
        else {
            $query = "UPDATE orders SET status_id = :status_id WHERE id = :id";
            $result = db::getInstance()->Query($query, $params);
            return $result;
        }
    }

    public function getDetail($id = 0) {
        $select = "SELECT orders.id, date, order_statuses.status, status_id, total_price, name, email, phone, address, comments FROM orders JOIN order_statuses ON order_statuses.id = status_id WHERE orders.id = :id";
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
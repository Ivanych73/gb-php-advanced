<?php

class User extends Model {
    protected static $table = 'users';

    protected static function setProperties()
    {
        self::$properties['id'] = [
            'type' => 'int'
        ];

        self::$properties['login'] = [
            'type' => 'varchar',
            'size' => 63
        ];

        self::$properties['pass'] = [
            'type' => 'varchar',
            'size' => 63
        ];

        self::$properties['salt'] = [
            'type' => 'varchar',
            'size' => 64
        ];

        self::$properties['name'] = [
            'type' => 'varchar',
            'size' => 64
        ];

        self::$properties['email'] = [
            'type' => 'varchar',
            'size' => 64
        ];

        self::$properties['phone'] = [
            'type' => 'varchar',
            'size' => 12
        ];

        self::$properties['isCustomer'] = [
            'type' => 'tinyint'
        ];

        self::$properties['isAdmin'] = [
            'type' => 'tinyint'
        ];

        self::$properties['address'] = [
            'type' => 'text'
        ];
    }

    private function getHash($password) {
        $letters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        for ($i = 0; $i < 63; $i++) {
            $salt .= substr($letters, rand(0, 61), 1);
        }
        $password = md5($password.$salt);
        return ['password' => $password, 'salt' => $salt];
    }

    public static function login($login, $pass)
    {
        $user = db::getInstance()->Select(
            "SELECT id, name, login, pass, salt, is_admin from users where login = :login",
            ['login' => $login]
        );

        if (count($user) == 0) {
            return [
                'success' => false, 
                'message' => "Пользователь с логином $login не зарегистрирован! Прежде, чем пробовать авторизоваться, сначала зарегистрируйтесь!"
            ];
        }else {
            $user = $user[0];
            $pass = md5($pass.$user['salt']);
            if ($pass != $user['pass']) {
                return [
                    'success' => false, 
                    'message' => "Неверно указан пароль пользователя с логином {$user['login']}! Попробуйте еще раз!"
                ];
            }else {
                setcookie('isAuthorized', true);
                if ($user['name']) setcookie('userName', $user['name']);
                else setcookie('userName', $user['login']);
                if ($user['is_admin']) setcookie('isAdmin', $user['is_admin']);
                setcookie('userId', $user['id']);
                return ['success' => true];
            }
        }
    }

    public static function logoff() {
        setcookie('isAuthorized', false, time()-3600);
        setcookie('userName', "", time()-3600);
        setcookie('isAdmin', false, time()-3600);
        setcookie('userId', "", time()-3600);
        return ['success' => true];
    }

    public function getInfo() {
        if(!$_COOKIE['isAuthorized']) {
            return ['success' => false, 'message' => "Пользователь не авторизован! Невозможно получить информацию о неавторизованном пользователе!"];
        }else {
            $select = "SELECT name, phone, email, address FROM users WHERE id = :id";
            $params = ['id' => $_COOKIE['userId']];
            $user = db::getInstance()->Select($select, $params);
            return $user[0];
        }
    }

    public function save($userData) {
        if(!$_COOKIE['isAuthorized']) {
            return ['success' => false, 'message' => "Пользователь не авторизован!"];
        }else {
            $params = $userData;
            if(array_key_exists('pass', $params)) {
                $hash = $this->getHash($params['pass']);
                $params['pass'] = $hash['password'];
                $params['salt'] = $hash['salt'];
            };
            $query = "UPDATE users SET";
            $i = 0;
            foreach ($params as $key => $value){
                $query .= " $key = :$key";
                $i++;
                if($i<count($params)) {
                    $query .= ", ";
                }
            }
            $query .= " WHERE id = :id";
            $params['id'] = $_COOKIE['userId'];
            $result = db::getInstance()->Query($query, $params);
            if($result) $message = "Данные успешно обновлены!";
            else $message = "Ошибка обновления данных!";
            return ['success' => $result, 'message' => $message];
        }
    }

    public function new($userData) {
            $select = "SELECT id FROM users where login = :login";
            $params['login'] = $userData['login'];
            $result = count(db::getInstance()->Select($select, $params));
            if ($result) return [
                'success' => false,
                'message' => "Пользователь с таким логином уже зарегистрирован! Придумайте другой логин!"
            ];
            else{
                $params = $userData;
                if(array_key_exists('pass', $params)) {
                    $hash = $this->getHash($params['pass']);
                    $params['pass'] = $hash['password'];
                    $params['salt'] = $hash['salt'];
                };
                $query = "INSERT INTO users (login, pass, salt, is_customer, is_admin) VALUES (:login, :pass, :salt, 1, 0)";
                $result = db::getInstance()->Query($query, $params);
                if($result) $message = "Вы успешно зарегистрированы!";
                else $message = "Ошибка регистрации пользователя!";
                return ['success' => $result, 'message' => $message];
            }

    }
    
}

?>
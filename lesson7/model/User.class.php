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

    public static function login($login, $pass)
    {
        $user = db::getInstance()->Select(
            "SELECT name, login, pass, salt, is_admin from users where login = :login",
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
                return ['success' => true];
            }
        }
    }

    public static function logoff() {
        setcookie('isAuthorized', false, time()-3600);
        setcookie('userName', "", time()-3600);
        setcookie('isAdmin', false, time()-3600);
        return ['success' => true];
    }
    
}

?>
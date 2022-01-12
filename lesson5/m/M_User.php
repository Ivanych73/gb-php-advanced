<?
class M_User {
	function auth($login, $pass){
	    include_once('db_conf.php');
        $stmt = $db->prepare("select login, name, pass, salt from users where login = :login");
        $stmt->execute(['login' => $login]);
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (count($res) == 0) {
            $error = "Пользователь с логином $login не зарегистрирован. Прежде, чем пытаться авторизоваться, сначала зарегистрируйтесь!";
            $success = false;
        }
        else {
            $hash = md5($pass.$res[0]['salt']);
            if ($hash == $res[0]['pass']) {
                setcookie('isAuthorized', true);
                if ($res[0]['name']) {
                    setcookie('userName', $res[0]['name']);
                } else {
                    setcookie('userName', $res[0]['login']);
                }
                $error = "";
                $succsess = true;
            }
            else $error = "Неверно указан пароль пользователя $login";
            $success = false;
        }
        return ['success' => $succsess, 'error' => $error];
    }

    function register($login, $pass) {        
	    include_once('db_conf.php');
        $stmt = $db->prepare("select name from users where login = :login");
        $stmt->execute(['login' => $login]);        
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $success = false;
        if (count($res) != 0) {
            $error = "Пользователь с логином $login уже зарегистрирован. Попробуйте выбрать другой логин!";
        } else {
            $letters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
            for ($i = 0; $i < 63; $i++) {
                $salt .= substr($letters, rand(0, 61), 1);
            }
            $pass = md5($pass.$salt);
            $stmt = $db->prepare("insert into users (login, pass, is_customer, is_admin, salt) values (:login, :pass, 1, 0, :salt)");
            if (!$stmt->execute(['login' => $login, 'pass' => $pass, 'salt' => $salt])) {
                $error = "Произошла ошибка при создании нового пользователя";
            } else {
                $succsess = true;
                $error = $login;
            }
        }

        return ['success' => $succsess, 'error' => $error];
    }

    function logout() {
        setcookie('isAuthorized', false, time()-3600);
        setcookie('userName', '', time()-3600);
        return true;
    }
}
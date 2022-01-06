<?
class M_User {
	function auth($login, $pass){
	    include_once('db_conf.php');
        $stmt = $db->prepare("select name, pass, salt from users where login = :login");
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
                setcookie('userName', $res[0]['name']);
                $error = "";
                $succsess = true;
            }
            else $error = "Неверно указан пароль пользователя $login";
            $success = false;
        }
        return ['success' => $succsess, 'error' => $error];
    }

    function logout() {
        setcookie('isAuthorized', false, time()-3600);
        setcookie('userName', '', time()-3600);
        return true;
    }
}
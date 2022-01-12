<?php

include_once('m/M_User.php');

class C_User extends C_Base
{	
	public function action_auth(){
		$this->title .= '::Авторизация';
        $user = new M_User();
		if ($_COOKIE['isAuthorized']) {
			$info = "Вы уже авторизованы, как {$_COOKIE['userName']}";
		}
		else $info = "Пользователь не авторизован";
        if($_POST){
            $login = strip_tags(trim((string)$_POST['login']));
			$pwd = strip_tags(trim((string)$_POST['pwd']));
            $result = $user->auth($login,$pwd);
			if ($result['success']) {
				header("Location: index.php?c=User&act=personal");
			} else {
				$info = $result['error'];
			}
		}
		if (!$result['success']) $this->content = $this->Template('v/v_auth.php', array('text' => $info));
	}

	public function action_logout() {
		$user = new M_User();
		if ($user->logout()) header("Location: index.php?c=User&act=auth");
	}

	public function action_personal() {
		$this->title .= '::Личный кабинет';
		$this->content = $this->Template('v/v_personal.php', array('userName' => $_COOKIE['userName']));
	}

	public function action_register() {
		$this->title .= '::Регистрация';
        $user = new M_User();
		$info = "Придумайте логин и пароль";
		if($_POST){
            $login = strip_tags(trim((string)$_POST['login']));
			$pwd = strip_tags(trim((string)$_POST['pwd']));
			$confirmPwd = strip_tags(trim((string)$_POST['confirmPwd']));
			if ($pwd == $confirmPwd) {
				$result = $user->register($login,$pwd);
				if ($result['success']) {
					$info = "Вы успешно зарегистрировались, как {$result['error']}";
				} else $info = $result['error'];
			} else $info = "Введенные пароли не совпадают!";
		}
		$this->content = $this->Template('v/v_register.php', array('text' => $info));
	}
}

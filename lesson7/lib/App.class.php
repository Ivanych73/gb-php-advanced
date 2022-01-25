<?php

class App
{
    public static function Init()
    {
        db::getInstance()->Connect(Config::get('db_user'), Config::get('db_password'), Config::get('db_base'));
        if (!$_COOKIE['cart_uuid']) setcookie('cart_uuid', uniqid('', true), time()+604800);
        self::web($_GET['path'] ? $_GET['path'] : '');
    }
	
  //http://site.ru/index.php?path=News/delete/5	

    protected static function web($url)
    {
        $url = explode("/", $url);
        if (!empty($url[0])) {
        $_GET['page'] = $url[0];
        if (isset($url[1])) {
            if (is_numeric($url[1])) {
                $_GET['id'] = $url[1];
            } else {
                $_GET['action'] = $url[1];
            }
            if (isset($url[2])) {
                $_GET['id'] = $url[2];
            }
        }
    }
        else{
            $_GET['page'] = 'index';
        }

        if (isset($_GET['page'])) {
            $controllerName = ucfirst($_GET['page']) . 'Controller';//IndexController
            $methodName = isset($_GET['action']) ? $_GET['action'] : 'index';
            $controller = new $controllerName();

            $data = [
                'content_data' => $controller->$methodName($_GET),
                'pageTitle' => $controller->title,
                //'categories' => Category::getCategories(0)
            ];

            if (!$_COOKIE['isAuthorized']) {
                $data['links']['loginMessage'] = "Вы пока не авторизованы";
                $data['links']['loginLink'] = ['href' => "index.php?path=user/login", 'text' => "Войти"];
                $data['links']['regLink'] = ['href' => "index.php?path=user/register"];
            } else {
                $data['links']['loginMessage'] = "Вы вошли, как {$_COOKIE['userName']}";
                $data['links']['loginLink'] = ['href' => "index.php?path=user/logoff", 'text' => "Выход"];
                $data['links']['personalLink'] = ['href' => "index.php?path=user/personal", 'text' => "Личный кабинет"];
                if ($_COOKIE['isAdmin']) {
                    $data['links']['adminLink'] = ['href' => "#"];
                }
            }

            $view = $controller->view . '/' . $methodName . '.html';
            if (!isset($_GET['asAjax'])) {
                $loader = new Twig_Loader_Filesystem(Config::get('path_templates'));
                $twig = new Twig_Environment($loader);
                $template = $twig->loadTemplate($view);
                

                echo $template->render($data);
            } else {
                if ($_GET['actionSuccess']) $data['actionSuccess'] = true;
                if ($_GET['ErrMsg']) $data['ErrMsg'] = $_GET['ErrMsg'];
                echo json_encode($data);
            }
        }
    }


}
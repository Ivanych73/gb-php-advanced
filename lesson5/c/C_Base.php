<?php
//
// Базовый контроллер сайта.
//
abstract class C_Base extends C_Controller
{
	protected $title;		// заголовок страницы
	protected $content;		// содержание страницы
    protected $keyWords;
	protected $authblock;

     protected function before(){

		$this->title = 'тест';
		$this->content = '';
		$this->keyWords="...";
		if ($_COOKIE['isAuthorized']) {
			$this->authblock = "<a href='index.php?c=User&act=logout'>Выход</a>
			<a href='index.php?c=User&act=personal'>Личный кабинет</a>";
		} else {
			$this->authblock="<a href='index.php?c=User&act=auth'>Войти</a>
			<a href='index.php?c=User&act=register'>Зарегистрироваться</a>";
		}

	}
	
	//
	// Генерация базового шаблона
	//	
	public function render()
	{
		$vars = array('title' => $this->title, 'content' => $this->content,'kw' => $this->keyWords, 'authblock' => $this->authblock);
		$page = $this->Template('v/v_main.php', $vars);				
		echo $page;
	}	
}

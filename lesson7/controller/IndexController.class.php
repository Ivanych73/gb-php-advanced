<?php

class IndexController extends Controller
{
    public $view = 'index';
    public $title;

    function __construct()
    {
        parent::__construct();
        $this->title .= ' - главная';
    }
	
	//метод, который отправляет в представление информацию в виде переменной content_data
	function index($data){
        $good = New Good([]);
        return ['goods' => $good->getGoods()];
	}

	/*function test($id){

    }
*/

}

//site/index.php?path=index/test/5
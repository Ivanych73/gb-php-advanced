<?php

spl_autoload_register(function ($classname) {
	include_once("c/$classname.php");
});

$action = 'action_';
$action .=(isset($_GET['act'])) ? $_GET['act'] : 'index';

switch ($_GET['c'])
{
	case 'articles':
		$controller = new C_Page();
		break;
	case 'User':
		$controller = new C_User();
		break;
	default:
		$controller = new C_Page();
}

$controller->Request($action);

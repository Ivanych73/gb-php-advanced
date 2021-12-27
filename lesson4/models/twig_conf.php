<?php

    include "{$_SERVER['DOCUMENT_ROOT']}/vendor/twig/twig/lib/Twig/Autoloader.php";
    Twig_Autoloader::register();
    try {
        $loader = new Twig_Loader_Filesystem("{$_SERVER['DOCUMENT_ROOT']}/lesson4/templates"); 
        $twig = new Twig_Environment($loader);       
        $template = $twig->loadTemplate('v-main.html');   
    }

    catch (Exception $e)  {
        die ('ERROR: ' . $e->getMessage());
    }

?>
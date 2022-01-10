<?php

    require_once('models/db_conf.php');
    include "{$_SERVER['DOCUMENT_ROOT']}/vendor/twig/twig/lib/Twig/Autoloader.php";
    Twig_Autoloader::register();

    $sql = "select title from images";
    $res = mysqli_query($connect, $sql);
    if (!$res) {
        die("Error - ".mysqli_error($connect));
    } else
        while ($data = mysqli_fetch_assoc($res)) {
            $images[] = $data;
        }

    try {
        $loader = new Twig_Loader_Filesystem('templates'); 
        $twig = new Twig_Environment($loader);       
        $template = $twig->loadTemplate('v-main.html');
        echo $template->render(['content' => 'v-gallery.html', 'images' => $images, 'pageTitle' => 'Фотогалерея']);      
    }

    catch (Exception $e)  {
        die ('ERROR: ' . $e->getMessage());
    }
?>
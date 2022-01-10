<?php

    if ($_GET['title']) {
        $imageTitle = strip_tags(trim((string)$_GET['title']));
    }
    include "{$_SERVER['DOCUMENT_ROOT']}/vendor/twig/twig/lib/Twig/Autoloader.php";
    Twig_Autoloader::register();

    try {
        $loader = new Twig_Loader_Filesystem("../templates"); 
        $twig = new Twig_Environment($loader);       
        $template = $twig->loadTemplate('v-main.html');
        echo $template->render(['content' => 'v-detail.html', 'imagetitle' => $imageTitle, 'pageTitle' => "Детальный просмотр - $imageTitle"]);      
    }

    catch (Exception $e)  {
        die ('ERROR: ' . $e->getMessage());
    }
?>
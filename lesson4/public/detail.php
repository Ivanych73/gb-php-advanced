<?php

    if ($_GET['id']) {
        $goodId = (int)$_GET['id'];
    }

    require_once('../models/db_conf.php');
    $sql = "select image_title, description, price, good_title from goods_list where good_id = $goodId";
    $res = $db->query($sql, PDO::FETCH_ASSOC);
    $error_array = $db->errorInfo(); 
    if($db->errorCode() != 0000) 
        die ("SQL ошибка: " . $error_array[2]);
    $good = $res->fetch();
    require_once('../models/twig_conf.php');
    echo $template->render(['content' => 'v-detail.html', 'good' => $good, 'pageTitle' => "Детальный просмотр - {$good['good_title']}"]);      

?>
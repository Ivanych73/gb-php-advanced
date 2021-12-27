<?php

    const GOODS_PER_PAGE = 3;

    require_once('db_conf.php');
    require_once('twig_conf.php');

    function getGoodsByCount($db, $count, $offset = 0) {
        $sql = "select image_title, good_id, price, good_title from goods_list order by good_id asc limit $count offset $offset";
        $res = $db->query($sql, PDO::FETCH_ASSOC);
        $error_array = $db->errorInfo(); 
        if($db->errorCode() != 0000) 
            die ("SQL ошибка: " . $error_array[2]);
        $goods = $res->fetchAll();
        return $goods;
    }

?>
<?php

    require_once("../models/models.php");
    if (!$_POST['count']) {
        echo "";
    } else {
        $count = (int)$_POST['count'];
        $goods = getGoodsByCount($db, GOODS_PER_PAGE, GOODS_PER_PAGE*$count);
        $template = $twig->loadTemplate('v-goods.html');
        echo $template->render(['goods' => $goods]);
    }

?>
<?php

    require_once('models/models.php');

    $goods = getGoodsByCount($db, GOODS_PER_PAGE);
    echo $template->render(['content' => 'v-catalog.html', 'goods' => $goods, 'pageTitle' => 'Каталог']);      

?>
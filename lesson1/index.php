<?php

    require_once('pants.class.php');

    $jeans = new Pants('джинсы', 1000, 36, 'синий', '502');
    if ($jeans->setForWhom('men') === true) {
        $jeans->setDiscount(10);
        $jeans->showInfo();
    }else echo "Ошибка вывода информации о товаре!";

?>
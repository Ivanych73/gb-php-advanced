<?php

    function showInfo($object) {
        echo "Итоговая цена на товар {$object->getTitle()} составит {$object->getFinalPrice()}<br>";
        echo "Итоговый доход от товара {$object->getTitle()} составит {$object->getTotalIncome()}<br>";
    }

    spl_autoload_register(function ($className){
        include_once "classes/$className.php";
    });

    $regularGood = new Regular('штучный', 1000);

    showInfo($regularGood);

    $digitalGood = new Digital('цифровой', 575);

    showInfo($digitalGood);

    $weightGood = new Weight('весовой', 300, 100);

    showInfo($weightGood);

    $single = DemoSingleton::getInstance();
    $single->echoSomeMessage("Это демонстрационное сообщение от singleton, переданное с использованием trait!");
?>
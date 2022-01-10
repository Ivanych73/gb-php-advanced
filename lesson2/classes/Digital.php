<?php

    require_once('Good.php');
    require_once('Regular.php');

    class Digital extends Good {
        public function getFinalPrice() {
          return (Regular::$finalPrice)/2;
        }

        use getIncome;
    }

?>
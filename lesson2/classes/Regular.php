<?php

    require_once('Good.php');

    class Regular extends Good {

        public static $finalPrice;
        
        public function __construct($title, $purchasePrice)
        {
            parent::__construct($title, $purchasePrice);
            $this->setFinalPrice();
        }

        public function getFinalPrice() {
            return self::$finalPrice;
        }

        private function setFinalPrice() {
            self::$finalPrice = ($this->getPurchasePrice()/100)*(100+$this->getTradeMargin());
        }

        use getIncome;
    }

?>
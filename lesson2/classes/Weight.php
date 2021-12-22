<?php

    require_once('Good.php');

    class Weight extends Good {
        private $weight;

        public function __construct($title, $purchasePrice, $weight){
            parent::__construct($title, $purchasePrice);
            $this->weight = (float)$weight;
            if ($this->weight > 10 || $this->weight<= 100) {
                $this->setTradeMargin(12);
            }else if ($this->weight <= 1000) {
                $this->setTradeMargin(8);
            }else if ($this->weight > 1000) {
                $this->setTradeMargin(3);
            }
        }

        public function getFinalPrice() {
            return (($this->getPurchasePrice()/100)*(100+$this->getTradeMargin()))*$this->weight;
        }

        public function getTotalIncome(){
            return $this->getFinalPrice() - ($this->getPurchasePrice() * $this->weight);
        }
    }

?>
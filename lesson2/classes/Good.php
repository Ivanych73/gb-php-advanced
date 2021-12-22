<?php

    require_once('traits.php');

    abstract class Good {
        private $title;
        private $purchasePrice;
        private $tradeMargin = 15;

//Конструктор
        public function __construct($title, $purchasePrice) {
            $this->title = $title;
            $this->purchasePrice = $purchasePrice;
        }

//Сеттеры

        public function setTradeMargin($tradeMargin){
            $this->tradeMargin = $tradeMargin;
        }

        public function setPurchasePrice($purchasePrice){
            $this->purchasePrice = $purchasePrice;
        }

//Геттеры
        public function getTitle() {
            return $this->title;
        }

        public function getTradeMargin(){
            return $this->tradeMargin;
        }

        public function getPurchasePrice(){
            return $this->purchasePrice;
        }

        abstract public function getFinalPrice();

        abstract public function getTotalIncome();

    }
?>
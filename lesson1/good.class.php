<?php

    class Good {
        private $title;
        private $price;
        private $description;
        private $discount;

        function __construct($title, $price){
            $this->title = $title;
            $this->price = $price;
        }

        public function getPrice() {
            return $this->price;
        }

        public function getTitle() {
            return $this->title;
        }
        public function getDescription() {
            return $this->description;
        }

        public function getDiscount() {
            return $this->discount;
        }

        public function getPriceWithDiscount() {
            return $this->price - ($this->price/100)*$this->discount;
        }

        public function setPrice($price) {
            $this->price = $price;
        }

        public function setTitle($title) {
            $this->title = $title;
        }
        public function setDescription($description) {
            $this->description = $description;
        }

        public function setDiscount($discount) {
            $this->discount = $discount;
        }

    }

?>

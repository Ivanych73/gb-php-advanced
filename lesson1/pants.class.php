<?php

    require_once('wear.class.php');

    class Pants extends Wear {
        protected $size;
        protected $color;
        protected $model;

        function __construct($title, $price, $size, $color, $model) {
            parent::__construct($title, $price);
            $this->size = $size;
            $this->color = $color;
            $this->model = $model;
        }

        protected function setSize($size) {
            $this->size = $size;
        }

        protected function setColor($color) {
            $this->color = $color;
        }

        protected function setModel($model) {
            $this->model = $model;
        }

        protected function getSize() {
            return $this->size;
        }

        protected function getColor() {
            return $this->color;
        }

        protected function getModel() {
            return $this->model;
        }

        public function showInfo() {
            echo "Название: {$this->getTitle()} Цена с учетом всех скидок: {$this->getPriceWithDiscount()} Категория: {$this->showForWhom()} Размер: {$this->size} Цвет: {$this->color} Модель: {$this->model}";
        }
    }

?>
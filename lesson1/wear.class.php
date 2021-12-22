<?php

    require_once('good.class.php');

    class Wear extends Good {

        private $types = ['men', 'women', 'kids'];
        private $forWhom;

//Не делал через конструктор, так как конструктор не возвращает результат
//а здесь надо проверять входные данные

        public function setForWhom($forWhom) {
            if(!in_array($forWhom, $this->types)) {
                return "Unknown wear type";
            } else {
                $this->forWhom = $forWhom;
                return true;
            }
        }

        public function getForWhom() {
            return $this->forWhom;
        }

        public function showForWhom() {
            switch($this->forWhom) {
                case 'men':
                    return "Для мужчин";
                    break;
                case 'women':
                    return "Для женщин";
                    break;
                case '':
                    return "Для детей";
                    break;
                default:
                return "Для всех";
            }
        }

    }

?>
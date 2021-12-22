<?php

    trait getIncome{
        public function getTotalIncome(){
            return $this->getFinalPrice() - $this->getPurchasePrice();
        }
    }

    trait DemoEcho {
        public function echoSomeMessage(string $message = null)
        {
            $message = (is_null($message)) ? "Не передано никакого сообщения" : $message;
            echo $message;
        }
    }

?>
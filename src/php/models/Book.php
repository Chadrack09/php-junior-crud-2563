<?php

require_once('./Product.php');
require_once('./ProductTypes.php');

class Book extends ProductTypes {
    private $weight;

    public function getWeight() { 
        return $this->weight;
    }

    public function setWeight($weight) {
        $this->weight = $weight;
    }
}
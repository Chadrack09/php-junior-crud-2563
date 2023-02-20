<?php

require_once('./Product.php');
require_once('./ProductTypes.php');

class DVD extends ProductTypes {
    private $size;

    public function getSize() {
        return $this->size;
    }

    public function setSize($size) {
        $this->size = $size;
    }
}
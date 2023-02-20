<?php

require_once('./Product.php');
require_once('./ProductTypes.php');

class Furniture extends ProductTypes {
    private $height;
    private $width;
    private $length;

    public function getHeight() {
        return $this->height;
    }

    public function getWidth() {
        return $this->width;
    }

    public function getLength() {
        return $this->length;
    }

    public function setHeight($height) {
        $this->height = $height;
    }

    public function setWidth($width) {
        $this->width = $width;
    }

    public function setLength($length) {
        $this->length = $length;
    }
}
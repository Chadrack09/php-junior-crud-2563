<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/src/php/models/Product.php');

class Furniture extends Product
{
    private $height;
    private $width;
    private $length;

    public function __construct($db)
    {
        parent::__construct($db);
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function setHeight($height)
    {
        $this->height = $height;
    }

    public function setWidth($width)
    {
        $this->width = $width;
    }

    public function setLength($length)
    {
        $this->length = $length;
    }
}

<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/src/php/models/Product.php');

class DVD extends Product
{

    public function __construct($db)
    {
        parent::__construct($db);
    }

    private $size;

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }
}

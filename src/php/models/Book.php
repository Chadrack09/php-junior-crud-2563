<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/src/php/models/Product.php');

class Book extends Product
{
    private $weight;

    public function __construct($db)
    {
        parent::__construct($db);
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function setWeight($weight)
    {
        $this->weight = $weight;
    }
}

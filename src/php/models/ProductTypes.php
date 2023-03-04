<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . '/src/php/models/Product.php');

    class ProductTypes extends Product {
         
        public function __construct($db) {
            parent::__construct($db);
        }
    }

<?php

require_once('../api/ProductAPI.php');

$productAPI = new ProductAPI();
$productAPI->handleRequest();
?>
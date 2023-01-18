<?php

require_once('../models/Product.php');
require_once('../config/Database.php');

if(isset($_POST)) {

    $database = new Database();
    $db = $database->getConnection();

    $product = new Product($db);

    $sku = $_POST['sku'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $type_id = intval($_POST['types']);
    $productTypeData = array();

    if($type_id == 1) {
        $productTypeData['size'] = $_POST['size'];
    } else if($type_id == 2) {
        $productTypeData['weight'] = $_POST['weight'];
    } else if($type_id == 3) {
        $productTypeData['height'] = $_POST['height'];
        $productTypeData['width'] = $_POST['width'];
        $productTypeData['length'] = $_POST['length'];
    }

    try {
        $product->create($sku, $name, $price, $type_id, $productTypeData);
        echo json_encode(array("message" => "Product created successfully!", "data" => $_POST));
    } catch (PDOException $e) {
        echo json_encode(array("message" => "Error creating the product!", "error" => $e->getMessage(), "data" => $_POST));
    }
}
?>
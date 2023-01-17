<?php

include_once('../config/Database.php');
include_once('../models/Product.php');

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$stmt = $product->read();
$num = $stmt->rowCount();

if($num > 0) {
    $products_arr = array();
    $products_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $product_item = array(
            "sku" => $sku,
            "name" => $name,
            "price" => $price,
            "type" => $type
        );

        array_push($products_arr["records"], $product_item);
    }

    echo json_encode($products_arr);
} 
else {
    echo json_encode(array("message" => "No products found."));
}
?>
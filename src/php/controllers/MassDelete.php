<?php
    require_once('../models/Product.php');
    require_once('../config/Database.php');

    if(isset($_POST['skus'])){
        $database = new Database();
        $db = $database->getConnection();
    
        $product = new Product($db);
    
        $product->massDelete($_POST['skus']);
        $response = array("message" => "Products deleted.", "status" => "success", "skus" => $_POST['skus']);
    
        echo json_encode($response);
    }

?>
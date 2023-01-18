<?php
    require_once('../models/Product.php');
    require_once('../config/Database.php');

    if(isset($_POST['skus'])){
        $database = new Database();
        $db = $database->getConnection();
    
        $product = new Product($db);
    
        $product->massDelete($_POST['skus']);
        $response = array("message" => "Selected products have been deleted.", "data" => $_POST);
    
        echo json_encode($response);
    }

?>
<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/src/php/config/Database.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/src/php/models/Product.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/src/views/ProductList.php');

    $database = new Database();
    $db = $database->getConnection();

    $product = new Product($db);
    $products = $product->readAll();

    $productList = new ProductList($products);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/views/css/Index.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700&display=swap" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.3.min.js" 
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" 
        crossorigin="anonymous"></script>

    <title>Product List</title>
</head>
<body>
<main class="main-container">
    <form action="src/php/controllers/MassDelete.php" method="post" id="product_list_form">
        <div class="product-header">
            <h1>Product List</h1>
            <div class="btn-group">
                <a href="/add-product" class="add-btn">ADD</a>
                <input type="submit" value="MASS DELETE" class="ms-dlt-btn" id="mass-delete-btn">
            </div>
        </div>
        <div class="table-body">
        <?php
            $productList->render();
        ?>
        </div>
    </form>
<main>
<script src="src/views/js/index.js"></script>
</body> 
</html>
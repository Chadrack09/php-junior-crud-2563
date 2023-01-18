<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/src/php/config/Database.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/src/php/models/Product.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/src/php/models/ProductTypes.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" 
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" 
        crossorigin="anonymous"></script>
</head>
<body>
    <h1>Product List</h1>
    <div>
<form
    action="src/php/controllers/MassDelete.php"
    method="post"
    id="mass-delete-form"
>
<table id="product-table">
    <thead>
        <tr>
            <th>SKU</th>
            <th>Name</th>
            <th>Price</th>
            <th>Type</th>
            <th>Select</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $database = new Database();
        $db = $database->getConnection();
        $product = new Product($db);
        $stmt = $product->read();
        // $stmt = $product;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            echo "<tr>";
                echo "<td>{$sku}</td>";
                echo "<td>{$name}</td>";
                echo "<td>{$price}</td>";
                echo "<td>{$type}</td>";
                echo "<td><input type='checkbox' class='delete-checkbox' value='{$sku}'></td>";
            echo "</tr>";
        }
        ?>
    </tbody>
    </table>
    <!-- <button id="mass-delete-btn">Mass Delete</button>s -->
    <input type="submit" value="Mass Delete" id="mass-delete-btn">
</form>
<input type="button" value="Add Product" onclick="window.location.href='src/views/AddProduct.php'">

<div>
    <?php
        $productTypes = new ProductTypes($db);
        $types = $productTypes->read();
        // var_dump($types);
        // foreach($types as $type){
        //     echo "<div>{$type['type']}</div>";
        // }
        echo json_encode($types);
    ?>
</div>
<script src="src/php/config/js/index.js"></script>
</body>
</html>
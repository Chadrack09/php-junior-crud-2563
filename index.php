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
    <link rel="stylesheet" href="src/views/css/Index.css">

    <script src="https://code.jquery.com/jquery-3.6.3.min.js" 
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" 
        crossorigin="anonymous"></script>

    <title>Product List</title>
</head>
<body>
    <h1>Product List</h1>
    <div>
<form
    action="src/php/controllers/MassDelete.php"
    method="post"
    id="product_list_form"
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
        <tr>
            <td>
                <input type="submit" value="MASS DELETE" id="mass-delete-btn">
            </td>
            <td>
                <a href="/add-product">ADD</a>
            </td>
        </tr>
    </tbody>
    </table>
</form>
<script src="src/views/js/index.js"></script>
</body> 
</html>
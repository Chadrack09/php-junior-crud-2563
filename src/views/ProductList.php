<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/src/main/php/com/scandiweb/config/Database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
</head>
<body>
    <h1>Product List</h1>
    <div>

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
        $stmt = $products;
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
    <button id="mass-delete-btn">Mass Delete</button>
</body>
</html>
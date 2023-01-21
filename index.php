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

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700&display=swap" rel="stylesheet">

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
    <tbody class="table-body">
        <?php 
        $database = new Database();
        $db = $database->getConnection();
        $product = new Product($db);
        $productTypes = new ProductTypes($db);
        $types = $productTypes->read();
        $products = $product->readAll();

        foreach($products as $product) {
            echo "<tr class='product-row'>";
            echo "<td>" . $product['sku'] . "</td>";
            echo "<td>" . $product['name'] . "</td>";
            echo "<td>" . $product['price'] . "</td>";
            echo "<td>";
            if (!empty($product['attributes'])) {
                if($product['type']==='3'){
                    echo "dimensions: " . $product['attributes']['height'] . "x" . $product['attributes']['width'] . "x" . $product['attributes']['length'] . "<br>";
                }
                else{
                    foreach($product['attributes'] as $attribute_name => $attribute_value) {
                        echo $attribute_name . ": " . $attribute_value . "<br>";
                    }
                }
            }
            echo "</td>";
            echo "</tr>";
        }

        // while ($row = $products->fetch(PDO::FETCH_ASSOC)){
        //     extract($row);
        //     echo "<tr class='product-row'>";
        //         echo "<td>{$sku}</td>";
        //         echo "<td>{$name}</td>";
        //         echo "<td>{$price} $</td>";
        //         echo "<td>{$type}</td>";
        //         echo "<td><input type='checkbox' class='delete-checkbox' value='{$sku}'></td>";
        //     echo "</tr>";
        // }
        ?>
    </tbody>
</table>
    <input type="submit" value="MASS DELETE" id="mass-delete-btn">
    <a href="src/views/AddProduct.php">ADD</a>
    <h1 id="message">Types</h1>
    <?php echo json_encode($types) ?>
    <h1>Data</h1>
    <?php echo json_encode($product->readAll()) ?>
</form>
<script src="src/views/js/index.js"></script>
</body> 
</html>
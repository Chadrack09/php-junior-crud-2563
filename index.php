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
<main class="main-container">
    <form action="src/php/controllers/MassDelete.php" method="post" id="product_list_form">
        <div class="product-header">
            <h1>Product List</h1>
            <div class="btn-group">
                <a href="src/views/AddProduct.php" class="add-btn">ADD</a>
                <input type="submit" value="MASS DELETE" class="ms-dlt-btn" id="mass-delete-btn">
            </div>
        </div>
        <div class="table-body">
        <?php
            $database = new Database();
            $db = $database->getConnection();
            $product = new Product($db);
            $productTypes = new ProductTypes($db);
            $types = $productTypes->read();
            $products = $product->readAll();
            foreach($products as $product) {
                echo "<div class='table-body-item'>";
                echo "<p>" . $product['sku'] . "</p>";
                echo "<p>" . $product['name'] . "</p>";
                echo "<p>" . $product['price'] . " $</p>";
                if (!empty($product['attributes'])) {
                    if($product['type']==='3'){
                        echo "<p>dimensions: " . $product['attributes']['height'] . "x" . $product['attributes']['width'] . "x" . $product['attributes']['length'] . "</p>";
                        echo "<input type='checkbox' class='delete-checkbox' value='{$product['sku']}'>";
                    }
                    else{
                        foreach($product['attributes'] as $attribute_name => $attribute_value) {
                            echo "<p>" . $attribute_name . ": ";
                            if ($attribute_name === 'size') {
                                echo $attribute_value . "MB";
                            } else if($attribute_name === 'weight') {
                                echo $attribute_value . "KG";
                            }
                            echo "</p>";
                            echo "<input type='checkbox' class='delete-checkbox' value='{$product['sku']}'>";
                        }
                    }
                }
                echo "</div>";
            }
        ?>
        </div>
    </form>
    <div>
        <?php
            // $product = new Product($db);
            // echo json_encode($product->fetchAll());
        ?>
    </div>
<main>
<script src="src/views/js/index.js"></script>
</body> 
</html>
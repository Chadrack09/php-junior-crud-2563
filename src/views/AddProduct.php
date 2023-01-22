<?php
    require_once('../php/config/Database.php');
    require_once('../php/models/ProductTypes.php');
    $database = new Database();
    $db = $database->getConnection();
    $productTypes = new ProductTypes($db);
    $types = $productTypes->read();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/AddProduct.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700&display=swap" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.3.min.js" 
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" 
        crossorigin="anonymous"></script>

    <title>Add Product</title>
</head>
<body>
    <main class="main-container">
        <form action="../php/controllers/AddProductController.php" method="POST" id="product_form">
        <div class="product-header">
            <h1>Product Add</h1>
            <div class="btn-group">
                <input type="submit" value="Save" class="save-btn">
                <a href="/" class="cancel-btn">Cancel</a>
            </div>
        </div>
        <table>
            <tr>
                <td>SKU</td>
                <td><input type="text" name="sku" id="sku" placeholder="#sku" required></td>
            </tr>
            <tr>
                <td>Name</td>
                <td><input type="text" name="name" id="name" placeholder="#name" required></td>
            </tr>
            <tr>
                <td>Price</td>
                <td><input type="text" name="price" id="price" placeholder="#price" required></td>
            </tr>
            <tr>
                <td style="padding-right: 4rem;">Type</td>
                <td>
                    <select name="types" id="productType">
                        <option value="">Select Type</option>
                        <?php
                            foreach($types as $type){
                                echo "<option value='{$type['id']}'>{$type['type']}</option>";
                            }
                        ?>
                    </select>
                </td>
            </tr>
            <?php
                foreach($types as $type){
                    if ($type['type'] == 'DVD') {
                        echo '<tr class="type type_' . $type['id'] . '" style="display:none">
                                    <td>' . ucfirst(reset($type['attribute_names'])) . ' (' . $type['unit'] . ')</td>
                                    <td><input type="text" name="'. $type["attribute_names"][0] .'" id="'. $type["attribute_names"][0] .'"
                                            placeholder="#'. $type["attribute_names"][0] .'"></td>
                                </tr>';
                    } 
                    else if ($type['type'] == 'Book') {
                        echo '<tr class="type type_' . $type['id'] . '" style="display:none">
                                    <td>' . ucfirst(reset($type['attribute_names'])) . ' (' . $type['unit'] . ')</td>
                                    <td><input type="text" name="'. $type["attribute_names"][0] .'" id="'. $type["attribute_names"][0] .'" 
                                            placeholder="#'. $type["attribute_names"][0] .'"></td>
                                </tr>';
                    }
                    else if ($type['type'] == 'Furniture') {
                        foreach($type['attribute_names'] as $attribute_name) {
                            echo '<tr class="type type_' . $type['id'] . '" style="display:none">
                                    <td>' . ucfirst($attribute_name) . ' (' . $type['unit'] . ')</td>
                                    <td><input type="text" name="' . $attribute_name . '" id="'. $attribute_name .'" 
                                            placeholder="#'. $attribute_name .'"></td>
                                </tr>';
                        }
                    }
                }
            ?>
        </table>
        </form>
    </main>
    <script src="js/addProduct.js"></script>
    <script src="js/validation.js"></script>
</body>
</html>
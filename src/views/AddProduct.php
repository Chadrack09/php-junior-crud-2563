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

    <script src="https://code.jquery.com/jquery-3.6.3.min.js" 
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" 
        crossorigin="anonymous"></script>

    <title>Add Product</title>
</head>
<body>
    <h1>Add Product Page</h1>
    <form 
        action="../php/controllers/AddProductController.php" 
        method="POST" id="product_form">
    <table>
        <tr>
            <td>SKU</td>
            <td><input type="text" name="sku" id="sku" required></td>
        </tr>
        <tr>
            <td>Name</td>
            <td><input type="text" name="name" id="name" required></td>
        </tr>
        <tr>
            <td>Price</td>
            <td><input type="text" name="price" id="price" required></td>
        </tr>
        <tr>
            <td>Type</td>
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
        <tr>
            <td><input type="submit" value="Save"></td>
            <td><a href="/">Cancel</a></td>
        </tr>
    </table>
    </form>
    <script src="../php/config/js/addProduct.js"></script>
    <script src="../php/config/js/validation.js"></script>
</body>
</html>
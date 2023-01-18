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

    <title>Document</title>
</head>
<body>
    <h1>Add Product Page</h1>
    <form action="../php/controllers/AddProductController.php" method="post" id="add-product-form">
    <table>
        <tr>
            <td>SKU</td>
            <td><input type="text" name="sku" required></td>
        </tr>
        <tr>
            <td>Name</td>
            <td><input type="text" name="name" required></td>
        </tr>
        <tr>
            <td>Price</td>
            <td><input type="text" name="price" required></td>
        </tr>
        <tr>
            <td>Type</td>
            <td>
                <select name="types" id="select_types">
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
                                <td><input type="text" name="size"></td>
                            </tr>';
                } 
                else if ($type['type'] == 'Book') {
                    echo '<tr class="type type_' . $type['id'] . '" style="display:none">
                                <td>' . ucfirst(reset($type['attribute_names'])) . ' (' . $type['unit'] . ')</td>
                                <td><input type="text" name="weight" ></td>
                            </tr>';
                }
                else if ($type['type'] == 'Furniture') {
                    foreach($type['attribute_names'] as $attribute_name) {
                        echo '<tr class="type type_' . $type['id'] . '" style="display:none">
                                  <td>' . ucfirst($attribute_name) . ' (' . $type['unit'] . ')</td>
                                  <td><input type="text" name="' . $attribute_name . '" ></td>
                              </tr>';
                    }
                }
            }
        ?>
        <tr>
            <td></td>
            <td><input type="submit" value="Add Product"></td>
        </tr>
    </table>
    </form>
    <?php
        echo json_encode($types);
    ?>
    <script src="../php/config/js/addProduct.js"></script>
    <script src="../php/config/js/validation.js"></script>
</body>
</html>
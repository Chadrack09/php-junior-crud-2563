<?php
define('BASE_URL', 'https://' . $_SERVER['HTTP_HOST'] . '/');
require_once($_SERVER['DOCUMENT_ROOT'] . '/src/php/config/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/src/php/models/ProductTypes.php');
require_once('./AttributeList.php');

$database = new Database();
$db = $database->getConnection();
$productTypes = new ProductTypes($db);
$types = $productTypes->readTypes();

$attributeList = new AttributeList($types);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>src/views/css/AddProduct.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700&display=swap" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>

    <title>Add Product</title>
</head>

<body>
    <main class="main-container">
        <form action="<?php echo BASE_URL; ?>src/php/controllers/ActionController.php" method="POST" id="product_form">
            <div class="product-header">
                <h1>Product Add</h1>
                <div class="btn-group">
                    <input type="submit" value="Save" class="save-btn">
                    <a href="/" class="cancel-btn">Cancel</a>
                </div>
            </div>
            <table>
                <tr>
                    <td style="width: 6rem">SKU</td>
                    <td><input type="text" name="sku" id="sku" placeholder="#sku" required></td>
                </tr>
                <tr>
                    <td style="width: 6rem">Name</td>
                    <td><input type="text" name="name" id="name" placeholder="#name" required></td>
                </tr>
                <tr>
                    <td style="width: 6rem">Price</td>
                    <td><input type="text" name="price" id="price" placeholder="#price" required></td>
                </tr>
                <tr>
                    <td style="width: 6rem">Type</td>
                    <td>
                        <select name="types" id="productType">
                            <option value="">Select Type</option>
                            <?php
                            foreach ($types as $type) {
                                echo "<option value='{$type['id']}'>{$type['type']}</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <?php
                echo $attributeList->render();
                ?>
            </table>
        </form>
    </main>
    <script src="<?php echo BASE_URL; ?>src/views/js/addProduct.js"></script>
    <script src="<?php echo BASE_URL; ?>src/views/js/validation.js"></script>
</body>

</html>
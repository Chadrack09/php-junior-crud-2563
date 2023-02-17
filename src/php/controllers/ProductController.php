<?php
require_once('../models/Product.php');
require_once('../config/Database.php');

class ProductController {
  private $db;
  private $product;

  public function __construct() {
    $database = new Database();
    $this->db = $database->getConnection();
    $this->product = new Product($this->db);
  }

  public function massDelete($skus) {
    $this->product->massDelete($skus);
    $response = array("message" => "Selected products have been deleted.", "data" => $skus);
    echo json_encode($response);
  }

  public function createProduct($postData) {
    $sku = $postData['sku'];
    $name = $postData['name'];
    $price = $postData['price'];
    $type_id = intval($postData['types']);
    $productTypeData = array();

    if($type_id == 1) {
      $productTypeData['size'] = $postData['size'];
    } else if($type_id == 2) {
      $productTypeData['weight'] = $postData['weight'];
    } else if($type_id == 3) {
      $productTypeData['height'] = $postData['height'];
      $productTypeData['width'] = $postData['width'];
      $productTypeData['length'] = $postData['length'];
    }

    try {
      $this->product->create($sku, $name, $price, $type_id, $productTypeData);
      echo json_encode(array("message" => "Product created successfully!", "data" => $postData));
    } catch (PDOException $e) {
      echo json_encode(array("message" => "Error creating the product!", "error" => $e->getMessage(), "data" => $postData));
    }
  }
}
?>

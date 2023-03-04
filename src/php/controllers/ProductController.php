<?php
require_once('../models/ProductTypes.php');
require_once('../config/Database.php');
require_once('../models/DVD.php');
require_once('../models/Book.php');
require_once('../models/Furniture.php');

class ProductController
{
  private $db;
  private $product;
  private $dvd;
  private $book;
  private $furniture;

  public function __construct()
  {
    $database = new Database();
    $this->db = $database->getConnection();
    $this->product = new ProductTypes($this->db);
    $this->dvd = new DVD($this->db);
    $this->book = new Book($this->db);
    $this->furniture = new Furniture($this->db);
  }

  public function massDelete($skus)
  {
    $this->product->massDelete($skus);
    $response = array("message" => "Selected products have been deleted.", "data" => $skus);
    echo json_encode($response);
  }


  public function createProduct($postData)
  {
    $sku = $postData['sku'];
    $name = $postData['name'];
    $price = $postData['price'];
    $type_id = intval($postData['types']);
    $productTypeData = array();

    if ($type_id == 1) {
      if (!empty($postData['size'])) {
        $productTypeData['size'] = $postData['size'];
      } else {
        echo json_encode(array("message" => "Error creating the product! Size is required.", "data" => $postData, "status" => "error"));
        return;
      }
    } else if ($type_id == 2) {
      if (!empty($postData['weight'])) {
        $productTypeData['weight'] = $postData['weight'];
      } else {
        echo json_encode(array("message" => "Error creating the product! Weight is required.", "data" => $postData, "status" => "error"));
        return;
      }
    } else if ($type_id == 3) {
      if (!empty($postData['height']) && !empty($postData['width']) && !empty($postData['length'])) {
        $productTypeData['height'] = $postData['height'];
        $productTypeData['width'] = $postData['width'];
        $productTypeData['length'] = $postData['length'];
      } else {
        echo json_encode(array("message" => "Error creating the product! Height, width, and length are all required.", "data" => $postData, "status" => "error"));
        return;
      }
    }

    try {
      if ($type_id == 1) {
        $this->dvd->create($sku, $name, $price, $type_id, $productTypeData);
        echo json_encode(array("message" => "Product created successfully!", "data" => $postData, "status" => "success"));
      } else if ($type_id == 2) {
        $this->book->create($sku, $name, $price, $type_id, $productTypeData);
        echo json_encode(array("message" => "Product created successfully!", "data" => $postData, "status" => "success"));
      } else if ($type_id == 3) {
        $this->furniture->create($sku, $name, $price, $type_id, $productTypeData);
        echo json_encode(array("message" => "Product created successfully!", "data" => $postData, "status" => "success"));
      }
    } catch (PDOException $e) {
      echo json_encode(array("message" => "Error creating the product!", "error" => $e->getMessage(), "data" => $postData, "status" => "error"));
    }
  }
}

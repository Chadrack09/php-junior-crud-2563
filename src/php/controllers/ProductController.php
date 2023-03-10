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
    $this->product->setSku($postData['sku']);
    $this->product->setName($postData['name']);
    $this->product->setPrice($postData['price']);
    $this->product->setType(intval($postData['types']));

    if ($this->product->getType() == 1) {
      if (!empty($postData['size'])) {

        $this->product->addProductTypeData('size', $postData['size']);
      } else {
        echo json_encode(array("message" => "Error creating the product! Size is required.", "data" => $postData, "status" => "error"));
        return;
      }
    } else if ($this->product->getType() == 2) {
      if (!empty($postData['weight'])) {
        $this->product->addProductTypeData('weight', $postData['weight']);
      } else {
        echo json_encode(array("message" => "Error creating the product! Weight is required.", "data" => $postData, "status" => "error"));
        return;
      }
    } else if ($this->product->getType() == 3) {
      if (!empty($postData['height']) && !empty($postData['width']) && !empty($postData['length'])) {

        $this->product->addProductTypeData('height', $postData['height']);
        $this->product->addProductTypeData('width', $postData['width']);
        $this->product->addProductTypeData('length', $postData['length']);
      } else {
        echo json_encode(array("message" => "Error creating the product! Height, width, and length are all required.", "data" => $postData, "status" => "error"));
        return;
      }
    }

    try {
      if ($this->product->getType() == 1) {

        $this->dvd->create(
          $this->product->getSku(),
          $this->product->getName(),
          $this->product->getPrice(),
          $this->product->getType(),
          $this->product->getProductTypeData()
        );
        echo json_encode(array(
          "message" => "Product created successfully!",
          "data" => $postData, "status" => "success"
        ));
      } else if ($this->product->getType() == 2) {

        $this->book->create(
          $this->product->getSku(),
          $this->product->getName(),
          $this->product->getPrice(),
          $this->product->getType(),
          $this->product->getProductTypeData()
        );
        echo json_encode(array(
          "message" => "Product created successfully!",
          "data" => $postData, "status" => "success"
        ));
      } else if ($this->product->getType() == 3) {

        $this->furniture->create(
          $this->product->getSku(),
          $this->product->getName(),
          $this->product->getPrice(),
          $this->product->getType(),
          $this->product->getProductTypeData()
        );
        echo json_encode(array(
          "message" => "Product created successfully!",
          "data" => $postData, "status" => "success"
        ));
      }
    } catch (PDOException $e) {
      echo json_encode(array("message" => "Error creating the product!", "error" => $e->getMessage(), "data" => $postData, "status" => "error"));
    }
  }
}

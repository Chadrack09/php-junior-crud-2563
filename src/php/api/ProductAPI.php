<?php

require_once('../controllers/ProductController.php');

class ProductAPI {
  private $productController;

  public function __construct() {
    $this->productController = new ProductController();
  }

  public function handleRequest() {
    $method = $_SERVER['REQUEST_METHOD'];

    // Route the request based on the HTTP method and path
    switch ($method) {
      case 'GET':
        if (isset($_GET['sku'])) {
          // Retrieve a single product
          $this->productController->getProduct($_GET['sku']);
        } else {
          // Retrieve a list of products
          $this->productController->getProducts();
        }
        break;

      case 'POST':
        if(isset($_POST['skus'])){
            $this->productController->massDelete($_POST['skus']);
        }
        else if(isset($_POST)) {
            $this->productController->createProduct($_POST);
        }
        break;

      case 'PUT':
        // Update an existing product
        parse_str(file_get_contents('php://input'), $putData);
        $this->productController->updateProduct($putData);
        break;

      case 'DELETE':
        // Delete one or more products
        parse_str(file_get_contents('php://input'), $deleteData);
        $this->productController->massDelete($deleteData['skus']);
        break;

      default:
        header("HTTP/1.1 405 Method Not Allowed");
        header("Allow: GET, POST, PUT, DELETE");
        break;
    }
  }
}
?>

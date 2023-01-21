<?php

    /**
     * Product class, performs CRUD operations on the products table. 
     * Also performs CRUD operations on the product type tables (dvd, book, furniture).
     */

    class Product {
        private $conn;
        private $table_name = "products";
        
        public function __construct($db) {
            $this->conn = $db;
        }

        
        /**
         * Create a new product in the database
         * @param string $sku
         * @param string $name
         * @param float $price
         * @param string $type
         * @param array $productTypeData
         * @return bool
         */

        public function create($sku, $name, $price, $type_id, $productTypeData) {
            // Fetch product type string based on id
            $query = "SELECT type FROM product_types WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $type_id);
            $stmt->execute();
            $type = $stmt->fetch(PDO::FETCH_ASSOC);
            $type = $type['type'];
            
            // Insert product data into products table
            $query = "INSERT INTO products (sku, name, price, type) VALUES (:sku, :name, :price, :type)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':sku', $sku);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':type', $type_id); 
            $stmt->execute();
            $product_id = $this->conn->lastInsertId();
        
            // Insert product type-specific data into appropriate table
            if($type == 'DVD') {
                $query = "INSERT INTO dvd (product_id, size) VALUES (:product_id, :size)";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':product_id', $product_id);
                $stmt->bindParam(':size', $productTypeData['size']);
                $stmt->execute();
            } else if($type == 'Book') {
                $query = "INSERT INTO book (product_id, weight) VALUES (:product_id, :weight)";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':product_id', $product_id);
                $stmt->bindParam(':weight', $productTypeData['weight']);
                $stmt->execute();
            } else if($type == 'Furniture') {
                $query = "INSERT INTO furniture (product_id, height, width, length) VALUES (:product_id, :height, :width, :length)";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':product_id', $product_id);
                $stmt->bindParam(':height', $productTypeData['height']);
                $stmt->bindParam(':width', $productTypeData['width']);
                $stmt->bindParam(':length', $productTypeData['length']);
                $stmt->execute();
            }
            return true;
        }
                
                
        

        // public function create($sku, $name, $price, $type, $productTypeData) {
        //     $query = "INSERT INTO products (sku, name, price, type) VALUES (:sku, :name, :price, :type)";
        //     $stmt = $this->conn->prepare($query);
        //     $stmt->bindParam(':sku', $sku);
        //     $stmt->bindParam(':name', $name);
        //     $stmt->bindParam(':price', $price);
        //     $stmt->bindParam(':type', $type);
        //     $stmt->execute();
        //     $product_id = $this->conn->lastInsertId();

        //     if($type == 'DVD') {
        //         $query = "INSERT INTO dvd (product_id, size) VALUES (:product_id, :size)";
        //         $stmt = $this->conn->prepare($query);
        //         $stmt->bindParam(':product_id', $product_id);
        //         $stmt->bindParam(':size', $productTypeData['size']);
        //         $stmt->execute();
        //     } else if($type == 'Book') {
        //         $query = "INSERT INTO book (product_id, weight) VALUES (:product_id, :weight)";
        //         $stmt = $this->conn->prepare($query);
        //         $stmt->bindParam(':product_id', $product_id);
        //         $stmt->bindParam(':weight', $productTypeData['weight']);
        //         $stmt->execute();
        //     } else if($type == 'Furniture') {
        //         $query = "INSERT INTO furniture (product_id, height, width, length) VALUES (:product_id, :height, :width, :length)";
        //         $stmt = $this->conn->prepare($query);
        //         $stmt->bindParam(':product_id', $product_id);
        //         $stmt->bindParam(':height', $productTypeData['height']);
        //         $stmt->bindParam(':width', $productTypeData['width']);
        //         $stmt->bindParam(':length', $productTypeData['length']);
        //         $stmt->execute();
        //     }

        //     return true;
        // }


        /**
         * Read all products from the database
         * @return PDOStatement
         */
        public function read() {
            $query = "SELECT sku, name, price, type FROM " . $this->table_name . " ORDER BY id";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
    
            return $stmt;
        }

        public function readAll() {
            $query = "SELECT p.id, p.sku, p.name, p.price, p.type,
                      f.height, f.width, f.length,
                      b.weight,
                      d.size
                      FROM products p
                      LEFT JOIN furniture f ON p.id = f.product_id
                      LEFT JOIN book b ON p.id = b.product_id
                      LEFT JOIN dvd d ON p.id = d.product_id";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $products = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $product_item = array(
                    "id" => $id,
                    "sku" => $sku,
                    "name" => $name,
                    "price" => $price,
                    "type" => $type,
                    "attributes" => array()
                );
                if (!empty($height)) {
                    $product_item["attributes"]["height"] = $height;
                }
                if (!empty($width)) {
                    $product_item["attributes"]["width"] = $width;
                }
                if (!empty($length)) {
                    $product_item["attributes"]["length"] = $length;
                }
                if (!empty($weight)) {
                    $product_item["attributes"]["weight"] = $weight;
                }
                if (!empty($size)) {
                    $product_item["attributes"]["size"] = $size;
                }
                array_push($products, $product_item);
            }
            return $products;
        }

        // public function fetchAll() {
        //     $query = "SELECT sku, name, price, type FROM " . $this->table_name . " ORDER BY id";
        //     $stmt = $this->conn->prepare($query);
        //     $stmt->execute();

        //     $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        //     return $result;
        // }
        
        
        /**
         * Update a product in the database
         * @param string $sku
         * @param string $name
         * @param float $price
         * @param string $type
         * @param array $productTypeData
         * @return bool
         */
        public function update($sku, $name, $price, $type, $productTypeData) {
            $query = "UPDATE products SET name = :name, price = :price, type = :type WHERE sku = :sku";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':sku', $sku);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':type', $type);
            $stmt->execute();

            if($type == 'DVD') {
                $query = "UPDATE dvd SET size = :size WHERE product_id = (SELECT id FROM products WHERE sku = :sku)";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':size', $productTypeData['size']);
                $stmt->bindParam(':sku', $sku);
                $stmt->execute();
            } else if($type == 'Book') {
                $query = "UPDATE book SET weight = :weight WHERE product_id = (SELECT id FROM products WHERE sku = :sku)";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':weight', $productTypeData['weight']);
                $stmt->bindParam(':sku', $sku);
                $stmt->execute();
            } else if($type == 'Furniture') {
                $query = "UPDATE furniture SET height = :height, width = :width, length = :length WHERE product_id = (SELECT id FROM products WHERE sku = :sku)";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':height', $productTypeData['height']);
                $stmt->bindParam(':width', $productTypeData['width']);
                $stmt->bindParam(':length', $productTypeData['length']);
                $stmt->bindParam(':sku', $sku);
                $stmt->execute();
            }

            return true;
        }

        /**
         * Delete a product from the database
         * @param string $sku
         * @return bool
         */
        public function delete($sku) {
            $query = "DELETE FROM " . $this->table_name . " WHERE sku = :sku";
            $stmt = $this->conn->prepare($query);
    
            $stmt->bindParam(':sku', $sku);
            $stmt->execute();
    
            return $stmt->rowCount() > 0;
        }

        /**
         * Delete multiple products from the database
         * @param array $skus
         * @return bool
         */
        public function massDelete($skus) {
            $placeholders = implode(',', array_fill(0, count($skus), '?'));
            $query = "DELETE FROM " . $this->table_name . " WHERE sku IN ($placeholders)";
            $stmt = $this->conn->prepare($query);
            $stmt->execute($skus);
            if($stmt->rowCount() > 0) {
                $skus_string = "";
                foreach($skus as $sku) {
                    $skus_string .= $sku . ",";
                }
                $skus_string = rtrim($skus_string, ",");
                return "The products with skus: " . $skus_string . " have been deleted";
            }else{
                return "Error deleting products";
            }
        }
    }
?>
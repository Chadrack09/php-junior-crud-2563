<?php

    class ProductTypes {
        private $conn;
        private $table_name = "product_types";
         
        public function __construct($db) {
            $this->conn = $db;
        }

        // public function read() {
        //     $query = "SELECT product_types.id, product_types.type, 
        //                      (SELECT GROUP_CONCAT(name) FROM product_attributes WHERE id = product_types.attribute_id) as attribute_names
        //               FROM product_types";
        //     $stmt = $this->conn->prepare($query);
        //     $stmt->execute();
        //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
        // }

        // public function read() {
        //     $query = "SELECT product_types.id, product_types.type, product_attributes.name as attribute_name, product_attributes.unit as attribute_unit
        //               FROM product_types
        //               JOIN product_attributes ON product_types.attribute_id = product_attributes.id";
        //     $stmt = $this->conn->prepare($query);
        //     $stmt->execute();
        //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
        // }

        public function read() {
            $query = "SELECT * FROM product_types";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
    
            // return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

?>
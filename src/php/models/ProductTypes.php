<?php

    class ProductTypes {
        private $conn;
        private $table_name = "product_types";
         
        public function __construct($db) {
            $this->conn = $db;
        }

        public function read() {
            $query = "SELECT pt.id, pt.type, GROUP_CONCAT(pa.name) as attribute_names, pa.unit
                      FROM product_types pt
                      JOIN product_type_attributes pta ON pt.id = pta.product_type_id
                      JOIN product_attributes pa ON pta.attribute_id = pa.id
                      GROUP BY pt.id";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // public function read() {
        //     $query = "SELECT * FROM product_types";
        //     $stmt = $this->conn->prepare($query);
        //     $stmt->execute();
    
        //     // return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
        // }
    }

?>
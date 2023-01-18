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
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($result as &$product_type) {
                $product_type['attribute_names'] = explode(',', $product_type['attribute_names']);
            }

            return $result;
        }
    }

?>
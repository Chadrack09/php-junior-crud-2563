<?php

/**
 * Product class, performs CRUD operations on the products table. 
 * Also performs CRUD operations on the product type tables (dvd, book, furniture).
 */

abstract class Product
{
    private $conn;
    private $sku;
    private $name;
    private $price;
    private $type;
    private $type_id;
    private $productTypeData;
    private $table_name = "products";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * Getters and Setters
     */
    public function getSku()
    {
        return $this->sku;
    }

    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getType()
    {
        return $this->type_id;
    }

    public function setType($type_id)
    {
        $this->type_id = $type_id;
    }

    public function addProductTypeData($key, $value)
    {
        $this->productTypeData[$key] = $value;
    }

    public function getProductTypeData()
    {
        return $this->productTypeData;
    }

    public function setProductTypeData($productTypeData)
    {
        $this->productTypeData = $productTypeData;
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

    public function create($sku, $name, $price, $type_id, $productTypeData)
    {
        $this->type = $this->getProductType($type_id);

        // Insert product data into products table
        $productData = ['sku' => $sku, 'name' => $name, 'price' => $price, 'type' => $type_id];
        $productId = $this->insert('products', $productData);

        // Insert product type-specific data into appropriate table
        $typeTable = $this->getTypeTable($this->type);
        $productTypeData['product_id'] = $productId;
        $this->insert($typeTable, $productTypeData);

        return true;
    }

    protected function getProductType($type_id)
    {
        $query = "SELECT type FROM product_types WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $type_id);
        $stmt->execute();
        $type = $stmt->fetch(PDO::FETCH_ASSOC);
        return $type['type'];
    }

    protected function getTypeTable($type)
    {
        $tableMap = [
            'DVD' => 'dvd',
            'Book' => 'book',
            'Furniture' => 'furniture'
        ];
        return $tableMap[$type];
    }

    protected function insert($table, $data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $query = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $this->conn->prepare($query);
        foreach ($data as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    /**
     * Read all products from the database
     * @return PDOStatement
     */
    public function read()
    {
        $query = "SELECT sku, name, price, type FROM " . $this->table_name . " ORDER BY id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    /**
     * Read types of products from the database
     */

    public function readTypes()
    {
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

    /**
     * Read all products from the database
     * @return array
     */
    public function readAll()
    {
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

    /**
     * Read all products from the database and return as an array
     */
    public function fetchAll()
    {
        $query = "SELECT p.id, p.sku, p.name, p.price, p.type, dvd.size, book.weight, furniture.height, furniture.width, furniture.length FROM products p 
                      LEFT JOIN dvd ON p.id = dvd.product_id 
                      LEFT JOIN book ON p.id = book.product_id 
                      LEFT JOIN furniture ON p.id = furniture.product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $products = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $product = new stdClass();
            $product->id = $row['id'];
            $product->sku = $row['sku'];
            $product->name = $row['name'];
            $product->price = $row['price'];
            $product->type = $row['type'];

            if ($product->type == 'DVD') {
                $product->size = $row['size'];
            } else if ($product->type == 'Book') {
                $product->weight = $row['weight'];
            } else if ($product->type == 'Furniture') {
                $product->dimensions = 'H:' . $row['height'] . ', W:' . $row['width'] . ', L:' . $row['length'];
            }

            $products[] = $product;
        }

        return $products;
    }

    /**
     * Update a product in the database
     * @param string $sku
     * @param string $name
     * @param float $price
     * @param string $type
     * @param array $productTypeData
     * @return bool
     */
    public function update($sku, $name, $price, $type, $productTypeData)
    {
        $query = "UPDATE products SET name = :name, price = :price, type = :type WHERE sku = :sku";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':sku', $sku);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':type', $type);
        $stmt->execute();

        if ($type == 'DVD') {
            $query = "UPDATE dvd SET size = :size WHERE product_id = (SELECT id FROM products WHERE sku = :sku)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':size', $productTypeData['size']);
            $stmt->bindParam(':sku', $sku);
            $stmt->execute();
        } else if ($type == 'Book') {
            $query = "UPDATE book SET weight = :weight WHERE product_id = (SELECT id FROM products WHERE sku = :sku)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':weight', $productTypeData['weight']);
            $stmt->bindParam(':sku', $sku);
            $stmt->execute();
        } else if ($type == 'Furniture') {
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
    public function delete($sku)
    {
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
    public function massDelete($skus)
    {
        $placeholders = implode(',', array_fill(0, count($skus), '?'));
        $query = "DELETE FROM " . $this->table_name . " WHERE sku IN ($placeholders)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute($skus);
        if ($stmt->rowCount() > 0) {
            $skus_string = "";
            foreach ($skus as $sku) {
                $skus_string .= $sku . ",";
            }
            $skus_string = rtrim($skus_string, ",");
            return "The products with skus: " . $skus_string . " have been deleted";
        } else {
            return "Error deleting products";
        }
    }
}

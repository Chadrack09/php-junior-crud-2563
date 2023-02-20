<?php
class ProductList {
    private $products;

    function __construct($products) {
        $this->products = $products;
    }

    public function render() {
        $products = $this->products;
        foreach($products as $product) {
            echo "<div class='table-body-item'>";
            echo "<p>" . $product['sku'] . "</p>";
            echo "<p>" . $product['name'] . "</p>";
            echo "<p>" . $product['price'] . " $</p>";
            if (!empty($product['attributes'])) {
                if($product['type']==='3'){
                    echo "<p>dimensions: " . $product['attributes']['height'] . "x" . $product['attributes']['width'] . "x" . $product['attributes']['length'] . "</p>";
                    echo "<input type='checkbox' class='delete-checkbox' value='{$product['sku']}'>";
                }
                else{
                    foreach($product['attributes'] as $attribute_name => $attribute_value) {
                        echo "<p>" . $attribute_name . ": ";
                        if ($attribute_name === 'size') {
                            echo $attribute_value . "MB";
                        } else if($attribute_name === 'weight') {
                            echo $attribute_value . "KG";
                        }
                        echo "</p>";
                        echo "<input type='checkbox' class='delete-checkbox' value='{$product['sku']}'>";
                    }
                }
            }
            echo "</div>";
        }
    }
}

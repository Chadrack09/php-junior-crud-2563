<?php
class AttributeList {
    private $types;

    public function __construct($types) {
        $this->types = $types;
    } 

    public function render() {
        echo '<table>';
        foreach ($this->types as $type) {
            if ($type['type'] == 'DVD' || $type['type'] == 'Book') {
                $this->renderSimpleRow($type);
            } else if ($type['type'] == 'Furniture') {
                $this->renderFurnitureRow($type);
            }
        }
        echo '</table>';
    }

    private function renderSimpleRow($type) {
        echo '<tr class="type type_' . $type['id'] . '" style="display:none">';
            echo '<td style="width: 6rem">' . ucfirst(reset($type['attribute_names'])) . ' (' . $type['unit'] . ')</td>';
            echo '<td><input type="text" name="'. $type["attribute_names"][0] .'" id="'. $type["attribute_names"][0] .'" placeholder="#'. $type["attribute_names"][0] .'" ></td>';
        echo '</tr>';
    }

    private function renderFurnitureRow($type) {
        foreach($type['attribute_names'] as $attribute_name) {
            echo '<tr class="type type_' . $type['id'] . '" style="display:none">';
                echo '<td style="width: 6rem">' . ucfirst($attribute_name) . ' (' . $type['unit'] . ')</td>';
                echo '<td><input type="text" name="' . $attribute_name . '" id="'. $attribute_name .'" placeholder="#'. $attribute_name .'" ></td>';
            echo '</tr>';
        }
    }
}

?>
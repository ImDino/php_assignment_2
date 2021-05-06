<?php

class ProductList {
    private static $allProducts = array();

    public static function main($data) {
        self::$allProducts = $data;
        
        $category = $_GET['category'] ?? null;
        $limit = $_GET['limit'] ?? null;
        $response = array();
        $errors = array();
        
        try {
            $response = $category ? self::get_category($category) : self::$allProducts;
        } catch (Exception $e) {
            array_push($errors, array("Category" => $e->getMessage()));
        }

        if (!is_null($limit)) {
            try {
                $response = self::select_random_items($limit, $response);
            } catch (Exception $e) {
                array_push($errors, array("Limit" => $e->getMessage()));
            }
        }

        self::echo_json($errors ? $errors : $response);
    }
    
    private static function get_category($category) {
        $data = array();

        foreach (self::$allProducts as $product) {
            if ($product['category'] == $category) {
                array_push($data, $product);
            }
        }
        if (!$data)
            throw new Exception("Category not found");
        return $data;
    }
    
    private static function select_random_items($limit, $items) {
        if ($limit <= 0 || $limit > count(self::$allProducts) || !is_numeric($limit))
            throw new Exception("Limit must be a number between 1 and 20");
        else if (!$items)
            return null;
        
        $returnIndexes = self::unique_random_numbers_within_range(0, count($items)-1, $limit);
        $data = array();

        foreach ($returnIndexes as $index) {
            array_push($data, $items[$index]);
        }
        return $data;
    }

    private static function unique_random_numbers_within_range($min, $max, $quantity) {
        $numbers = range($min, $max);
        shuffle($numbers);
        return array_slice($numbers, 0, $quantity);
    }

    private static function echo_json($input) {
        echo json_encode($input, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}

?>
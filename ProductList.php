<?php

class ProductList {
    private static $allProducts = [];

    public static function main() {
        $data = file_get_contents("products.json");
        self::$allProducts = json_decode($data, true);
        
        $queryCat = $_GET['category'] ?? null;
        $queryShow = $_GET['show'] ?? null;
        $error = [];
        
        try {
            $foundItems = $queryCat ? self::getCategory($queryCat) : self::$allProducts;
        } catch (Exception $e) {
            array_push($error, array("Category" => $e->getMessage()));
        }
        
        try {
            $response = !is_null($queryShow) ? self::selectItems($queryShow, $foundItems) : $foundItems;
        } catch (Exception $e) {
            array_push($error, array("Show" => $e->getMessage()));
        }

        if ($error) {
            echo json_encode($error, JSON_UNESCAPED_UNICODE);
        } else echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }
    
    private static function getCategory($category) {
        $data = [];

        foreach (self::$allProducts as $key => $product) {
            if ($product['category'] == $category) {
                array_push($data, $product);
            }
        }
        if (!$data)
            throw new Exception("Category not found");
        return $data;
    }
    
    private static function selectItems($count, $items) {
        if ($count <= 0 || $count > count(self::$allProducts) || !is_numeric($count))
            throw new Exception("Show must be a number between 1 and 20");
        $returnIndexes = self::UniqueRandomNumbersWithinRange(0, count($items)-1, $count);
        $data = [];

        foreach ($returnIndexes as $key => $index) {
            array_push($data, $items[$index]);
        }
        return $data;
    }

    private static function UniqueRandomNumbersWithinRange($min, $max, $quantity) {
        $numbers = range($min, $max);
        shuffle($numbers);
        return array_slice($numbers, 0, $quantity);
    }
}

?>
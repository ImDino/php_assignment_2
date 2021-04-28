<?php

class ProductList {
    private static $queryCat;
    private static $queryShow;
    private static $products = [];
    private static $foundItems = [];

    public static function main() {
        $data = file_get_contents("products.json");
        self::$products = json_decode($data, true);
        self::$queryCat = $_GET['category'] ?? null;
        self::$queryShow = $_GET['show'] ?? null;
        $error = [];
        
        try {
            self::$foundItems = self::$queryCat ? self::getCategory() : self::$products;
        } catch (Exception $e) {
            array_push($error, array("Category" => $e->getMessage()));
        }
        
        try {
            $response = !is_null(self::$queryShow) ? self::selectItems() : self::$foundItems;
        } catch (Exception $e) {
            array_push($error, array("Show" => $e->getMessage()));
        }

        if ($error) {
            echo json_encode($error, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        } else echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
    
    public static function getCategory() {
        $data = [];

        foreach (self::$products as $key => $product) {
            if ($product['category'] == self::$queryCat) {
                array_push($data, $product);
            }
        }
        if (!$data)
            throw new Exception("Category not found");
        return $data;
    }
    
    public static function selectItems() {
        if (self::$queryShow <= 0 || self::$queryShow > count(self::$products) || !is_numeric(self::$queryShow))
            throw new Exception("Show must be a number between 1 and 20");
        $returnIndexes = self::UniqueRandomNumbersWithinRange(0, count(self::$foundItems)-1, self::$queryShow);
        $data = [];

        foreach ($returnIndexes as $key => $index) {
            array_push($data, self::$foundItems[$index]);
        }
        return $data;
    }

    public static function UniqueRandomNumbersWithinRange($min, $max, $quantity) {
        $numbers = range($min, $max);
        shuffle($numbers);
        return array_slice($numbers, 0, $quantity);
    }
}

?>
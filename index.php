<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Referrer-Policy: no-referrer");
header("Content-Type: application/json; charset=UTF-8");

class ProductList {
    private static $queryCat;
    private static $queryShow;
    private static $products = [];
    private static $foundItems = [];

    public static function main() {
        include_once("Products.php");
        self::$products = $products;
        self::$queryCat = $_GET['category'] ?? null;
        self::$queryShow = $_GET['show'] ?? null;

        try {
            self::$foundItems = self::$queryCat ? self::getCategory($products) : $products;
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        try {
            $response = self::$queryShow ? self::selectItems() : self::$foundItems;
            echo json_encode($response, JSON_UNESCAPED_UNICODE || JSON_PRETTY_PRINT);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public static function getCategory($products) {
        $data = [];

        foreach ($products as $key => $product) {
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

ProductList::main();

?>
<?php
include_once("Products.php");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Referrer-Policy: no-referrer");
header("Content-Type: application/json; charset=UTF-8");

$productsEncoded = json_encode($products, JSON_PRETTY_PRINT );
// echo $productsEncoded; 

// todo fråga mahmoud om vi verkligen ska returnera json med JSON_PRETTY_PRINT, då försvinner ju syftet med JSON.

$errors = [];
$returnIndexes = [];

$queryCat = $_GET['category'] ?? null;
$foundItems = $queryCat ? getCategory($queryCat, $products) : $products;

$queryShow = $_GET['show'] ?? null;
$response = ($queryShow && $queryShow < count($foundItems)) ? selectItems() : $foundItems;


function getCategory($queryCat, $products) {
    foreach ($products as $key => $product) {
        if ($product['category'] == $queryCat) {
            array_push($foundItems, $product);
        }
    }
    if (!$foundItems) {
        array_push($errors, array("Category" => "Category not found"));
    } else return $foundItems;
}

function selectItems() {
    if ($queryShow <= 0 || $queryShow > count($products) || !is_numeric($queryShow)) {
        array_push($errors, array("Show" => "Show must be a number between 1 and 20"));
    } else {
        $returnIndexes = UniqueRandomNumbersWithinRange(0, count($foundItems)-1, $queryShow);
        $data = [];

        foreach ($returnIndexes as $key => $index) {
            array_push($data, $foundItems[$index]);
        }
        return $data;
    }
}

if ($errors) {
    echo json_encode($errors, JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}

function UniqueRandomNumbersWithinRange($min, $max, $quantity) {
    $numbers = range($min, $max);
    shuffle($numbers);
    return array_slice($numbers, 0, $quantity);
}

?>
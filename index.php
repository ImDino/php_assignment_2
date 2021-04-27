<?php
include_once("Products.php");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Referrer-Policy: no-referrer");
header("Content-Type: application/json; charset=UTF-8");

$productsEncoded = json_encode($products, JSON_PRETTY_PRINT );
// echo $productsEncoded; 

// todo fråga mahmoud om vi verkligen ska returnera json med JSON_PRETTY_PRINT
// todo - då försvinner ju syftet med JSON.

$response = [];
$errors = [];
$foundItems = [];
$returnIndexes = [];

if (isset($_GET['category'])) {
    $queryCat = $_GET['category'];
    
    foreach ($products as $key => $product) {
        if ($product['category'] == $queryCat) {
            array_push($foundItems, $product);
        }
    }
    
    if (!$foundItems) {
        array_push($errors, array("Category" => "Category not found"));
    }
} else {
    $foundItems = $products;
}

if (isset($_GET['show'])) {
    $reqCount = $_GET['show'];
    
    if ($reqCount <= 0 || $reqCount > count($products) || !is_numeric($reqCount)) {
        array_push($errors, array("Show" => "Show must be a number between 1 and 20"));
    } else {
        if ($reqCount > count($foundItems)) {
            $reqCount = count($foundItems);
        }
        $returnIndexes = UniqueRandomNumbersWithinRange(0, count($foundItems)-1, $reqCount);
    }
} else {
    $returnIndexes = range(0, count($foundItems)-1);
}

if ($errors) {
    echo json_encode($errors, JSON_UNESCAPED_UNICODE);
} else {
    foreach ($returnIndexes as $key => $index) {
        array_push($response, $foundItems[$index]);
    }
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}

function UniqueRandomNumbersWithinRange($min, $max, $quantity) {
    $numbers = range($min, $max);
    shuffle($numbers);
    return array_slice($numbers, 0, $quantity);
}

?>
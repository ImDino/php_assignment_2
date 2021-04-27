<?php
include_once("Products.php");

$productsEncoded = json_encode($products, JSON_PRETTY_PRINT );
// echo $productsEncoded; 

$response = [];
$errors = [];
$foundItems = [];
$returnIndexes = [];

// if sats som kollar ifall show eller category finns och om inte direkt skicka allt? Sparar tid?

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
    $errorsEncoded = json_encode($errors, JSON_PRETTY_PRINT );
    print_r($errorsEncoded);
} else {
    foreach ($returnIndexes as $key => $index) {
        array_push($response, $foundItems[$index]);
    }
    print_r($response);
}

function UniqueRandomNumbersWithinRange($min, $max, $quantity) {
    $numbers = range($min, $max);
    shuffle($numbers);
    return array_slice($numbers, 0, $quantity);
}

?>
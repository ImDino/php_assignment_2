<?php
include_once("Products.php");

$productsEncoded = json_encode($products, JSON_PRETTY_PRINT );
// echo $productsEncoded; 

$response = [];
$errors = [];
// if sats som kollar ifall show eller category finns och om inte direkt skicka allt? Sparar tid?

// Mahmouds api kollar kategori först och sen antal.

$reqCount = $_GET['show'] ?? count($products);

if (isset($_GET['category'])) {
    $queryCat = $_GET['category'];
    $foundItems = [];

    foreach ($products as $key => $product) {
        if ($product['category'] == $queryCat) {
            array_push($foundItems, $product);
        }
    }

    if (!$foundItems) {
        array_push($errors, array("Category" => "Category not found"));
    }
}

if ($reqCount <= 0 || $reqCount > count($products) || !is_numeric($reqCount)) {
    array_push($errors, array("Show" => "Show must be between 1 and 20"));
}

if ($errors) {
    echo "hej";
    
    $errorsEncoded = json_encode($errors, JSON_PRETTY_PRINT );
    print_r($errorsEncoded);
}


/* if (isset($_GET['show'])) {

} */


function UniqueRandomNumbersWithinRange($min, $max, $quantity) {
    $numbers = range($min, $max);
    shuffle($numbers);
    return array_slice($numbers, 0, $quantity);
}

/*
Man ska kunna ange antal produkter via en GET-Request t.ex.
https://webacademy.se/fakestore/v2/?show=5
Då slumpgenereras 5 produkter via API:et.

• Man ska kunna ange kategori t.ex.
https://webacademy.se/fakestore/v2/?category=jewelery

• Säkerhetsoptimera API:et genom att validera data som skickas till serven!
Visa lämpliga meddelande i JSON-format vid fel t.ex.
https://webacademy.se/fakestore/v2/?show=100
https://webacademy.se/fakestore/v2/?category=jew
https://webacademy.se/fakestore/v2/?category=jew&show=100

*/

?>
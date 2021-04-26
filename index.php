<?php
include_once("Products.php");

$productsEncoded = json_encode($products, JSON_PRETTY_PRINT );
/* echo $productsEncoded; */

$response = [];

// if sats som kollar ifall show eller category finns och om inte direkt skicka allt? Sparar tid?


$reqCount = $_GET['show'] ?? count($products);

if ($reqCount <= 0 || $reqCount > count($products)) {
    // must be a number between 1 and count($products)
}


foreach ($products as $key => $value) {
    print_r($productsvalue);
}

if (isset($_GET['category'])) {
    // $_GET['category'];
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
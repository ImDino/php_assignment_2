<?php
include_once("Products.php");

$productsEncoded = json_encode($products, JSON_PRETTY_PRINT );
echo $productsEncoded;



?>
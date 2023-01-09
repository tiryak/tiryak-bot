<?php

require 'functions.php';

$website = 'https://shop.aksuvital.com.tr';
$categoryURL = 'ballarr';

$connect = connect($website . '/' . $categoryURL);

preg_match_all('@@si', $connect, $productsName);

echo '<pre>';
print_r($productsName);

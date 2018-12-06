<?php


include 'database.php';

$database = new Database();
$country = array(
   'name' => $_POST['name'],
    'population' => $_POST['population'],
    'capital' => $_POST['capital']
);
$database->storeCountry($country);

header('Location: countries.php');
exit;
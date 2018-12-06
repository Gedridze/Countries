<?php


include 'database.php';

$database = new Database();
$city = array(
    'name' => $_POST['name'],
    'population' => $_POST['population'],
    'fk_country' => $_POST['country_id']
);
$database->storeCity($city);

header('Location: cities.php?id='.$_POST['country_id']);
exit;
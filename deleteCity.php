<?php

include 'database.php';

$database = new Database();

$database->deleteCity($_POST['city_id']);
header('Location: cities.php?id='.$_POST['country_id']);
exit;
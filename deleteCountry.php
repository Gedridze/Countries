<?php

include 'database.php';

$database = new Database();

$database->deleteCountry($_POST['country_id']);
header('Location: countries.php');
exit;
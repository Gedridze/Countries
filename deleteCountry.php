<?php session_start(); ?>
<?php

include 'database.php';
include 'countryModel.php';
$database = new Database();
$countryModel = new countryModel($database->connection);

$countryModel->deleteCountry($_POST['country_id']);
$_SESSION['success'] = 1;
header('Location: countries.php');
exit;
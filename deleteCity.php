<?php session_start(); ?>
<?php

include 'database.php';
include 'cityModel.php';

$database = new Database();
$cityModel = new cityModel($database->connection);

$cityModel->deleteCity($_POST['city_id']);
$_SESSION['success'] = 1;
header('Location: cities.php?id='.$_POST['country_id']);
exit;
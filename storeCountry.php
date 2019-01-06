<?php session_start(); ?>
<?php


include 'database.php';
include 'countryModel.php';
$database = new Database();
$countryModel = new countryModel($database->connection);
$country = array(
   'name' => $_POST['name'],
    'population' => $_POST['population'],
    'capital' => $_POST['capital']
);
if($country['name'] == '' || ctype_space($country['name'])){
    $_SESSION['errors'][] = "Šalies pavadinimas privalomas!";
}
if($country['population'] <= 0){
    $_SESSION['errors'][] = "Populiacija negali būti < 1!";
}
if($country['capital'] == '' || ctype_space($country['capital'])){
    $_SESSION['errors'][] = "Sostinės pavadinimas privalomas!";
}
if(empty(!$_SESSION['errors'])) {
    header('Location: countries.php');
    exit;
}
$countryModel->storeCountry($country);
if(empty($_SESSION['errors'])){
    $_SESSION['success'] = 1;
}

header('Location: countries.php');
exit;
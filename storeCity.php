<?php session_start(); ?>
<?php


include 'database.php';
include 'cityModel.php';
$database = new Database();
$cityModel = new cityModel($database->connection);
$city = array(
    'name' => $_POST['name'],
    'population' => $_POST['population'],
    'fk_country' => $_POST['country_id']
);

// Salygos sakiniai, pripildantys sesijos klaidų masyvą
if($city['name'] == '' || ctype_space($city['name'])){
    $_SESSION['errors'][] = "Miesto pavadinimas privalomas!";
}
if($city['population'] <= 0){
    $_SESSION['errors'][] = "Populiacija negali būti < 1!";
}
if(!empty($_SESSION['errors'])) {
    header('Location: cities.php?id=' . $_POST['country_id']);
    exit;
}
$cityModel->storeCity($city);
if(empty($_SESSION['errors'])){
    $_SESSION['success'] = 1;
}

header('Location: cities.php?id='.$_POST['country_id']);
exit;
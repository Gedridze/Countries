<?php
include ('database.php');
include('cityModel.php');
include('countryModel.php');
$database = new Database();
$countryModel = new countryModel($database->connection);
$cityModel = new cityModel($database->connection);


if(isset($_GET['page'])){
    $pageno = $_GET['page'];
}
else{
    $pageno = 1;
}
$country_id = $_GET['id'];
$no_per_page = config::RECORD_NUM_PER_PAGE; // Nustatoma kiek irasu norima matyti viename puslapyje
if(isset($_GET['search_string'])){
    $search_string = $_GET['search_string']; // issaugoma paieskos lauko reiksme
    $link = "?id=".$country_id."&search_string=".$_GET['search_string']."&"; //$link - kintamasis skirtas saugoti GET parametru reiksmes
    //kad puslapiuojant jos nedingtu
    $total_pages = ceil($cityModel->getSearchedCitiesCount($country_id, $_GET['search_string']) / $no_per_page);
    $cities = $cityModel->searchCities($country_id, $_GET['search_string'], $pageno, $no_per_page);
}
else {
    $search_string = "";
    $link = "?id=".$country_id."&";
    $total_pages = ceil($cityModel->getCitiesCount($_GET['id']) / $no_per_page);
    $cities = $cityModel->getCities($country_id, $pageno, $no_per_page);
}

if($pageno > $total_pages && $total_pages > 0){
    header('Location: cities.php?id='.$country_id.'&page='.$total_pages); //Jei URL irasomas per didelis puslapio numeris - peradresuojama i paskutini puslapi
    exit();
}
else if($pageno < 1) {
    header('Location: cities.php?id='.$country_id.'&page=1'); //Jei URL irasomas per mazas puslapio numeris - peradresuojama i pirma puslapi
    exit();
}
$country = $countryModel->getCountry($country_id); // salis, kurios miestai atvaizduojami
?>
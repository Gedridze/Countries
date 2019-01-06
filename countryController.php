<?php include ('database.php');
include('countryModel.php');
$database = new Database();
$countryModel = new countryModel($database->connection);
if(isset($_GET['page'])){
    $pageno = $_GET['page'];
}
else{
    $pageno = 1;
}
$no_per_page = config::RECORD_NUM_PER_PAGE;

if(isset($_GET['search_string'])){
    $search_string = $_GET['search_string'];
    $link = "?search_string=".$_GET['search_string']."&";
    $total_pages = ceil($countryModel->getSearchedCountriesCount($_GET['search_string']) / $no_per_page);
    $countries = $countryModel->searchCountries($_GET['search_string'], $pageno, $no_per_page);
    if($pageno > $total_pages && $total_pages > 0){
        header('Location: countries.php'.$link.'page='.$total_pages);
        exit();
    }
    else if($pageno < 1) {
        header('Location: countries.php'.$link.'page=1');
        exit();
    }
}
else {
    $search_string = "";
    $link = "?";
    $total_pages = ceil($countryModel->getCountriesCount() / $no_per_page);
    $countries = $countryModel->getCountries($pageno, $no_per_page);
    if($pageno > $total_pages && $total_pages > 0){
        header('Location: countries.php?page='.$total_pages);
        exit();
    }
    else if($pageno < 1) {
        header('Location: countries.php?page=1');
        exit();
    }
}


?>
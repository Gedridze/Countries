<?php session_start(); ?>
<html>
<head>
    <link type="text/css" rel="stylesheet" href="style.css">
</head>
<body>
<!--Duombazes prisijungimo parametrai nustatyti config.php faile-->
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
<div class="container">
    <?php if(!empty($_SESSION['errors'])){?>
        <div class="errors">

            <?php foreach ($_SESSION['errors'] as $error){
                echo "$error</br>";
            } ?>
        </div>

        <?php $_SESSION['errors'] = array(); }
    else if(isset($_SESSION['success']) && $_SESSION['success'] == 1){?>
        <div class="success">
            Operacija sėkminga.
        </div>
        <?php $_SESSION['success'] = 0;}?>
    <fieldset style="margin-bottom: 10px;">
        <legend>Pridėti miestą</legend>
        <form  action="storeCity.php" method="post">
            <input type="hidden" name="country_id" value="<?php echo $_GET['id'] ?>">
            <label>Pavadinimas: <input type="text" name="name"></label>
            <label>Gyventojų skaičius: <input type="number" name="population" value="0"></label>
            <button type="submit">Pridėti</button>
        </form>
    </fieldset>

    <form action="cities.php" method="get">
        <input type="hidden" name="id" value="<?php echo $country['id']; ?>">
        <label>Paieška: <input type="text" name="search_string" value="<?php echo $search_string ?>"></label>
        <button type="submit">Ieškoti</button>
    </form>

    <?php  if(mysqli_num_rows($cities) != 0) {?>
    <table>
        <thead>
        <tr><td colspan="3"><?php echo $country['name'] ?></td></tr>
        <tr>
            <td>Miestas</td>
            <td>Gyventojų sk.</td>
            <td></td>
        </tr>
        </thead>
        <tbody>
        <?php while($city = mysqli_fetch_assoc($cities)){?>
            <tr>
                <td><?php echo $city['name'] ?></td>
                <td><?php echo $city['population'] ?></td>
                <td>
                    <form action="deleteCity.php" method="post" style="display: inline-block;">
                        <input type="hidden" name="country_id" value="<?php echo $country['id']; ?>">
                        <input type="hidden" name="city_id" value="<?php echo $city['id'] ?>">
                        <button type="submit">Ištrinti</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
        <ul class="paging">
            <li><a href="<?php echo $link; ?>page=1">Pirmas</a></li>
            <li class="<?php if($pageno <= 1){echo 'inactive';} ?>">
                <a href="<?php if($pageno <= 1){echo '#';} else { echo $link."page=".($pageno-1); } ?>">Atgal</a>
            </li>
            <li class="<?php if($pageno >= $total_pages){echo 'inactive';} ?>">
                <a href="<?php if($pageno >= $total_pages){echo '#';} else { echo $link."page=".($pageno+1); } ?>">Pirmyn</a>
            </li>
            <li><a href="<?php echo $link; ?>page=<?php echo $total_pages ?>">Paskutinis</a></li>
        </ul>
    <?php }
            else if(mysqli_num_rows($cities) == 0){?>
                <table>
                    <thead><tr><td colspan="3"><?php echo $country['name']; ?></td></tr></thead>
                    <tbody><tr><td colspan="3">Miestų nerasta</td></tr></tbody>
                </table>
    <?php }
            else {echo "Šalis nerasta.<br/>";}?>
    <a href="countries.php"><< Šalys</a>
</div>
</body>
</html>

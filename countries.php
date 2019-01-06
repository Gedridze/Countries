<!--
    Failo struktura identiska miestu atvaizdavimo failui.
    Kodo komentarai pateikti faile cities.php
-->
<?php session_start(); ?>
<html>
<head>
    <link type="text/css" rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'countryController.php';?>
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
    <fieldset style="margin-bottom: 10px">
        <legend>Pridėti šalį</legend>
        <form  action="storeCountry.php" method="post" >
            <label>Pavadinimas: <input type="text" name="name"></label>
            <label>Gyventojų skaičius: <input type="number" name="population" value="0"></label>
            <label>Sostinė: <input type="text" name="capital"></label>
            <button type="submit">Pridėti</button>
        </form>
    </fieldset>
    <form action="countries.php" method="get">
        <label>Paieška: <input type="text" name="search_string" value="<?php echo $search_string; ?>"></label>
        <button type="submit">Ieškoti</button>
    </form>

    <?php if(mysqli_num_rows($countries) != 0) {?>
    <table>
        <thead>
        <tr>
            <td>Šalis</td>
            <td>Gyventojų sk.</td>
            <td>Sostinė</td>
            <td></td>
        </tr>
        </thead>
        <tbody>
        <?php while($country = mysqli_fetch_assoc($countries)){?>
            <tr>
                <td><a href="cities.php?id=<?php echo $country['id'] ?>"><?php echo $country['name'] ?></a></td>
                <td><?php echo $country['population'] ?></td>
                <td><?php echo $country['capital'] ?></td>
                <td>
                    <form action="deleteCountry.php" method="post" style="display: inline-block;">
                        <input type="hidden" name="country_id" value="<?php echo $country['id']; ?>">
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
    <?php } else {echo "Šalių nerasta</br>";?>
    <a href="countries.php"><< Visos šalys</a>
    <?php } ?>
</div>
</body>
</html>
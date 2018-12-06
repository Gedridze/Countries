<?php
include ('config.php');
    //Klasė, skirta operacijoms su duombaze atlikti

class Database{

    public $connection;

    function __construct()
    {
        $this->connection = mysqli_connect(config::DB_HOST, config::DB_USER, config::DB_PASS, config::DB_NAME);
        if(!$this->connection){
            die("Klaida: nepavyko prisijungti prie duombazės");
        }
    }

    function getCountries($page_no, $no_per_page){
        $offset = ($page_no-1) * $no_per_page;
        $query = "SELECT * FROM countries LIMIT $offset, $no_per_page";
        return mysqli_query($this->connection, $query);
    }

    function getCountry($id){
        $query = "SELECT * FROM countries WHERE id = $id";
        $result = mysqli_query($this->connection, $query);
        return mysqli_fetch_assoc($result);
    }

    function storeCountry($country){
        $query = "INSERT INTO countries (name, population, capital) VALUES('$country[name]', '$country[population]', '$country[capital]')";
        mysqli_query($this->connection, $query);
    }

    function deleteCountry($id){
        $query = "DELETE FROM cities WHERE fk_country = $id; DELETE FROM countries WHERE id = $id";

        mysqli_multi_query($this->connection, $query);
    }

    function searchCountries($search_string, $page_no, $no_per_page){
        $offset = ($page_no-1) * $no_per_page;
        $query = "SELECT * FROM countries WHERE name LIKE '%$search_string%' LIMIT $offset, $no_per_page";
        return mysqli_query($this->connection, $query);
    }

    function getCountriesCount(){
        $query = "SELECT count(*) as count FROM countries";
        $result = mysqli_query($this->connection, $query);
        return mysqli_fetch_assoc($result)['count'];
    }

    function getSearchedCountriesCount($search_string){
        $query = "SELECT count(*) as count FROM countries WHERE name LIKE '%$search_string%'";
        $result = mysqli_query($this->connection, $query);
        return mysqli_fetch_assoc($result)['count'];
    }

    public function getCities($country_id, $page_no, $no_per_page){
        $offset = ($page_no-1) * $no_per_page;
        $query = "SELECT * FROM cities WHERE fk_country = $country_id LIMIT $offset, $no_per_page";
        return mysqli_query($this->connection, $query);
    }


    public function storeCity($city){
        $query = "INSERT INTO cities (name, population, fk_country) VALUES('$city[name]', '$city[population]', '$city[fk_country]')";
        mysqli_query($this->connection, $query);
    }

    public function deleteCity($id){
        $query = "DELETE FROM cities WHERE id = $id";
        mysqli_query($this->connection, $query);
    }

    public function searchCities($country_id, $search_string, $page_no, $no_per_page){
        $offset = ($page_no-1) * $no_per_page;
        $query = "SELECT * FROM cities WHERE name LIKE '%$search_string%' AND fk_country = $country_id LIMIT $offset, $no_per_page";
        return mysqli_query($this->connection, $query);
    }

    public function getCitiesCount($country_id){
        $query = "SELECT count(*) as count FROM cities WHERE fk_country = $country_id";
        $result = mysqli_query($this->connection, $query);
        return mysqli_fetch_assoc($result)['count'];
    }

    public function getSearchedCitiesCount($country_id, $search_string){
        $query = "SELECT count(*) as count FROM cities WHERE fk_country = $country_id AND name LIKE '%$search_string%'";
        $result = mysqli_query($this->connection, $query);
        return mysqli_fetch_assoc($result)['count'];
    }



}
?>
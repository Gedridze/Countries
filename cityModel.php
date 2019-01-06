<?php


class cityModel
{
    public $connection;

        function __construct($connection)
        {
            $this->connection = $connection;
        }

    public function getCities($country_id, $page_no, $no_per_page){
        $offset = ($page_no-1) * $no_per_page;
        $statement = mysqli_prepare($this->connection,'SELECT * FROM cities WHERE fk_country = ? LIMIT ?, ?');
        $statement->bind_param("iii", $country_id, $offset, $no_per_page);
        $statement->execute();
        return $statement->get_result();
    }


    public function storeCity($city){
        $statement = mysqli_prepare($this->connection, 'INSERT INTO cities (name, population, fk_country) VALUES(?, ?, ?)');
        $statement->bind_param('sii', $city['name'], $city['population'], $city['fk_country']);
        $statement->execute();
        if($statement->error != null){
            $_SESSION['errors'][] = "Toks miestas jau yra!";
        }
    }

    public function deleteCity($id){
        $statement = mysqli_prepare($this->connection, 'DELETE FROM cities WHERE id = ?');
        $statement->bind_param('i', $id);
        $statement->execute();
    }

    public function searchCities($country_id, $search_string, $page_no, $no_per_page){
        $offset = ($page_no-1) * $no_per_page;
        $statement = mysqli_prepare($this->connection,"SELECT * FROM cities WHERE name LIKE ? AND fk_country = ? LIMIT ?, ?");
        $search_string = '%'.$search_string.'%';
        $statement->bind_param('siii', $search_string, $country_id, $offset, $no_per_page);
        $statement->execute();
        return $statement->get_result();
    }

    public function getCitiesCount($country_id){
        $statement = mysqli_prepare($this->connection,"SELECT count(*) as count FROM cities WHERE fk_country = ?");
        $statement->bind_param('i', $country_id);
        $statement->execute();
        $result = $statement->get_result();
        return mysqli_fetch_assoc($result)['count'];
    }

    public function getSearchedCitiesCount($country_id, $search_string){
        $statement = mysqli_prepare($this->connection, 'SELECT count(*) as count FROM cities WHERE fk_country = ? AND name LIKE ?');
        $search_string = '%'.$search_string.'%';
        $statement->bind_param('is', $country_id, $search_string);
        $statement->execute();
        $result = $statement->get_result();
        return mysqli_fetch_assoc($result)['count'];
    }

}
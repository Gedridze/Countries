<?php


class countryModel
{
    public $connection;

    function __construct($connection)
    {
        $this->connection = $connection;
    }

    function getCountries($page_no, $no_per_page){
        $offset = ($page_no-1) * $no_per_page;
        $statement = mysqli_prepare($this->connection, 'SELECT * FROM countries LIMIT ?, ?');
        $statement->bind_param('ii', $offset, $no_per_page);
        $statement->execute();
        return $statement->get_result();
    }

    function getCountry($id){
        $statement = mysqli_prepare($this->connection, 'SELECT * FROM countries WHERE id = ?');
        $statement->bind_param('i', $id);
        $statement->execute();
        $result = $statement->get_result();
        return mysqli_fetch_assoc($result);
    }

    function storeCountry($country){
        $statement = mysqli_prepare($this->connection, 'INSERT INTO countries(name, population, capital) VALUES(?,?,?)');
        $statement->bind_param('sis', $country['name'], $country['population'], $country['capital']);
        $statement->execute();
        if($statement->error != null){
            $_SESSION['errors'][] = "Tokia šalis jau yra!";
        }
    }

    function deleteCountry($id){
        $statement = mysqli_prepare($this->connection, 'DELETE FROM cities WHERE fk_country = ?;');// DELETE FROM countries WHERE id = ?');
        $statement->bind_param('i', $id);
        $statement->execute();
        $statement = mysqli_prepare($this->connection, 'DELETE FROM countries WHERE id = ?');
        $statement->bind_param('i', $id);
        $statement->execute();
    }

    function searchCountries($search_string, $page_no, $no_per_page){
        $offset = ($page_no-1) * $no_per_page;
        $statement = mysqli_prepare($this->connection, 'SELECT * FROM countries WHERE name LIKE ? LIMIT ?, ?');
        $search_string = '%'.$search_string.'%';
        $statement->bind_param('sii', $search_string, $offset, $no_per_page);
        $statement->execute();
        return $statement->get_result();
    }

    function getCountriesCount(){
        $query = "SELECT count(*) as count FROM countries";
        $result = mysqli_query($this->connection, $query);
        return mysqli_fetch_assoc($result)['count'];
    }

    function getSearchedCountriesCount($search_string){
        $statement = mysqli_prepare($this->connection, 'SELECT count(*) as count FROM countries WHERE name LIKE ?');
        $search_string = '%'.$search_string.'%';
        $statement->bind_param('s', $search_string);
        $statement->execute();
        $result = $statement->get_result();
        return mysqli_fetch_assoc($result)['count'];
    }

}
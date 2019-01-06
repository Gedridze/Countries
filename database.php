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




}
?>
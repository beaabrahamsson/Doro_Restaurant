<?php
/*
 * @Author: Beatrice Abrahamsson
 * @Email: beaabrahamsson6@gmail.com
 * @Date: 2022-05-12 15:12:31
 * @Last Modified by: Beatrice Abrahamsson
 * @Last Modified time: 2022-05-26 15:34:45
 * @Description: Description
 */

class Dessert {
    //properties
    private $db;
    private $name;
    private $price;
    private $description;
    private $id;

    //constructor with db connection
    function __construct() {
        $this->db = new mysqli('studentmysql.miun.se', 'beab2100', 'HXRh5FzwsZ', 'beab2100'); //ansluta till databas
        if($this->db->connect_errno > 0){
            die('Fel vid anslutning' . $this->db->connect_error);
        }
    }

    //method to get desserts
    public function getDesserts() : array {
        //SQL query
        $sql = "SELECT * FROM `dessert`";
        //Send query
        $result = $this->db->query($sql);
        //Fetch all rows and return the result-set as an associative array
        $array = mysqli_fetch_all($result, MYSQLI_ASSOC);
        //return array
        return $array;
    }

    //method to get dessert by id
    public function getDessertById(int $id) : array {
        //SQL query
        $sql = "SELECT * FROM `dessert` WHERE `dessertid`='$id'";
        //send query
        $result = mysqli_query($this->db, $sql);
        //return as array
        return $result->fetch_assoc();
    }

    //Set method
    public function setDessert(string $name, string $price, string $description) : bool {
        if($name != "" && $price != "" && $description != "") {
            //set
            $this->name = $name;
            $this->price = $price;
            $this->description = $description;
            return true;
        } else {
            return false;
        }
        
    }

    //Method to create new dessert
    public function createDessert($name, $price, $description) : bool{
        //check with set method
        if(!$this->setDessert($name, $price, $description)) return false;

         //Remove any HTML from input
         $this->name = strip_tags($name);
         $this->price = strip_tags($price);
         $this->description = strip_tags($description);
        
        // Insert into database using prapared statement
        $stmt = $stmt = $this->db->prepare("INSERT INTO dessert(name, price, description) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $this->name, $this->price, $this->description);
        $insert = $stmt->execute();
        return $insert;
    }

    //Method to update dessert
    public function updateDessert(string $id, string $name, string $price, string $description) {
        //check with set methods
        if(!$this->setDessert($name, $price, $description)) return false;

         //Remove any HTML from input
         $this->name = strip_tags($name);
         $this->price = strip_tags($price);
         $this->description = strip_tags($description);

        // Insert into database using prapared statement
        $stmt = $this->db->prepare("UPDATE dessert SET name=?, price=?, description=? WHERE dessertid=?");
        $stmt->bind_param("sssi", $this->name, $this->price, $this->description, $id);
        $insert = $stmt->execute();
        return $insert;
    }

     //method to delete dessert
     public function deleteDessert(int $id) : bool {
        //SQL Query
        $sql = "DELETE FROM `dessert` WHERE `dessertid`='$id'";
        //Send query
        return mysqli_query($this->db, $sql);
    }

    //Destructor
    function __destruct() {
        mysqli_close($this->db);
    }

}



?>
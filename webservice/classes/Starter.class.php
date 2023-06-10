<?php
/*
 * @Author: Beatrice Abrahamsson
 * @Email: beaabrahamsson6@gmail.com
 * @Date: 2022-05-12 15:12:31
 * @Last Modified by: Beatrice Abrahamsson
 * @Last Modified time: 2022-05-26 15:38:10
 * @Description: Description
 */

class Starter {
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

    //method to get starters
    public function getStarters() : array {
        //SQL query
        $sql = "SELECT * FROM `starter`";
        //Send query
        $result = $this->db->query($sql);
        //Fetch all rows and return the result-set as an associative array
        $array = mysqli_fetch_all($result, MYSQLI_ASSOC);
        //return array
        return $array;
    }

    //method to get starter by id
    public function getStarterById(int $id) : array {
        //SQL query
        $sql = "SELECT * FROM `starter` WHERE `starterid`='$id'";
        //send query
        $result = mysqli_query($this->db, $sql);
        //return as array
        return $result->fetch_assoc();
    }

    //set method
    public function setStarter(string $name, string $price, string $description) : bool {
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

    //Method to create new starter
    public function createStarter($name, $price, $description) : bool {
        //check with set method
        if(!$this->setStarter($name, $price, $description)) return false;

        //Remove any HTML from input
        $this->name = strip_tags($name);
        $this->price = strip_tags($price);
        $this->description = strip_tags($description);
        
        // Insert into database using prapared statement
        $stmt = $stmt = $this->db->prepare("INSERT INTO starter(name, price, description) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $this->name, $this->price, $this->description);
        $insert = $stmt->execute();
        return $insert;
    }

    //mthod to update starter
    public function updateStarter(string $id, string $name, string $price, string $description) {
        //check with set methods
        if(!$this->setStarter($name, $price, $description)) return false;

        //Remove any HTML from input
        $this->name = strip_tags($name);
        $this->price = strip_tags($price);
        $this->description = strip_tags($description);

        // Insert into database using prapared statement
        $stmt = $this->db->prepare("UPDATE starter SET name=?, price=?, description=? WHERE starterid=?");
        $stmt->bind_param("sssi", $this->name, $this->price, $this->description, $id);
        $insert = $stmt->execute();
        return $insert;
    }

     //method to Delete starter
     public function deleteStarter(int $id) : bool {
        //SQL Query
        $sql = "DELETE FROM `starter` WHERE `starterid`='$id'";
        //Send query
        return mysqli_query($this->db, $sql);
    }

    //Destructor
    function __destruct() {
        mysqli_close($this->db);
    }

}



?>
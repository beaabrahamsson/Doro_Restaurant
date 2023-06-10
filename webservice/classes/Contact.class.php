<?php
/*
 * @Author: Beatrice Abrahamsson
 * @Email: beaabrahamsson@hotmail.com
 * @Date: 2022-05-21 16:55:01
 * @Last Modified by: Beatrice Abrahamsson
 * @Last Modified time: 2022-05-26 15:33:18
 * @Description: Description
 */

class Contact {
    //properties
    private $db;
    private $fname;
    private $lname;
    private $phone;
    private $email;
    private $message;
    private $id;

    //constructor with db connection
    function __construct() {
        $this->db = new mysqli('studentmysql.miun.se', 'beab2100', 'HXRh5FzwsZ', 'beab2100'); //ansluta till databas
        if($this->db->connect_errno > 0){
            die('Fel vid anslutning' . $this->db->connect_error);
        }
    }

    //Method to get messages
    public function getContacts() : array {
        //SQL query
        $sql = "SELECT * FROM `contact`";
        //Send query
        $result = $this->db->query($sql);
        //Fetch all rows and return the result-set as an associative array
        $array = mysqli_fetch_all($result, MYSQLI_ASSOC);
        //return array
        return $array;
    }

    //method to get messages by id
    public function getContactById(int $id) : array {
        //SQL query
        $sql = "SELECT * FROM `contact` WHERE `contactid`='$id'";
        //send query
        $result = mysqli_query($this->db, $sql);
        //return as array
        return $result->fetch_assoc();
    }

    //Method to set message
    public function setContact(string $fname, string $lname, string $phone, string $email, string $message) : bool {
        if($fname != "" && $lname != "" && $phone != "" && $email != "" && $message != "") {

            //set
            $this->fname = $fname;
            $this->lname = $lname;
            $this->phone = $phone;
            $this->email = $email;
            $this->message = $message;
            return true;
        } else {
            return false;
        }  
    }

    //Method to create new message
    public function createContact($fname, $lname, $phone, $email, $message) : bool {
        //check with set method
        if(!$this->setContact($fname, $lname, $phone, $email, $message)) return false;

        $this->fname = strip_tags($fname);
        $this->lname = strip_tags($lname);
        $this->phone = strip_tags($phone);
        $this->email = strip_tags($email);
        $this->message = strip_tags($message);
        
        // Insert into database using prapared statement
        $stmt = $stmt = $this->db->prepare("INSERT INTO contact(fname, lname, phone, email, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $this->fname, $this->lname, $this->phone, $this->email, $this->message);
        $insert = $stmt->execute();
        return $insert;
    }

    //Method to update message
    public function updateContact(int $id, string $fname, string $lname, string $phone, string $email, string $message) {
        //check with set methods
        if(!$this->setContact($fname, $lname, $phone, $email, $message)) return false;

        $this->fname = strip_tags($fname);
        $this->lname = strip_tags($lname);
        $this->phone = strip_tags($phone);
        $this->email = strip_tags($email);
        $this->message = strip_tags($message);

        // Insert into database using prapared statement
        $stmt = $this->db->prepare("UPDATE contact SET fname=?, lname=?, phone=?, email=?, message=? WHERE contactid=?");
        $stmt->bind_param("sssssi", $this->fname, $this->lname, $this->phone, $this->email, $this->message, $id);
        $insert = $stmt->execute();
        return $insert;
    }

     //method to delete message
     public function deleteContact(int $id) : bool {
        //SQL Query
        $sql = "DELETE FROM `contact` WHERE `contactid`='$id'";
        //Send query
        return mysqli_query($this->db, $sql);
    }

    //Destructor
    function __destruct() {
        mysqli_close($this->db);
    }

}



?>
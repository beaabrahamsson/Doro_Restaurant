<?php
/*
 * @Author: Beatrice Abrahamsson
 * @Email: beaabrahamsson@hotmail.com
 * @Date: 2022-05-27 17:25:18
 * @Last Modified by: Beatrice Abrahamsson
 * @Last Modified time: 2022-05-27 17:43:25
 * @Description: Description
 */

class Review {
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
    public function getReviews() : array {
        //SQL query
        $sql = "SELECT * FROM `review`";
        //Send query
        $result = $this->db->query($sql);
        //Fetch all rows and return the result-set as an associative array
        $array = mysqli_fetch_all($result, MYSQLI_ASSOC);
        //return array
        return $array;
    }

    //method to get messages by id
    public function getReviewById(int $id) : array {
        //SQL query
        $sql = "SELECT * FROM `review` WHERE `reviewid`='$id'";
        //send query
        $result = mysqli_query($this->db, $sql);
        //return as array
        return $result->fetch_assoc();
    }

    //Method to set message
    public function setReview(string $fname, string $lname, string $phone, string $email, string $message) : bool {
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
    public function createReview($fname, $lname, $phone, $email, $message) : bool {
        //check with set method
        if(!$this->setReview($fname, $lname, $phone, $email, $message)) return false;

        $this->fname = strip_tags($fname);
        $this->lname = strip_tags($lname);
        $this->phone = strip_tags($phone);
        $this->email = strip_tags($email);
        $this->message = strip_tags($message);
        
        // Insert into database using prapared statement
        $stmt = $stmt = $this->db->prepare("INSERT INTO review(fname, lname, phone, email, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $this->fname, $this->lname, $this->phone, $this->email, $this->message);
        $insert = $stmt->execute();
        return $insert;
    }

    //Method to update message
    public function updateReview(int $id, string $fname, string $lname, string $phone, string $email, string $message) {
        //check with set methods
        if(!$this->setReview($fname, $lname, $phone, $email, $message)) return false;

        $this->fname = strip_tags($fname);
        $this->lname = strip_tags($lname);
        $this->phone = strip_tags($phone);
        $this->email = strip_tags($email);
        $this->message = strip_tags($message);

        // Insert into database using prapared statement
        $stmt = $this->db->prepare("UPDATE review SET fname=?, lname=?, phone=?, email=?, message=? WHERE reviewid=?");
        $stmt->bind_param("sssssi", $this->fname, $this->lname, $this->phone, $this->email, $this->message, $id);
        $insert = $stmt->execute();
        return $insert;
    }

     //method to delete message
     public function deleteReview(int $id) : bool {
        //SQL Query
        $sql = "DELETE FROM `review` WHERE `reviewid`='$id'";
        //Send query
        return mysqli_query($this->db, $sql);
    }

    //Destructor
    function __destruct() {
        mysqli_close($this->db);
    }

}


?>
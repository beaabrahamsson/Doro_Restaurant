<?php
/*
 * @Author: Beatrice Abrahamsson
 * @Email: beaabrahamsson@hotmail.com
 * @Date: 2022-05-21 16:54:51
 * @Last Modified by: Beatrice Abrahamsson
 * @Last Modified time: 2022-05-28 16:34:26
 * @Description: Description
 */

class Booking {
    //properties
    private $db;
    private $fname;
    private $lname;
    private $phone;
    private $email;
    private $date;
    private $time;
    private $guests;
    private $note;
    private $id;

    //constructor with db connection
    function __construct() {
        $this->db = new mysqli('studentmysql.miun.se', 'beab2100', 'HXRh5FzwsZ', 'beab2100'); //ansluta till databas
        if($this->db->connect_errno > 0){
            die('Fel vid anslutning' . $this->db->connect_error);
        }
    }

    //method to get bookings
    public function getBookings() : array {
        //SQL query
        $sql = "SELECT * FROM `booking`";
        //Send query
        $result = $this->db->query($sql);
        //Fetch all rows and return the result-set as an associative array
        $array = mysqli_fetch_all($result, MYSQLI_ASSOC);
        //return array
        return $array;
    }

    //method to get booking by id
    public function getBookingById(int $id) : array {
        //SQL query
        $sql = "SELECT * FROM `booking` WHERE `bookingid`='$id'";
        //send query
        $result = mysqli_query($this->db, $sql);
        //return as array
        return $result->fetch_assoc();
    }

    //Set-method
    public function setBooking(string $fname, string $lname, string $phone, string $email, string $date, string $time, string $guests, string $note): bool {
        if($fname != "" && $lname != "" && $phone != "" && $email != "" && $date != "" && $time != "" && $guests != "") {
            //set
            $this->fname = $fname;
            $this->lname = $lname;
            $this->phone = $phone;
            $this->email = $email;
            $this->date = $date;
            $this->time = $time;
            $this->guests = $guests;
            $this->note = $note;
            return true;
        } else {
            return false;
        }
    }
        

    //Mehtod to create new booking
    public function createBooking($fname, $lname, $phone, $email, $date, $time, $guests, $note) : bool {
        //Check set method
        if(!$this->setBooking($fname, $lname, $phone, $email, $date, $time, $guests, $note)) return false;

        //Remove any HTML from input
        $this->fname = strip_tags($fname);
        $this->lname = strip_tags($lname);
        $this->phone = strip_tags($phone);
        $this->email = strip_tags($email);
        $this->date = strip_tags($date);
        $this->time = strip_tags($time);
        $this->guests = strip_tags($guests);
        $this->note = strip_tags($note);

        // Insert into database using prapared statement
        $stmt = $this->db->prepare("INSERT INTO booking(fname, lname, phone, email, date, time, guests, note) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $this->fname, $this->lname, $this->phone, $this->email, $this->date, $this->time, $this->guests, $this->note);
        $insert = $stmt->execute();
        return $insert;
        
    }

    //method to update booking
    public function updateBooking($id, $fname, $lname, $phone, $email, $date, $time, $guests, $note) {
        //Check set method
        if(!$this->setBooking($fname, $lname, $phone, $email, $date, $time, $guests, $note, $id)) return false;

        //Remove any HTML from input
        $this->fname = strip_tags($fname);
        $this->lname = strip_tags($lname);
        $this->phone = strip_tags($phone);
        $this->email = strip_tags($email);
        $this->date = strip_tags($date);
        $this->time = strip_tags($time);
        $this->guests = strip_tags($guests);
        $this->note = strip_tags($note);

        // Insert into database using prapared statement
        $stmt = $this->db->prepare("UPDATE booking SET fname=?, lname=?, phone=?, email=?, date=?, time=?, guests=?, note=? WHERE bookingid=?");
        $stmt->bind_param("ssssssssi", $this->fname, $this->lname, $this->phone, $this->email, $this->date, $this->time, $this->guests, $this->note, $id);
        $insert = $stmt->execute();
    }

     //Method to delete booking
     public function deleteBooking(int $id) : bool {
        //SQL Query
        $sql = "DELETE FROM `booking` WHERE `bookingid`='$id'";
        //Send query
        return mysqli_query($this->db, $sql);
    }

    //Destructor
    function __destruct() {
        mysqli_close($this->db);
    }

}



?>
<?php
/*
 * @Author: Beatrice Abrahamsson
 * @Email: beaabrahamsson@hotmail.com
 * @Date: 2022-05-25 13:34:10
 * @Last Modified by: Beatrice Abrahamsson
 * @Last Modified time: 2022-05-26 16:26:37
 * @Description: Description
 */


class User {
    //properties
    private $db;
    private $id;
    private $uname;
    private $pword;

    //constructor with db connection
    function __construct() {
        $this->db = new mysqli('studentmysql.miun.se', 'beab2100', 'HXRh5FzwsZ', 'beab2100'); //ansluta till databas
        if($this->db->connect_errno > 0){
            die('Fel vid anslutning' . $this->db->connect_error);
        }
    }

    //Login
    public function userLogin(string $uname, string $pword) : bool {
        //SQL query
        $sql = "SELECT * FROM new_user WHERE uname='$uname';";

        //Send query
        $result = $this->db->query($sql);

        //If the number of rows in result is more than 0
        if($result->num_rows > 0) {
            //fetch as an associative array
            $row = $result->fetch_assoc();
            //set password variable
            $password = $row['pword'];

            //If password matches a hash
            if($pword == $password) {
                //set session uname
                $_SESSION['uname'] = $uname;
                //set session userid
                $_SESSION['userid'] = $row['userid'];
                //return true
                return true;
            } else {
                //else return false
                return false;
            }
        } else {
            //else return false
            return false;
        }
    }

    //method to check if user is logged in
    public function checkLogin() : bool {
        //Check is session username is set
        if(isset($_SESSION['uname'])) {
            //retun true
            return true;
        } else {
            //return false
            return false;
        }
    }

    //method to restrict page
    public function restrictPage() {
        //if session username is not set
        if(!isset($_SESSION['uname'])) {
            //send to login page with error message
            header("Location: login.php?error=Du måste logga in!");
            exit;
        }
    }

    //method to get users
    public function getUsers() : array {
        //SQL question
        $sql = "SELECT * FROM user";
        //If query not sent -> error
        if(!$result = $this->db->query($sql)){
            die('Fel vid SQL-fråga [' . $db->error . ']');
        }
        //Fetch all as array
        $array = mysqli_fetch_all($result, MYSQLI_ASSOC);
        //return array
        return $array;
    }

    //Destructor
    function __destruct() {
        mysqli_close($this->db);
        }

}

?>
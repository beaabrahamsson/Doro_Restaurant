<?php
/*
 * @Author: Beatrice Abrahamsson
 * @Email: beaabrahamsson6@gmail.com
 * @Date: 2022-05-12 21:14:59
 * @Last Modified by: Beatrice Abrahamsson
 * @Last Modified time: 2022-05-26 14:22:57
 * @Description: Description
 */

//includes
include("classes/Booking.class.php");
include("includes/headers.php");

//If a parameter of id is present in the url, it is stored in a variable
if(isset($_GET['id'])) {
    $id = $_GET['id'];
}

//creating object ($booking) from the class Booking
$booking = new Booking();

switch($method) {
    case 'GET':
        //If id is set, get bookings by id
        if(isset($id)) {
            $response = $booking->getBookingById($id);
        } else {
            //else get all bookings
            $response = $booking->getBookings();
        }

        //If no elements in array, set message
        if(count($response) === 0) {
            $response = array("message" => "Inga bokningar i databasen");
            http_response_code(404); //Not found
        } else {
            http_response_code(200); //Ok - The request has succeeded
        }

        break;
    case 'POST':
        //Loads JSON data sent with the call and converts to an object.
        $data = json_decode(file_get_contents("php://input"), true);

        //Create booking
        if($booking->setBooking($data["fname"], $data["lname"], $data["phone"], $data["email"], $data["date"], $data["time"], $data["guests"], $data["note"])) {
            if($booking->createBooking($data["fname"], $data["lname"], $data["phone"], $data["email"], $data["date"], $data["time"], $data["guests"], $data["note"])) {
                $response = array("message" => "bokning tillagd");
                http_response_code(201); //Created
            } else {
                $response = array("message" => "Fel vid lagring av bokning");
                http_response_code(500); //Internal server error
            }
        } else {
            $response = array("message" => "Skicka med ...");
            http_response_code(400); //Bad request
        }
        
        break;
    case 'PUT':
        //Loads JSON data sent with the call and converts to an object.
        $data = json_decode(file_get_contents("php://input"), true);

        //Update booking
        if($booking->setBooking($data["fname"], $data["lname"], $data["phone"], $data["email"], $data["date"], $data["time"], $data["guests"], $data["note"])) {
            if($booking->updateBooking($data["bookingid"], $data["fname"], $data["lname"], $data["phone"], $data["email"], $data["date"], $data["time"], $data["guests"], $data["note"])) {
                $response = array(var_dump($data));
                $response = array("message" => "bokning uppdaterad");
                http_response_code(201); //Created
            } else {
                $response = array("message" => "Fel vid uppdatering av bokning");
                http_response_code(500); //Internal server error
            }
        } else {
            $response = array("message" => "Skicka med ...");
            http_response_code(400); //Bad request
        }


        break;
    case 'DELETE':
        if(!isset($id)) { //If id is not set, set message
            http_response_code(400); //Bad request
            $response = array("message" => "Skicka med id");  
        } else {
            if($booking->deleteBooking($id)) { //else, delete booking
                http_response_code(200); //OK
                $response = array("message" => "Bokning raderad"); 
            }
        }
        break;
        
}

//Sends a reply back to the sender
echo json_encode($response);
?>
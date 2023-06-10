<?php
/*
 * @Author: Beatrice Abrahamsson
 * @Email: beaabrahamsson@hotmail.com
 * @Date: 2022-05-27 17:24:04
 * @Last Modified by: Beatrice Abrahamsson
 * @Last Modified time: 2022-05-27 17:44:27
 * @Description: Description
 */

//includes
include("classes/Review.class.php");
include("includes/headers.php");

//If a parameter of id is present in the url, it is stored in a variable
if(isset($_GET['id'])) {
    $id = $_GET['id'];
}

//creating object ($Review) from the class Review
$review = new Review();

switch($method) {
    case 'GET':
        //If id is set, get messages by id
        if(isset($id)) {
            $response = $review->getReviewById($id);
        } else {
            //Else, get all messages
            $response = $review->getReviews();
        }

        //If no elements in array, set message
        if(count($response) === 0) {
            $response = array("message" => "Inga omdömen i databasen");
            http_response_code(404); //Not found
        } else {
            http_response_code(200); //Ok - The request has succeeded
        }

        break;
    case 'POST':
        //Loads JSON data sent with the call and converts to an object.
        $data = json_decode(file_get_contents("php://input"), true);

        //Create message
        if($review->setReview($data["fname"], $data["lname"], $data["phone"], $data["email"], $data["message"])) {
            if($review->createReview($data["fname"], $data["lname"], $data["phone"], $data["email"], $data["message"])) {
                $response = array("message" => "Omdöme tillagd");
                http_response_code(201); //Created
            } else {
                $response = array("message" => "Fel vid lagring av omdöme");
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

        //Update message
        if($review->updateReview($data["reviewid"], $data["fname"], $data["lname"], $data["phone"], $data["email"], $data["message"])) {
        $response = array("message" => "Omdöme uppdaterad");
        http_response_code(200); //OK
        } else {
            http_response_code(500); //Internal server error
            $response = array("message" => "Fel vid uppdatering av omdöme");
        }


        break;
    case 'DELETE':
        if(!isset($id)) { //If id is not set, set message
            http_response_code(400); //Bad request
            $response = array("message" => "Skicka med id");  
        } else {
            if($review->deleteReview($id)) { //Else, delete message
                http_response_code(200); //OK
                $response = array("message" => "Omdöme raderad"); 
            }
        }
        break;
        
}

//Sends a reply back to the sender
echo json_encode($response);
?>
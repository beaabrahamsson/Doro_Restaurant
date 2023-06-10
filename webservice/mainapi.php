<?php
/*
 * @Author: Beatrice Abrahamsson
 * @Email: beaabrahamsson6@gmail.com
 * @Date: 2022-05-12 21:14:59
 * @Last Modified by: Beatrice Abrahamsson
 * @Last Modified time: 2022-05-26 14:23:33
 * @Description: Description
 */

//includes
include("classes/Main.class.php");
include("includes/headers.php");

//If a parameter of id is present in the url, it is stored in a variable
if(isset($_GET['id'])) {
    $id = $_GET['id'];
}

//creating object ($main) from the class Main
$main = new Main();

switch($method) {
    case 'GET':
        if(isset($id)) {
            $response = $main->getMainById($id); //If id is set, get main course by id
        } else {
            $response = $main->getMains(); //Else, get all main courses
        }

        //If no elements in array, set message
        if(count($response) === 0) {
            $response = array("message" => "Inga huvudrätter i databasen");
            http_response_code(404); //Not found
        } else {
            http_response_code(200); //Ok - The request has succeeded
        }

        break;
    case 'POST':
        //Loads JSON data sent with the call and converts to an object.
        $data = json_decode(file_get_contents("php://input"), true);

        //Create message
        if($main->setMain($data["name"], $data["price"], $data["description"])) {
            if($main->createMain($data["name"], $data["price"], $data["description"])) {
                $response = array("message" => "Meddelande tillagd");
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

        //Update main course
        if($main->updateMain($data["mainid"], $data["name"], $data["price"], $data["description"])) {
        $response = array("message" => "Huvudrätt uppdaterad");
        http_response_code(200); //OK
        } else {
            http_response_code(500); //Internal server error
            $response = array("message" => "Fel vid uppdatering av Huvudrätt");
        }


        break;
    case 'DELETE':
        if(!isset($id)) { //If id is not set, set message
            http_response_code(400); //Bad request
            $response = array("message" => "Skicka med id");  
        } else {
            if($main->deleteMain($id)) { //Else, delete main course
                http_response_code(200); //OK
                $response = array("message" => "Huvudrätt raderad"); 
            }
        }
        break;
        
}

//Sends a reply back to the sender
echo json_encode($response);
?>
<?php
/*
 * @Author: Beatrice Abrahamsson
 * @Email: beaabrahamsson6@gmail.com
 * @Date: 2022-05-12 15:12:17
 * @Last Modified by: Beatrice Abrahamsson
 * @Last Modified time: 2022-05-26 14:23:49
 * @Description: Description
 */

//includes
include("classes/Starter.class.php");
include("includes/headers.php");

//If a parameter of id is present in the url, it is stored in a variable
if(isset($_GET['id'])) {
    $id = $_GET['id'];
}

//creating object ($starter) from the class Starter
$starter = new Starter();

switch($method) {
    case 'GET':
        if(isset($id)) {
            $response = $starter->getStarterById($id); //If id is set, get starter by id
        } else {
            $response = $starter->getStarters(); //Else, get all starters
        }
        //If no elements in array, set message
        if(count($response) === 0) {
            $response = array("message" => "Inga förrätter i databasen");
            http_response_code(404); //Not found
        } else {
            http_response_code(200); //Ok - The request has succeeded
        }

        break;
    case 'POST':
        //Loads JSON data sent with the call and converts to an object
        $data = json_decode(file_get_contents("php://input"), true);

        //Create starter
        if($starter->setStarter($data["name"], $data["price"], $data["description"])) {
            if($starter->createStarter($data["name"], $data["price"], $data["description"])) {
                $response = array("message" => "förrätt tillagd");
                http_response_code(201); //Created
            } else {
                $response = array("message" => "Fel vid lagring av förrätt");
                http_response_code(500); //Internal server error
            }
        } else {
            $response = array("message" => "Skicka med ...");
            http_response_code(400); //Bad request
        }
        
        break;
    case 'PUT':
        //Loads JSON data sent with the call and converts to an object
        $data = json_decode(file_get_contents("php://input"), true);

        //Update starter
        if($starter->updateStarter($data["starterid"], $data["name"], $data["price"], $data["description"])) {
        $response = array("message" => "Förrätt uppdaterad");
        http_response_code(200); //OK
        } else {
            http_response_code(500); //Internal server error
            $response = array("message" => "Fel vid uppdatering av förrätt");
        }


        break;
    case 'DELETE':
        if(!isset($id)) { //If id is not set, set message
            http_response_code(400); //Bad request
            $response = array("message" => "Skicka med id");  
        } else {
            if($starter->deleteStarter($id)) { //Else, delete pasta
                http_response_code(200); //OK
                $response = array("message" => "Förrätt raderad"); 
            }
        }
        break;
        
}

//Sends a reply back to the sender
echo json_encode($response);
?>
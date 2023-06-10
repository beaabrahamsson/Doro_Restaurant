<?php
/*
 * @Author: Beatrice Abrahamsson
 * @Email: beaabrahamsson6@gmail.com
 * @Date: 2022-05-12 21:14:59
 * @Last Modified by: Beatrice Abrahamsson
 * @Last Modified time: 2022-05-26 14:23:19
 * @Description: Description
 */

//includes
include("classes/Dessert.class.php");
include("includes/headers.php");

//If a parameter of id is present in the url, it is stored in a variable
if(isset($_GET['id'])) {
    $id = $_GET['id'];
}

//creating object ($dessert) from the class Dessert
$dessert = new Dessert();

switch($method) {
    case 'GET':
        if(isset($id)) {
            $response = $dessert->getDessertById($id); //If id is set, get desserts by id
        } else {
            $response = $dessert->getDesserts(); //Else, get all desserts
        }

        //If no elements in array, set message
        if(count($response) === 0) {
            $response = array("message" => "Inga desserter i databasen");
            http_response_code(404); //Not found
        } else {
            http_response_code(200); //Ok - The request has succeeded
        }

        break;
    case 'POST':
        //Loads JSON data sent with the call and converts to an object.
        $data = json_decode(file_get_contents("php://input"), true);

        //Create dessert
        if($dessert->setDessert($data["name"], $data["price"], $data["description"])) {
            if($dessert->createDessert($data["name"], $data["price"], $data["description"])) {
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

        //Update dessert
        if($dessert->updateDessert($data["dessertid"], $data["name"], $data["price"], $data["description"])) {
        $response = array("message" => "Dessert uppdaterad");
        http_response_code(200); //OK
        } else {
            http_response_code(500); //Internal server error
            $response = array("message" => "Fel vid uppdatering av Dessert");
        }


        break;
    case 'DELETE':
        if(!isset($id)) { //If id is not set, set message
            http_response_code(400); //Bad request
            $response = array("message" => "Skicka med id"); 
        } else {
            if($dessert->deleteDessert($id)) { //Else, delete dessert
                http_response_code(200); //OK
                $response = array("message" => "Dessert raderad"); 
            }
        }
        break;
        
}

//Sends a reply back to the sender
echo json_encode($response);
?>
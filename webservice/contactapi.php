<?php
/*
 * @Author: Beatrice Abrahamsson
 * @Email: beaabrahamsson@hotmail.com
 * @Date: 2022-05-26 14:23:09
 * @Last Modified by:   Beatrice Abrahamsson
 * @Last Modified time: 2022-05-26 14:23:09
 * @Description: Description
 */

//includes
include("classes/Contact.class.php");
include("includes/headers.php");

//If a parameter of id is present in the url, it is stored in a variable
if(isset($_GET['id'])) {
    $id = $_GET['id'];
}

//creating object ($contact) from the class Contact
$contact = new Contact();

switch($method) {
    case 'GET':
        //If id is set, get messages by id
        if(isset($id)) {
            $response = $contact->getContactById($id);
        } else {
            //Else, get all messages
            $response = $contact->getContacts();
        }

        //If no elements in array, set message
        if(count($response) === 0) {
            $response = array("message" => "Inga meddelanden i databasen");
            http_response_code(404); //Not found
        } else {
            http_response_code(200); //Ok - The request has succeeded
        }

        break;
    case 'POST':
        //Loads JSON data sent with the call and converts to an object.
        $data = json_decode(file_get_contents("php://input"), true);

        //Create message
        if($contact->setContact($data["fname"], $data["lname"], $data["phone"], $data["email"], $data["message"])) {
            if($contact->createContact($data["fname"], $data["lname"], $data["phone"], $data["email"], $data["message"])) {
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

        //Update message
        if($contact->updateContact($data["contactid"], $data["fname"], $data["lname"], $data["phone"], $data["email"], $data["message"])) {
        $response = array("message" => "Meddelande uppdaterad");
        http_response_code(200); //OK
        } else {
            http_response_code(500); //Internal server error
            $response = array("message" => "Fel vid uppdatering av meddelande");
        }


        break;
    case 'DELETE':
        if(!isset($id)) { //If id is not set, set message
            http_response_code(400); //Bad request
            $response = array("message" => "Skicka med id");  
        } else {
            if($contact->deleteContact($id)) { //Else, delete message
                http_response_code(200); //OK
                $response = array("message" => "Meddelande raderad"); 
            }
        }
        break;
        
}

//Sends a reply back to the sender
echo json_encode($response);
?>
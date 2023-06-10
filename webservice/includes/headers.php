<?php
/*
 * @Author: Beatrice Abrahamsson
 * @Email: beaabrahamsson6@gmail.com
 * @Date: 2022-05-12 15:12:06
 * @Last Modified by: Beatrice Abrahamsson
 * @Last Modified time: 2022-05-26 14:22:46
 * @Description: Description
 */


/*Headers with settings for REST web service*/

//Makes the web service accessible from all domains
header('Access-Control-Allow-Origin: *');

//Indicates that the web service sends data in JSON format
header('Content-Type: application/json');

//Which methods the web service accepts, by default only GET is allowed.
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE');

//Which headers are allowed for calls from the client side, can be a problem with CORS (Cross-Origin Resource Sharing) without this.
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

//Loads the method sent and stores it in a variable
$method = $_SERVER['REQUEST_METHOD'];

?>
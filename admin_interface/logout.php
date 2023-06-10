<?php
/*
 * @Author: Beatrice Abrahamsson
 * @Email: beaabrahamsson@hotmail.com
 * @Date: 2022-05-25 16:48:58
 * @Last Modified by:   Beatrice Abrahamsson
 * @Last Modified time: 2022-05-25 16:48:58
 * @Description: Description
 */


//Include config.php
include("includes/config.php");

//start session
session_start();
//destroy session
session_unset();
session_destroy();

//Go to index.php
header("Location: index.php?message=Du är nu utloggad!");
exit();
?>
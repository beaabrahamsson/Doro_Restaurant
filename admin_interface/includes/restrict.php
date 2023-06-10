<?php
/*
 * @Author: Beatrice Abrahamsson
 * @Email: beaabrahamsson@hotmail.com
 * @Date: 2022-05-23 21:07:49
 * @Last Modified by:   Beatrice Abrahamsson
 * @Last Modified time: 2022-05-23 21:07:49
 * @Description: Description
 */

//includes
include("includes/classes/User.class.php");

//create object ($user) from the class User
$user = new User();
//Call method to restrict page
$user->restrictPage();
?>
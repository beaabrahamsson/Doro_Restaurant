
<?php
/*
 * @Author: Beatrice Abrahamsson
 * @Email: beaabrahamsson6@gmail.com
 * @Date: 2022-05-14 09:28:08
 * @Last Modified by: Beatrice Abrahamsson
 * @Last Modified time: 2022-05-27 17:54:49
 * @Description: Description
 */

//includes
include("includes/config.php");

?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title><?= $site_title . $divider . $page_title ?></title>
</head>
<body>
    <header>
        <div class="navbar">
            <a id="logo" href="index.php">Startsida</a>
            <div class="dropdown">
                <a href="" class="dropbtn">Lägg till rätt</a>
                <div class="dropdown-content">
                    <a href="newstarter.php">Förrätt</a>
                    <a href="newpasta.php">Pastarätt</a>
                    <a href="newmain.php">Huvudrätt</a>
                    <a href="newdessert.php">Efterrätt</a>
                </div>
            </div>
            <div class="dropdown">
                <a href="" class="dropbtn">Bordbokningar</a>
                <div class="dropdown-content">
                    <a href="bookings.php">Aktuella</a><br>
                    <a href="archive.php">Arkiv</a>
                </div>
            </div>
                <a href="messages.php">Meddelanden</a>
                <a href="menu.php">Aktuell meny</a>
                <a href="reviews.php">Omdömen</a>
            <div id="loginLink">
                <?php
                //If user is not logged in, show log in link
                if(!isset($_SESSION['uname'])) {
                    echo "<a href='login.php'>Logga in</a>";
                } else {
                    //Else, show logout link
                    echo "<a href='logout.php'>Logga ut</a>";
                }
                ?> 
            </div>
        </div>
        <!-- Top Navigation Menu -->
        <div class="mobilemenu">
            <a href="index.php" class="active">Aministration för D'oro</a>
            <!-- Navigation links (hidden by default) -->
            <div id="links">
                <a id="index" href="index.php">Startsida</a>
                <a href="bookings.php">Bordbokningar</a>
                <a href="messages.php">Meddelanden</a>
                <a href="menu.php">Aktuell meny</a>
                <a href="reviews.php">Omdömen</a>
                <a href="newstarter.php">Lägg till förrätt</a>
                <a href="newpasta.php">Lägg till pastarätt</a>
                <a href="newmain.php">Lägg till huvudrätt</a>
                <a href="newdessert.php">Lägg till efterrätt</a>
                <a href="archive.php">Arkiverade bokningar</a>
                <?php
                if(!isset($_SESSION['uname'])) {
                    echo "<a href='login.php'>Logga in</a>";
                } else {
                    echo "<a href='logout.php'>Logga ut</a>";
                }
                ?> 
            </div>
            <!-- "Hamburger menu" / "Bar icon" to toggle the navigation links -->
            <a href="javascript:void(0);" class="icon" onclick="mobileMenu()">
            <i class="fa fa-bars"></i>
            </a>
        </div>
        <div id="welcome">
            <h1>Administration för restaurang D'oro</h1>
        </div>
        <?php
        //If error is set, show error message
        if(isset($_GET['error'])) {
            echo "<p class='error'>" . $_GET['error'] . "</p>";
        }
        //If message is set, show message
        if(isset($_GET['message'])) {
            echo "<p class='message'>" . $_GET['message'] . "</p>";
        }
        ?>
</header>
        <main>
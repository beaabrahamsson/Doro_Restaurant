<?php
/*
 * @Author: Beatrice Abrahamsson
 * @Email: beaabrahamsson@hotmail.com
 * @Date: 2022-05-21 21:24:05
 * @Last Modified by: Beatrice Abrahamsson
 * @Last Modified time: 2022-05-25 16:51:42
 * @Description: Description
 */

//set page title
$page_title = "Meddelande";
//include header
include("includes/header.php");
include("includes/restrict.php");
?>
            <div class="blogpost">
                <h2>Meddelande: <?php echo $_GET['id'] ?></h2>
                <?php

                //GET request
                $url = 'https://studenter.miun.se/~beab2100/writeable/dt173g/Projekt/Webbtjanst/contactapi.php';

                $curl = curl_init();

                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                $data = json_decode(curl_exec($curl), true);
                $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                curl_close($curl);

                foreach($data as $c) {
                    //If id is set and contactid and id is the same, print message
                    if(isset($_GET['id']) && $c['contactid'] == $_GET['id']) {
                        echo "<div class='post'> <h3 class='title'>" . $c['fname'] . "&nbsp;" . $c['lname'] . "</h3>";
                        echo "<p class='italics'>Telefon: " . $c['phone'] . "</p>";
                        echo "<p class='italics'>Email: " . $c['email'] . "</p>";
                        echo "<p class='italics'>Meddelande: " . $c['message'] . "</p>";
                        echo "<a href='messages.php?deleteid=" . $c['contactid'] . "'>Ta bort</a></div><br></div>";
                    }
                }
?>
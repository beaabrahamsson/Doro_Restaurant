<?php
/*
 * @Author: Beatrice Abrahamsson
 * @Email: beaabrahamsson6@gmail.com
 * @Date: 2022-05-14 12:26:54
 * @Last Modified by: Beatrice Abrahamsson
 * @Last Modified time: 2022-05-26 16:41:38
 * @Description: Description
 */

//set page title
$page_title = "Meny";
//includes
include("includes/header.php");
include("includes/restrict.php");
?>
<div class="blogpost">
                <h2>Aktuella förrätter</h2>
                <?php
                //set urls
                $starterurl = 'https://studenter.miun.se/~beab2100/writeable/dt173g/Projekt/Webbtjanst/starterapi.php';
                $pastaurl = 'https://studenter.miun.se/~beab2100/writeable/dt173g/Projekt/Webbtjanst/pastaapi.php';
                $mainurl = 'https://studenter.miun.se/~beab2100/writeable/dt173g/Projekt/Webbtjanst/mainapi.php';
                $desserturl = 'https://studenter.miun.se/~beab2100/writeable/dt173g/Projekt/Webbtjanst/dessertapi.php';


                //GET request for starter
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $starterurl);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                $data = json_decode(curl_exec($curl), true);
                $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                curl_close($curl);

                foreach($data as $c) {
                    //Check if message exists in array
                    if(array_key_exists("message", $data)) {
                        //Print that no starters exists
                        echo "<p>Inga förrätter är lagrade!</p>";
                    } else {
                        //Else, print starters
                        echo "<div class='post'> <h3><a class='title' href='starter.php?id=" . $c['starterid'] . "'>" . $c['name'] . "</a></h3>";
                        echo "<p>Pris: " . $c['price'] . "</p>";
                        echo "<p>Beskrivning: " . $c['description'] . "</p>";
                        echo "<div class='editButtons'><a href='starter.php?id=" . $c['starterid'] . "'>Ändra</a><br>";
                        echo "<a href='starter.php?deleteid=" . $c['starterid'] . "'>Ta bort</a></div></div>";
                    }
                    
                }

        ?></div>
        <div class="blogpost">
                <h2>Aktuella pastarätter</h2>
                <?php

                //GET request for pasta
                $curl = curl_init();

                curl_setopt($curl, CURLOPT_URL, $pastaurl);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                $data = json_decode(curl_exec($curl), true);
                $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                curl_close($curl);

                foreach($data as $c) {
                    //Check if message exists in array
                    if(array_key_exists("message", $data)) {
                        //Print that no pastas exists
                        echo "<p>Inga pastarätter är lagrade!</p>";
                    } else {
                        //Else, print pastas
                        echo "<div class='post'> <h3><a class='title' href='pasta.php?id=" . $c['pastaid'] . "'>" . $c['name'] . "</a></h3>";
                        echo "<p>Pris: " . $c['price'] . "</p>";
                        echo "<p>Beskrivning: " . $c['description'] . "</p>";
                        echo "<div class='editButtons'><a href='pasta.php?id=" . $c['pastaid'] . "'>Ändra</a><br>";
                        echo "<a href='pasta.php?deleteid=" . $c['pastaid'] . "'>Ta bort</a></div></div>";
                    }
                }

            ?></div>
            <div class="blogpost">
                <h2>Aktuella huvudrätter</h2>
                <?php

                //GET request for main courses
                $curl = curl_init();

                curl_setopt($curl, CURLOPT_URL, $mainurl);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                $data = json_decode(curl_exec($curl), true);
                $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                curl_close($curl);

                foreach($data as $c) {
                    //Check if message exists in array
                    if(array_key_exists("message", $data)) {
                        //Print that no mains exists
                        echo "<p>Inga huvudrätter är lagrade!</p>";
                    } else {
                        //Else, print mains
                        echo "<div class='post'> <h3><a class='title' href='maincourse.php?id=" . $c['mainid'] . "'>" . $c['name'] . "</a></h3>";
                        echo "<p>Pris: " . $c['price'] . "</p>";
                        echo "<p>Beskrivning: " . $c['description'] . "</p>";
                        echo "<div class='editButtons'><a href='maincourse.php?id=" . $c['mainid'] . "'>Ändra</a><br>";
                        echo "<a href='maincourse.php?deleteid=" . $c['mainid'] . "'>Ta bort</a></div></div>";
                    }
                }

            ?></div>
            <div class="blogpost">
                <h2>Aktuella efterrätter</h2>
                <?php

                //GET request for desserts
                $curl = curl_init();

                curl_setopt($curl, CURLOPT_URL, $desserturl);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                $data = json_decode(curl_exec($curl), true);
                $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                curl_close($curl);

                foreach($data as $c) {
                    //Check if message exists in array
                    if(array_key_exists("message", $data)) {
                        //Print that no desserts exists
                        echo "<p>Inga efterätter är lagrade!</p>";
                    } else {
                        //Else, print desserts
                        echo "<div class='post'> <h3><a class='title' href='dessert.php?id=" . $c['dessertid'] . "'>" . $c['name'] . "</a></h3>";
                        echo "<p>Pris: " . $c['price'] . "</p>";
                        echo "<p>Beskrivning: " . $c['description'] . "</p>";
                        echo "<div class='editButtons'><a href='dessert.php?id=" . $c['dessertid'] . "'>Ändra</a><br>";
                        echo "<a href='dessert.php?deleteid=" . $c['dessertid'] . "'>Ta bort</a></div></div>";
                    }
                }
                ?>
        </div>
    <?php
    //include footer
    include("includes/footer.php");
    ?>
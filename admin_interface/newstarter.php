<?php
/*
 * @Author: Beatrice Abrahamsson
 * @Email: beaabrahamsson@hotmail.com
 * @Date: 2022-05-23 17:41:38
 * @Last Modified by: Beatrice Abrahamsson
 * @Last Modified time: 2022-05-26 16:43:10
 * @Description: Description
 */

//set page title
$page_title = "Lägg till förrätt";
//includes
include("includes/header.php");
include("includes/restrict.php");
?>
                <div class="blogpost">
                <h2>Lägg till förrätt:</h2>
                <?php

                //POST request
                $url = 'https://studenter.miun.se/~beab2100/writeable/dt173g/Projekt/Webbtjanst/starterapi.php';

                    $ch = curl_init();

                    //If form is filled and submitted
                    if (isset($_POST['submit'])) {
                        $name = $_POST['name'];
                        $price = $_POST['price'];
                        $description = $_POST['desc'];

                        //Check so name, price and description is not empty
                        if (!empty($name) || !empty($price) || !empty($description)) {

                            $form_data = array (
                                "name" => $name,
                                "price" => $price,
                                "description" => $description,
                            );

                            $json_string = json_encode($form_data);

                            curl_setopt($ch, CURLOPT_URL, $url);
                            curl_setopt($ch, CURLOPT_POST, TRUE);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $json_string);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                            $output = json_decode(curl_exec($ch), true);
                            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                            curl_close($curl);

                            if($httpcode === 201) {
                                header("Location: menu.php?message=Förrätt tillagd!");
                    
                            } else {
                                header("Location: menu.php?error=Fel vid lagring av förrätt!");
                            }
                        }
                    }
                    
                    ?><!--Form to add starter-->
                    <div id="starterMessage"></div>
                    <div class="form-container">
                        <form name="newStarter" method="post" onsubmit="return validateNewStarter()">
                            <label for="name">Namn:</label><br>
                            <input type="text" name="name" id="name"><br>
                            <label for="price">Pris:</label><br>
                            <input type="text" name="price" id="price"><br>
                            <label for="desc">Beskrivning:</label><br>
                            <textarea id="desc" name="desc" cols="40" rows="5"></textarea>
                            <input type="submit" name="submit" value="Lägg till förrätt">
                        </form>
                    </div>
                    <?php
                ?>
        </div>
    <?php
    //include footer
    include("includes/footer.php");
    ?>
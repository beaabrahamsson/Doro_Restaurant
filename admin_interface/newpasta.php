<?php
/*
 * @Author: Beatrice Abrahamsson
 * @Email: beaabrahamsson@hotmail.com
 * @Date: 2022-05-23 17:33:07
 * @Last Modified by: Beatrice Abrahamsson
 * @Last Modified time: 2022-05-26 16:43:59
 * @Description: Description
 */

//set page title
$page_title = "Lägg till pastarätt";
//includes
include("includes/header.php");
include("includes/restrict.php");
?>
                <div class="blogpost">
                <h2>Lägg till pastarätt:</h2>
                <?php

                //POST request
                $url = 'https://studenter.miun.se/~beab2100/writeable/dt173g/Projekt/Webbtjanst/pastaapi.php';

                    $ch = curl_init();

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
                                header("Location: menu.php?message=Pastarätt tillagd!");
                    
                            } else {
                                header("Location: menu.php?error=Fel vid lagring av pastarätt!");
                            }
                        }
                    }
                    
                    ?><!--Form to add pasta-->
                    <div id="pastaMessage"></div>
                    <div class="form-container">
                        <form name="newPasta" method="post" onsubmit="return validateNewPasta()">
                            <label for="name">Namn:</label><br>
                            <input type="text" name="name" id="name"><br>
                            <label for="price">Pris:</label><br>
                            <input type="text" name="price" id="price"><br>
                            <label for="desc">Beskrivning:</label><br>
                            <textarea id="desc" name="desc" cols="40" rows="5"></textarea>
                            <input type="submit" name="submit" value="Lägg till pastarätt">
                        </form>
                    </div>
                    <?php
                    
                
                ?>
        </div>
    <?php
    //include footer
    include("includes/footer.php");
    ?>
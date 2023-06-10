<?php
/*
 * @Author: Beatrice Abrahamsson
 * @Email: beaabrahamsson@hotmail.com
 * @Date: 2022-05-23 17:04:26
 * @Last Modified by: Beatrice Abrahamsson
 * @Last Modified time: 2022-05-26 14:07:26
 * @Description: Description
 */

//set page title
$page_title = "Ändra huvudrätt";
//includes
include("includes/header.php");
include("includes/restrict.php");
include("includes/classes/Main.class.php")
?>

        <div class="blogpost">
        <?php
                //creating object from the class Main
                $main = new Main();
                //Calling method to delete 
                $delete = $main->deleteMain();

                //GET request
                $url = 'https://studenter.miun.se/~beab2100/writeable/dt173g/Projekt/Webbtjanst/mainapi.php';

                // Create a curl handle
                $curl = curl_init();
                //cURL settings
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                $data = json_decode(curl_exec($curl), true);
                $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                curl_close($curl);

                //If id is set and dessertid and id is the same, print dessert
                foreach($data as $c) {
                    if(isset($_GET['id']) && $c['mainid'] == $_GET['id']) {
                        echo "<h2>Huvudrätt: " . $_GET['id'] . "</h2>";
                        echo "<p>Namn: " . $c['name'] . "</p>";
                        echo "<p>Pris:" . $c['price'] . "</p>";
                        echo "<p>Beskrivning: " . $c['description'] . "</p>";
                        echo "<a href='maincourse.php?deleteid=" . $c['mainid'] . "'>Ta bort</a><br></div>";
                    }

                    //PUT request
                    if(isset($_GET['id']) && $c['mainid']==$_GET['id']) {

                    $ch = curl_init();

                    if (isset($_POST['submit'])) {
                        $name = $_POST['name'];
                        $price = $_POST['price'];
                        $description = $_POST['desc'];
                        $id = $_GET['id'];

                        //Check so name, price, description and id is not empty
                        if (!empty($name) || !empty($price) || !empty($description) || !empty($id)) {

                            $form_data = array (
                                "mainid" => $id,
                                "name" => $name,
                                "price" => $price,
                                "description" => $description,
                            );

                            $json_string = json_encode($form_data);

                            //settings for cURL
                            curl_setopt($ch, CURLOPT_URL, $url);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $json_string);

                            $output = json_decode(curl_exec($curl), true);
                            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                            curl_close($curl);

                            if($httpcode === 200) {
                                header("Location: menu.php?message=Huvudrätt uppdaterad!");
                    
                            } else {
                                header("Location: menu.php?error=Fel vid uppdatering av huvudrätt!");
                            }
                        }
                    }
                    ?><!--Form to edit main course-->
                    <div id="mainMessage"></div>
                    <div class="form-container">
                        <form name="newMain" method="post" onsubmit="return validateNewMain()">
                            <h3>Uppdatera huvudrätt: <?= $c['mainid']; ?></h3>
                            <label for="name">Namn:</label><br>
                            <input type="text" name="name" id="name" value="<?= $c['name']; ?>"><br>
                            <label for="price">Pris:</label><br>
                            <input type="text" name="price" id="price" value="<?= $c['price']; ?>"><br>
                            <label for="desc">Beskrivning:</label><br>
                            <textarea id="desc" name="desc" cols="40" rows="5"><?= $c['description']; ?></textarea>
                            <input type="submit" name="submit" value="submit">
                        </form>
                    </div>
                    <?php
                    }
                }
                ?>
    <?php
    //include footer
    include("includes/footer.php");
    ?>
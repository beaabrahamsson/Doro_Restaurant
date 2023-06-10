<?php
/*
 * @Author: Beatrice Abrahamsson
 * @Email: beaabrahamsson@hotmail.com
 * @Date: 2022-05-23 17:41:24
 * @Last Modified by: Beatrice Abrahamsson
 * @Last Modified time: 2022-05-26 14:05:51
 * @Description: Description
 */

//set page title
$page_title = "Ändra pastarätt";
//includes
include("includes/header.php");
include("includes/restrict.php");
include("includes/classes/Pasta.class.php")
?>

        <div class="blogpost">
        <?php
                //creating object from the class Pasta
                $pasta = new Pasta();
                //Calling method to delete 
                $delete = $pasta->deletePasta();

                //GET request
                $url = 'https://studenter.miun.se/~beab2100/writeable/dt173g/Projekt/Webbtjanst/pastaapi.php';

                // Create a curl handle
                $curl = curl_init();

                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                //lagrar resultatet i en variabel och gör om resultatet från JSON
                $data = json_decode(curl_exec($curl), true);
                $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                curl_close($curl);

                //Print pasta
                foreach($data as $c) {
                    if(isset($_GET['id']) && $c['pastaid'] == $_GET['id']) {
                        echo "<h2>Pastarätt: " . $_GET['id'] . "</h2>";
                        echo "<p>Namn: " . $c['name'] . "</p>";
                        echo "<p>Pris:" . $c['price'] . "</p>";
                        echo "<p>Beskrivning: " . $c['description'] . "</p>";
                        echo "<a href='pasta.php?deleteid=" . $c['pastaid'] . "'>Ta bort</a><br></div>";
                    }

                    //PUT request
                    if(isset($_GET['id']) && $c['pastaid']==$_GET['id']) {

                        $ch = curl_init();

                        if (isset($_POST['submit'])) {
                            $name = $_POST['name'];
                            $price = $_POST['price'];
                            $description = $_POST['desc'];
                            $id = $_GET['id'];

                            //Check so name, price, description and id is not empty
                            if (!empty($name) || !empty($price) || !empty($description) || !empty($id)) {

                                $form_data = array (
                                    "pastaid" => $id,
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

                                //lagrar datat i en variabel och gör om resultatet från JSON
                                $output = json_decode(curl_exec($curl), true);
                                $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                                curl_close($curl);
                                if($httpcode === 200) {
                                    header("Location: menu.php?message=Pastarätt uppdaterad!");
                        
                                } else {
                                    header("Location: menu.php?error=Fel vid uppdatering av pastarätt!");
                                }
                            }
                        }
                        
                            ?><!--Form to edit pasta-->
                            <div id="pastaMessage"></div>
                            <div class="form-container">
                                <form name="newPasta" method="post" onsubmit="return validateNewPasta()">
                                    <h3>Uppdatera förrätt: <?= $c['pastaid']; ?></h3>
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
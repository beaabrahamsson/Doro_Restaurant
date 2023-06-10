<?php


//set page title
$page_title = "Startsida";
//include header
include("includes/header.php");
include("includes/restrict.php");
include("includes/classes/Dessert.class.php")
?>
            <div class="blogpost">
                <?php
                //creating object from the class Dessert
                $dessert = new Dessert();
                //Calling method to delete 
                $delete = $dessert->deleteDessert();

                //GET request
                $url = 'https://studenter.miun.se/~beab2100/writeable/dt173g/Projekt/Webbtjanst/dessertapi.php';

                // Create a curl handle
                $curl = curl_init();
                //Curl settings
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                //Takes JSON encoded string and converts it into a PHP variable
                $data = json_decode(curl_exec($curl), true);

                $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                curl_close($curl);

                //If id is set and dessertid and id is the same, print dessert
                foreach($data as $c) {
                    if(isset($_GET['id']) && $c['dessertid'] == $_GET['id']) {
                        echo "<h2>Efterätt: " . $_GET['id'] . "</h2>";
                        echo "<p>Namn: " . $c['name'] . "</p>";
                        echo "<p>Pris:" . $c['price'] . "</p>";
                        echo "<p>Beskrivning: " . $c['description'] . "</p>";
                        echo "<a href='dessert.php?deleteid=" . $c['dessertid'] . "'>Ta bort</a><br></div>";
                    }

                    //PUT request
                    if(isset($_GET['id']) && $c['dessertid']==$_GET['id']) {  //If id is set and dessertid and id is the same
                        // Create a curl handle
                        $ch = curl_init();
                        //set variables
                        if (isset($_POST['submit'])) {
                            $name = $_POST['name'];
                            $price = $_POST['price'];
                            $description = $_POST['desc'];
                            $id = $_GET['id'];

                            //Check so name, price, description and id is not empty
                            if (!empty($name) || !empty($price) || !empty($description) || !empty($id)) {

                                //Form data
                                $form_data = array (
                                    "dessertid" => $id,
                                    "name" => $name,
                                    "price" => $price,
                                    "description" => $description,
                                );
                                //Cconverts into a PHP variable
                                $json_string = json_encode($form_data);

                                //cURL settings
                                curl_setopt($ch, CURLOPT_URL, $url);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $json_string);

                                $output = json_decode(curl_exec($ch), true);
                                $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                                curl_close($ch);
                                //Send to menu.php and set message
                                if($httpcode === 200) {
                                    header("Location: menu.php?message=Efterätt uppdaterad!");
                        
                                } else {
                                    header("Location: menu.php?error=Fel vid uppdatering av efterätt!");
                                }
                            }
                        }
                        
                        ?><!--Form to edit post-->
                        <div id="dessertMessage"></div>
                        <div class="form-container">
                            <form name="newDessert" method="post" onsubmit="return validateNewDessert()">
                                <h3>Uppdatera förrätt: <?= $c['dessertid']; ?></h3>
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
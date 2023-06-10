<?php
/*
 * @Author: Beatrice Abrahamsson
 * @Email: beaabrahamsson6@gmail.com
 * @Date: 2022-05-14 09:33:33
 * @Last Modified by: Beatrice Abrahamsson
 * @Last Modified time: 2022-05-26 14:18:02
 * @Description: Description
 */

//set page title
$page_title = "Startsida";
//include header
include("includes/header.php");
include("includes/restrict.php");
?>
<div class="blogpost">
                <h2>Bokning: <?php echo $_GET['id'] ?></h2>
                <?php
                if (isset($errormsg)) {
                    echo $errormsg;
                }
                ?>
                <?php

                //GET request
                $url = 'https://studenter.miun.se/~beab2100/writeable/dt173g/Projekt/Webbtjanst/bookingapi.php';

                $curl = curl_init(); // Create a curl handle
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $data = json_decode(curl_exec($curl),true);
                curl_close($curl);

                //If id is set and bookingid and id is the same, print booking details
                foreach($data as $c) {
                    if(isset($_GET['id']) && $c['bookingid'] == $_GET['id']) {
                        echo "<div class='post'> <h3><a class='title' href='details.php?id=" . $c['bookingid'] . "'>" . $c['fname'] . "&nbsp;" . $c['lname'] . "</a></h3>";
                        echo "<p>Datum och tid: " . $c['date'] . ",&nbsp;" . $c['time'] . "</p>";
                        echo "<p>Telefon:" . $c['phone'] . "</p>";
                        echo "<p>Email: " . $c['email'] . "</p>";
                        echo "<p>Antal gäster: " . $c['guests'] . "</p>";
                        echo "<p>Meddelande: " . $c['note'] . "</p>";
                        echo "<a href='admin.php?deleteid=" . $c['bookingid'] . "'>Ta bort</a></div><br></div>";
                    }

                    //PUT request
                    if(isset($_GET['id']) && $c['bookingid']==$_GET['id']) {

                    $ch = curl_init(); // Create a curl handle
                    //Set variables
                    if (isset($_POST['submit'])) {
                        $fname = $_POST['fname'];
                        $lname = $_POST['lname'];
                        $phone = $_POST['phone'];
                        $email = $_POST['email'];
                        $date = $_POST['date'];
                        $time = $_POST['time'];
                        $guests = $_POST['guests'];
                        $note = $_POST['note'];
                        $id = $_GET['id'];

                        //Check so name, price, description and id is not empty
                        if (empty($fname) || empty($lname) || empty($phone) || empty($email) || empty($date) || empty($time) || empty($guests) || empty($note) || empty($id)) {
                            $errormsg = "<p class='error'><strong>Fyll i alla fält!</strong></p>";
                        } else {

                            //Form data
                            $form_data = array (
                                "bookingid" => $id,
                                "fname" => $fname,
                                "lname" => $lname,
                                "phone" => $phone,
                                "email" => $email,
                                "date" => $date,
                                "time" => $time,
                                "guests" => $guests,
                                "note" => $note
                            );
                            //Cconverts into a PHP variable
                            $json_string = json_encode($form_data);

                            //cURL settings
                            curl_setopt($ch, CURLOPT_URL, $url);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $json_string);

                            //Takes JSON encoded string and converts it into a PHP variable
                            $output = json_decode(curl_exec($ch), true);
                            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                            curl_close($ch);

                            //Refresh page Nd set message
                            if($httpcode === 200) {
                                header("Location: details.php?id=" . $c['bookingid'] . "&&message=Bokning uppdaterad!");
                    
                            } else {
                                header("Location: details.php?id=" . $c['bookingid'] . "&&error=Fel vid uppdatering av bokning!");
                            }
                        }
                    }
                    ?><!--Form to edit post-->
                    <div class="form-container">
                        <form method="post" action>
                            <h3>Uppdatera bokning: <?= $c['bookingid']; ?></h3>
                            <p>Bokat av: <?= $c['fname'] . $c['lname']; ?> för <?= $c['date']; ?></p>
                            <label for="fname">Förnamn:</label><br>
                            <input type="text" name="fname" id="fname" value="<?= $c['fname']; ?>"><br>
                            <label for="lname">Efternamn:</label><br>
                            <input type="text" name="lname" id="lname" value="<?= $c['lname']; ?>"><br>
                            <label for="phone">Telefon:</label><br>
                            <input type="text" name="phone" id="phone" value="<?= $c['phone']; ?>"><br>
                            <label for="email">Mejl:</label><br>
                            <input type="email" name="email" id="email" value="<?= $c['email']; ?>"><br>
                            <label for="date">Datum:</label><br>
                            <input type="date" name="date" id="date" value="<?= $c['date']; ?>"><br>
                            <label for="time">Tid:</label><br>
                            <select name="time" id="time" value="<?= $c['time']; ?>"><br>
                                <option value="17:00">17:00</option>
                                <option value="17:30">17:30</option>
                                <option value="18:00">18:00</option>
                                <option value="18:30">18:30</option>
                                <option value="19:00">19:00</option>
                                <option value="19:30">19:30</option>
                                <option value="20:00">20:00</option>
                                <option value="20:30">20:30</option>
                                <option value="21:00">21:00</option>
                                <option value="21:30">21:30</option>
                                <option value="22:00">22:00</option>
                              </select>
                            <label for="guests">Antal gäster:</label><br>
                            <input type="number" name="guests" id="guests" value="<?= $c['guests']; ?>"><br>
                            <label for="note">Meddelande:</label><br>
                            <textarea id="note" name="note" cols="40" rows="5"><?= $c['note']; ?></textarea>
                            <input type="submit" name="submit" value="submit">
                        </form>
                    </div>
                    <?php
                    }
                }
                ?>
            </div>
        </div>
    <?php
    //include footer
    include("includes/footer.php");
    ?>
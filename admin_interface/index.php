<?php
/*
 * @Author: Beatrice Abrahamsson
 * @Email: beaabrahamsson6@gmail.com
 * @Date: 2022-05-14 09:33:33
 * @Last Modified by: Beatrice Abrahamsson
 * @Last Modified time: 2022-05-26 16:34:47
 * @Description: Description
 */

//include classes

//set page title
$page_title = "Startsida";
//includes
include("includes/header.php");
include("includes/restrict.php");
?>

        <div class="table">
                <h2>Senaste bokningarna</h2>
                <?php

                //GET request
                $url = 'https://studenter.miun.se/~beab2100/writeable/dt173g/Projekt/Webbtjanst/bookingapi.php';

                //New cURL session
                $curl = curl_init();
                //cURL settings
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                //Takes JSON encoded string and converts it into a PHP variable
                $data = json_decode(curl_exec($curl),true);

                //Use function array_slice to only get first 10 rows
                $slicedData = array_slice($data, 0, 10);

                $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                
                //Close cURL session
                curl_close($curl);

                //Get date 
                $date = date("Y-m-d");

                ?>

                <table>
                    <tr>
                        <th>Namn</th>
                        <th>Datum och tid</th>
                        <th>Telefon</th>
                        <th>E-post</th>
                        <th>Antal gäster</th>
                        <th>Meddelande</th>
                        <th>Ändra</th>
                        <th>Ta bort</th>
                    </tr>
                        <?php foreach ($slicedData as $c){ 
                            //Check if message exists in array
                            if(array_key_exists("message", $data)) {
                            //Print that no desserts exists
                                echo "<p class='error'>Det finns inga bokningar att visa!</p>";
                            } else {
                                if ($date < $c['date']) { ?>
                                <tr><td> <?php echo "<a class='title' href='details.php?id=" . $c['bookingid'] . "'>" . $c['fname'] . "&nbsp;" . $c['lname'] . "</a></td>" ?>
                                <td> <?php echo $c['date'] . ",&nbsp;" . $c['time'] . "</td>" ?>
                                <td> <?php echo $c['phone']; ?> </td>
                                <td> <?php echo $c['email']; ?> </td>
                                <td> <?php echo $c['guests']; ?> </td>
                                <td> <?php echo substr($c['note'], 0, 30) . "..."; ?> </td>
                                <td> <?php echo "<a href='details.php?id=" . $c['bookingid'] . "'>Ändra</a></td>" ?>
                                <td> <?php echo "<a href='bookings.php?deleteid=" . $c['bookingid'] . "'>Ta bort</a></td>" ?> 
                            </tr>
                        <?php } 
                        }
                    }?>
                </table>
        </div>
    <?php
    //include footer
    include("includes/footer.php");
    ?>
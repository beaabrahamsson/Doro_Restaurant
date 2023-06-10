<?php
/*
 * @Author: Beatrice Abrahamsson
 * @Email: beaabrahamsson6@gmail.com
 * @Date: 2022-05-14 09:33:33
 * @Last Modified by: Beatrice Abrahamsson
 * @Last Modified time: 2022-05-26 16:35:50
 * @Description: Description
 */
//set page title
$page_title = "Bokningar";
//includes
include("includes/header.php");
include("includes/restrict.php");
?>
            <div class="table">
                <h2>Alla bokningar</h2>
                <?php
                //DELETE request
                //If deleteid is set, delete 
                if(isset($_GET['deleteid'])) {
                    $deleteurl = 'https://studenter.miun.se/~beab2100/writeable/dt173g/Projekt/Webbtjanst/bookingapi.php?id='.$_GET['deleteid'];
                
                // Create a curl handle
                $ch = curl_init();
                //Curl settings
                curl_setopt($ch, CURLOPT_URL, $deleteurl);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $data = json_decode(curl_exec($ch), true);
                $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            
                curl_close($ch);

                if($httpcode === 200) {
                    header("Location: bookings.php?message=Bokning borttagen!");
        
                } else {
                    header("Location: menu.php?error=Fel vid borttagning av bokning!");
                }

                }

                //GET request
                $url = 'https://studenter.miun.se/~beab2100/writeable/dt173g/Projekt/Webbtjanst/bookingapi.php';

                //Instasiera ny cURL session
                $curl = curl_init();
                //Inställningar för cURL
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                //Takes JSON encoded string and converts it into a PHP variable
                $data = json_decode(curl_exec($curl), true);
                
                $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
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
                    <?php foreach ($data as $c){ 
                        //Check if message exists in array
                        if(array_key_exists("message", $data)) {
                        //Print that no bookings exists
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
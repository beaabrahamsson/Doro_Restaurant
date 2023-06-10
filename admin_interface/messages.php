<?php
/*
 * @Author: Beatrice Abrahamsson
 * @Email: beaabrahamsson@hotmail.com
 * @Date: 2022-05-21 21:16:00
 * @Last Modified by: Beatrice Abrahamsson
 * @Last Modified time: 2022-05-28 18:15:08
 * @Description: Description
 */

//set page title
$page_title = "Meddelanden";
//include header
include("includes/header.php");
include("includes/restrict.php");
?>
<div class="table">
                <h2>Alla meddelanden</h2>
                <?php
                //DELETE request
                if(isset($_GET['deleteid'])) {  //If deleteid is set, delete 
                    $deleteurl = 'https://studenter.miun.se/~beab2100/writeable/dt173g/Projekt/Webbtjanst/contactapi.php?id='.$_GET['deleteid'];
                
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $deleteurl);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $result = json_decode(curl_exec($ch), true);
                $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                curl_close($ch);

                if($httpcode === 200) {
                    header("Location: messages.php?message=Meddelande borttaget!");
        
                } else {
                    header("Location: menu.php?error=Fel vid borttagning av meddelande!");
                }
                }

                //GET request
                $url = 'https://studenter.miun.se/~beab2100/writeable/dt173g/Projekt/Webbtjanst/contactapi.php';

                $curl = curl_init();

                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                $data = json_decode(curl_exec($curl), true);
                $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                curl_close($curl);

                ?>

            <table>
                <tr>
                    <th>Namn</th>
                    <th>Telefon</th>
                    <th>E-post</th>
                    <th>Meddelande</th>
                    <th>Datum</th>
                    <th>Ta bort</th>
                </tr>
                    <?php foreach ($data as $c){ 
                        //Check if message exists in array
                    if(array_key_exists("message", $data)) {
                        //Print that no messages exists
                        echo "<p class='error'>Det finns inga meddelanden att visa!</p>";
                    } else {?>
                        <tr><td> <?php echo "<a class='title' href='messagedetails.php?id=" . $c['contactid'] . "'>" . $c['fname'] . "&nbsp;" . $c['lname'] . "</a></td>" ?>
                        <td> <?php echo $c['phone']; ?> </td>
                        <td> <?php echo $c['email']; ?> </td>
                        <td> <?php echo substr($c['message'], 0, 30) . "..."; ?> </td>
                        <td> <?php echo $c['date']; ?> </td>
                        <td> <?php echo "<a href='messages.php?deleteid=" . $c['contactid'] . "'>Ta bort</a></td>" ?> 
                    </tr>
                    <?php }
                    } ?>
                </table>
        </div>
    <?php
    //include footer
    include("includes/footer.php");
    ?>
<?php
/*
 * @Author: Beatrice Abrahamsson
 * @Email: beaabrahamsson@hotmail.com
 * @Date: 2022-05-25 13:33:49
 * @Last Modified by: Beatrice Abrahamsson
 * @Last Modified time: 2022-05-26 14:04:24
 * @Description: Description
 */


class Dessert {

    public function deleteDessert() {
                //DELETE request
                //If deleteid is set, delete 
                if(isset($_GET['deleteid'])) {
                    $deleteurl = 'https://studenter.miun.se/~beab2100/writeable/dt173g/Projekt/Webbtjanst/dessertapi.php?id='.$_GET['deleteid'];

                // Create a curl handle
                $curl = curl_init();
                //Curl settings
                curl_setopt($curl, CURLOPT_URL, $deleteurl);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                $data = json_decode(curl_exec($curl), true);
                $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            
                curl_close($curl);
                
                //Send to menu.php and set message
                if($httpcode === 200) {
                    header("Location: menu.php?message=Efterätt borttagen!");
        
                } else {
                    header("Location: menu.php?error=Fel vid borttagning av efterätt!");
                }
                
        }
    }
}

<?php
/*
 * @Author: Beatrice Abrahamsson
 * @Email: beaabrahamsson@hotmail.com
 * @Date: 2022-05-25 13:34:04
 * @Last Modified by: Beatrice Abrahamsson
 * @Last Modified time: 2022-05-26 14:04:37
 * @Description: Description
 */


class Starter {
    public function deleteStarter() {
        //DELETE request
        if(isset($_GET['deleteid'])) { //If deleteid is set, delete 
            $deleteurl = 'https://studenter.miun.se/~beab2100/writeable/dt173g/Projekt/Webbtjanst/starterapi.php?id='.$_GET['deleteid'];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $deleteurl);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
        $data = json_decode(curl_exec($curl), true);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if($httpcode === 200) {
            header("Location: menu.php?message=Förrätt borttagen!");

        } else {
            header("Location: menu.php?error=Fel vid borttagning av förrätt!");
        }
        
        }
    }
}
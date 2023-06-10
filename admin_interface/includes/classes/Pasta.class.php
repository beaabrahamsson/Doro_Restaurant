<?php
/*
 * @Author: Beatrice Abrahamsson
 * @Email: beaabrahamsson@hotmail.com
 * @Date: 2022-05-25 13:33:58
 * @Last Modified by: Beatrice Abrahamsson
 * @Last Modified time: 2022-05-26 14:04:33
 * @Description: Description
 */


class Pasta {
    public function deletePasta() {
        //DELETE request 
        if(isset($_GET['deleteid'])) { //If deleteid is set, delete
            $deleteurl = 'https://studenter.miun.se/~beab2100/writeable/dt173g/Projekt/Webbtjanst/pastaapi.php?id='.$_GET['deleteid'];
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $deleteurl);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
        $data = json_decode(curl_exec($curl), true);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if($httpcode === 200) {
            header("Location: menu.php?message=Pastarätt borttagen!");

        } else {
            header("Location: menu.php?error=Fel vid borttagning av pastarätt!");
        }
        
        }
    }
}
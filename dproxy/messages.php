<?php
$ch = curl_init();
$get = true;

// example body: {"body":"{}"}

/*

Sample code for sending message

fetch("your.public.ip.or.domain.here/dproxy/message.php", {
    body: "send=true&content="+encodeURIComponent(message),
    headers: {
        "Content-Type": "application/x-www-form-urlencoded",
    },
    method: "post",
}

With TTS

fetch("your.public.ip.or.domain.here/dproxy/message.php", {
    body: "send=true&tts=true&content="+encodeURIComponent(message),
    headers: {
        "Content-Type": "application/x-www-form-urlencoded",
    },
    method: "post",
}

*/
if(isset($_POST["send"]) && $_POST["send"] == 'true'){
    $get = false;
}
if($get){
    if(isset($_POST["id"])){
        curl_setopt($ch, CURLOPT_URL, 'https://discord.com/api/v9/channels/'.$_POST["id"].'/messages?limit=100');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:120.0) Gecko/20100101 Firefox/120.0',
            'Accept: */*',
            'Accept-Language: en-US,en;q=0.5',
            'Content-Type: application/json',
            'Authorization: '. file_get_contents("token.txt"),
            'Origin: https://discord.com',
            'Connection: keep-alive',
            'Referer: https://discord.com/channels/@me/'.$_POST["id"],
            'Sec-Fetch-Dest: empty',
            'Sec-Fetch-Mode: cors',
            'Sec-Fetch-Site: same-origin',
            'TE: trailers'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, null);

        $response = curl_exec($ch);
        curl_close($ch);
        header("Content-Type: application/json");
        echo $response;       
    }
} else {
    if(isset($_POST["id"])){
        curl_setopt($ch, CURLOPT_URL, 'https://discord.com/api/v9/channels/'.$_POST["id"].'/messages');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:120.0) Gecko/20100101 Firefox/120.0',
            'Accept: */*',
            'Accept-Language: en-US,en;q=0.5',
            'Content-Type: application/json',
            'Authorization: '. file_get_contents("token.txt"),
            'Origin: https://discord.com',
            'Connection: keep-alive',
            'Referer: https://discord.com/channels/@me/'.$_POST["id"],
            'Sec-Fetch-Dest: empty',
            'Sec-Fetch-Mode: cors',
            'Sec-Fetch-Site: same-origin',
            'TE: trailers'
        ]);
        if(isset($_POST["tts"]) && $_POST["tts"] == true){
            $tts = true;
        } else {
            $tts = false;
        }
        $sendjson = array("content" => $_POST["content"], "flags" => 0, "mobile_network_type" => "unknown", "noonce" => time(), "tts" => $tts);

        $finalsent = json_encode($sendjson);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $finalsent);

        $response = curl_exec($ch);
        curl_close($ch);
        header("Content-Type: application/json");
        header('whatisent: '.$finalsent);
        echo $response;
    }
}
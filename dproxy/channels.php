<?php
$ch = curl_init();
if(isset($_POST["server"])){

} else {
    curl_setopt($ch, CURLOPT_URL, 'https://discord.com/api/v9/users/@me/channels');
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
            'Referer: https://discord.com/channels/@me/',
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

?>

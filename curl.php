<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 13/03/2016
 * Time: 13:27
 */


$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://cloudpanel-api.oneAndOne.com/v1/ping_auth",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "x-token: 8263019c35f8c3094bc1daa782d50cf2"
    ),
	CURLOPT_SSL_VERIFYPEER => false
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    echo $response;
}
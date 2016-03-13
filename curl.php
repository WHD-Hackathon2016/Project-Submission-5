<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 13/03/2016
 * Time: 13:27
 */


$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://cloudpanel-api.1and1.com/v1/ping_auth",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/json",
        "postman-token: bb29126e-3858-c54b-e088-74b2dca6e1d3",
        "x-token: 8263019c35f8c3094bc1daa782d50cf2"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    echo $response;
}
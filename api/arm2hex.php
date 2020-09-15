<?php

function convert($seeds)
{
    $curl = curl_init();

    $codes = "";
    foreach ($seeds as $seed) {
        switch ($seed <= 0xFFFF) {
            case true:
                $tmp = dechex($seed);
                $codes .= "MOV X0, #0x{$tmp}\n";
                break;
            case false:
                $tmp = [dechex(($seed & 0xFFFF0000)), dechex($seed & 0xFFFF)];
                // print_r($tmp);
                $codes .= "MOV X0, #0x{$tmp[0]}\nMOVK X0, #0x{$tmp[1]}\n";
                break;
        }
    }
    // echo ($codes);

    $body = json_encode(array(
        "asm" => $codes,
        "offset" => "",
        "arch" => array("arm64")
    ));

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://armconverter.com/api/convert",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $body,
        CURLOPT_HTTPHEADER => array(
            "Host: armconverter.com",
            "Content-Type: application/json",
            "Accept: */*",
            "Connection: keep-alive",
        ),
    ));

    $response = json_decode(curl_exec($curl), true);
    curl_close($curl);

    return json_encode(explode("\n", $response["hex"]["arm64"][1]));
    // return json_encode(array("arm64" => explode("\n", $response["hex"]["arm64"][1])));
}

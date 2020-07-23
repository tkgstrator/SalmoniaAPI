<?php
function getSessionToken($session_token_code, $session_token_code_verifier)
{
    $curl = curl_init();

    $body = json_encode(array(
        "client_id" => "71b963c1b7b6d119",
        "session_token_code" => $session_token_code,
        "session_token_code_verifier" => $session_token_code_verifier
    ));
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://accounts.nintendo.com/connect/1.0.0/api/session_token",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $body,
        CURLOPT_HTTPHEADER => array(
            "Host: accounts.nintendo.com",
            "Content-Type: application/json",
        ),
    ));

    $response = json_decode(curl_exec($curl), true);
    curl_close($curl);

    switch (!empty($response["error"])) {
        case true:
            http_response_code(400);
            return (json_encode(array("from" => "salmonia api", "error" => "invalid_request", "error_description" => "The provided session_token_code is expired")));
            break;
        case false:
            return (json_encode(array("session_token" => $response["session_token"])));
            break;
        default:
            break;
    }
}

function getAccessToken($session_token)
{
    $curl = curl_init();

    $body = json_encode(array(
        "client_id" => "71b963c1b7b6d119",
        "session_token" => $session_token,
        "grant_type" => "urn:ietf:params:oauth:grant-type:jwt-bearer-session-token"
    ));
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://accounts.nintendo.com/connect/1.0.0/api/token",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $body,
        CURLOPT_HTTPHEADER => array(
            "Host: accounts.nintendo.com",
            "Content-Type: application/json"
        ),
    ));

    $response = json_decode(curl_exec($curl), true);
    curl_close($curl);

    switch (!empty($response["error"])) {
        case true:
            http_response_code(400);
            return (json_encode(array("from" => "salmonia api", "error" => "invalid_request", "error_description" => "The provided session_token is expired")));
            break;
        case false:
            return (json_encode(array("access_token" => $response["access_token"])));
            break;
        default:
            break;
    }
}

function callS2SAPI($access_token, $timestamp)
{
    $curl = curl_init();

    $body = http_build_query(array(
        "naIdToken" => $access_token,
        "timestamp" => $timestamp
    ));
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://elifessler.com/s2s/api/gen2",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $body,
        CURLOPT_HTTPHEADER => array(
            "Host: elifessler.com",
            "User-Agent: Salmonia for ReactNative/0.0.1",
            "Content-Type: application/x-www-form-urlencoded"
        ),
    ));

    $response = json_decode(curl_exec($curl), true);
    curl_close($curl);

    switch (!empty($response["error"])) {
        case true:
            http_response_code(400);
            return (json_encode(array("from" => "salmonia api", "error" => "invalid_request", "error_description" => "Too many requests")));
            break;
        case false:
            return $response["hash"];
            // return (json_encode(array("hash" => $response["hash"])));
            break;
        default:
            break;
    }
}

function callFlapgAPI($access_token, $type)
{
    $curl = curl_init();

    $timestamp = time();
    // 常に同じ値を利用する
    $guid = "037239ef-1914-43dc-815d-178aae7d8934";
    // Call s2s API
    $hash = callS2SAPI($access_token, $timestamp);

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://flapg.com/ika2/api/login?public",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "x-token: ${access_token}",
            "x-time: ${timestamp}",
            "x-guid: ${guid}",
            "x-hash: ${hash}",
            "x-ver: 3",
            "x-iid: ${type}",
            "User-Agent: Salmonia for ReactNative/0.0.1",
        ),
    ));
    $response = json_decode(curl_exec($curl), true);
    curl_close($curl);

    switch (!empty($response["error"])) {
        case true:
            http_response_code(400);
            return (json_encode(array("from" => "salmonia api", "error" => "invalid_request", "error_description" => "NSO application need to update")));
            break;
        case false:
            return json_encode($response["result"]);
            break;
        default:
            break;
    }
}

function getSplatoonToken($flapg_nso)
{
    $curl = curl_init();

    $body = array(
        "parameter" => array(
            "f" => $flapg_nso["f"],
            "naIdToken" => $flapg_nso["p1"],
            "timestamp" => $flapg_nso["p2"],
            "requestId" => $flapg_nso["p3"],
            "naCountry" => "JP",
            "naBirthday" => "1990-01-01",
            "language" => "ja-JP"
        )
    );
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api-lp1.znc.srv.nintendo.net/v1/Account/Login",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($body),
        CURLOPT_HTTPHEADER => array(
            "Host: api-lp1.znc.srv.nintendo.net",
            "Accept: */*",
            "X-ProductVersion: 1.6.1.2",
            "Accept-Language: en-US",
            "Content-Type: application/json",
            "Connection: keep-alive",
            "Authorization: Bearer",
            "X-Platform: Android"
        ),
    ));

    $response = json_decode(curl_exec($curl), true);
    curl_close($curl);

    switch (!empty($response["error"])) {
        case true:
            http_response_code(400);
            return (json_encode(array("from" => "salmonia api", "error" => "invalid_request", "error_description" => "The request does not satisfy the schema")));
            break;
        case false:
            return json_encode(array("splatoon_token" => $response["result"]["webApiServerCredential"]["accessToken"], "user" => array("name" => $response["result"]["user"]["name"], "image" => $response["result"]["user"]["imageUri"])));
            break;
        default:
            break;
    }
}

function getSplatoonAccessToken($flapg_app, $splatoon_token)
{
    $curl = curl_init();

    $body = array(
        "parameter" => array(
            "id" => "5741031244955648",
            "f" => $flapg_app["f"],
            "registrationToken" => $flapg_app["p1"],
            "timestamp" => $flapg_app["p2"],
            "requestId" => $flapg_app["p3"],
        )
    );

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api-lp1.znc.srv.nintendo.net/v2/Game/GetWebServiceToken",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($body),
        CURLOPT_HTTPHEADER => array(
            "Host: api-lp1.znc.srv.nintendo.net",
            "Accept: */*",
            "X-ProductVersion: 1.6.1.2",
            "Accept-Language: en-US",
            "Content-Type: application/json",
            "Connection: keep-alive",
            "Authorization: Bearer ${splatoon_token}",
            "X-Platform: Android"
        ),
    ));

    $response = json_decode(curl_exec($curl), true);
    curl_close($curl);

    switch (!empty($response["error"])) {
        case true:
            http_response_code(400);
            return (json_encode(array("from" => "salmonia api", "error" => "invalid_request", "error_description" => "The request does not satisfy the schema")));
            break;
        case false:
            return json_encode(array("splatoon_access_token" => $response["result"]["accessToken"]));
            break;
        default:
            break;
    }
}

function getIksmSession($splatoon_access_token)
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://app.splatoon2.nintendo.net",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_NOBODY => true,
        CURLOPT_HEADER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Host: app.splatoon2.nintendo.net",
            "X-GameWebToken: ${splatoon_access_token}",
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    preg_match_all("/^Set-Cookie: ([^;\r\n]+)/mi", $response, $matches);
    $cookies = implode("; ", $matches[1]);
    $iksm_session = array(
        "iksm_session" => substr($cookies, 13, 40)
    );
    echo json_encode($iksm_session);
}

function getResults($iksm_session, $id)
{
    $url = "https://app.splatoon2.nintendo.net/api/{$id}";
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "cookie: iksm_session=${iksm_session}"
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return $response;
}

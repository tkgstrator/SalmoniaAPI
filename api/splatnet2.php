<?php
function getSessionToken($session_token_code, $auth_code_verifier)
{
    $url = "https://accounts.nintendo.com/connect/1.0.0/api/session_token";

    $body = array(
        "client_id" => "71b963c1b7b6d119",
        "session_token_code" => $session_token_code,
        "session_token_code_verifier" => $auth_code_verifier,
    );
    $header = array(
        "Host" => "accounts.nintendo.com",
        "Content-Type" => "application/json; charset=utf-8",
        "Connecton" => "keep-alive",
        "User-Agent" => "com.nintendo.znca/1.6.1.2 (Android/7.1.2)",
        // "Accept: */*",
        "Content-Length" => "548",
        "Accept-Language" => "en-ca",
        "Accept-Encoding" => "gzip, deflate, br",
    );
    $context = array(
        "http" =>
        array(
            "method" => "POST",
            "header" => implode("\r\n", $header),
            "ignore_errors" => true,
            "content" => http_build_query($body)
        ),
    );
    $result = file_get_contents($url, false, stream_context_create($context));
    return $result;
}

function getAccessToken($session_token)
{
    $url = "https://accounts.nintendo.com/connect/1.0.0/api/token";
    $body = array(
        "client_id" => "71b963c1b7b6d119",
        "session_token" => $session_token,
        "grant_type" => "urn:ietf:params:oauth:grant-type:jwt-bearer-session-token"
    );
    $header = array(
        "Host" => "accounts.nintendo.com",
        "Content-Type" => "application/json",
        "Connecton" =>  "keep-alive",
        "User-Agent" => "com.nintendo.znca/1.6.1.2 (Android/7.1.2)",
        "Accept" => "*/*",
        "Content-Length" => strlen(json_encode($body)),
        "Accept-Language" => "en-ca",
        "Accept-Encoding" => "gzip, deflate, br",
    );
    $context = array(
        "http" =>
        array(
            "method" => "POST",
            "header" => implode("\r\n", $header),
            "ignore_errors" => true,
            "content" => http_build_query($body)
        ),
    );
    $result = file_get_contents($url, false, stream_context_create($context));
    return $result;
}

function callS2SAPI($access_token, $timestamp)
{
    $url = "https://elifessler.com/s2s/api/gen2";
    $body = array(
        "naIdToken" => $access_token,
        "timestamp" => $timestamp
    );
    $header = array(
        "Host: elifessler.com",
        "User-Agent: Salmonia for ReactNative/0.0.1",
    );
    $context = array(
        "http" =>
        array(
            "method" => "POST",
            "header" => implode("\r\n", $header),
            "ignore_errors" => true,
            "content" => http_build_query($body)
        ),
    );
    $result = json_decode(file_get_contents($url, false, stream_context_create($context)), true);
    return $result["hash"];
}

function callFlapgAPI($access_token, $type)
{
    $timestamp = time();
    // 常に同じ値を利用する
    $guid = "037239ef-1914-43dc-815d-178aae7d8934";
    // Call s2s API
    $hash = callS2SAPI($access_token, $timestamp);
    // Call flapg API
    $url = "https://flapg.com/ika2/api/login?public";
    $header = array(
        "x-token: ${access_token}",
        "x-time: ${timestamp}",
        "x-guid: ${guid}",
        "x-hash: ${hash}",
        "x-ver: 3",
        "x-iid: ${type}",
        "User-Agent: Salmonia for ReactNative/0.0.1"
    );
    $context = array(
        "http" =>
        array(
            "method" => "GET",
            "header" => implode("\r\n", $header),
            "ignore_errors" => true,
        ),
    );
    $result = file_get_contents($url, false, stream_context_create($context));
    return $result;
}

function getSplatoonToken($flapg_nso)
{
    $url = "https://api-lp1.znc.srv.nintendo.net/v1/Account/Login";
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
    // $header = array(
    //     "Host: api-lp1.znc.srv.nintendo.net",
    //     "Accept: */*",
    //     "X-ProductVersion: 1.6.1.2",
    //     "Content-Type: application/json; charset=utf-8",
    //     "Accept-Language: en-US",
    //     // "Accept-Encoding: gzip, deflate, br",
    //     "User-Agent: com.nintendo.znca/1.6.1.2 (Android/7.1.2)",
    //     "Content-Type: application/json;",
    //     "Connection: keep-alive",
    //     "Authorization: Bearer",
    //     // "Content-Length" => strlen(http_build_query($body)),
    //     "X-Platform: Android",
    // );
    $header = array(
        "Host" => "api-lp1.znc.srv.nintendo.net",
        "Accept" => "*/*",
        "X-ProductVersion" => "1.6.1.2",
        "Accept-Language" => "en-US",
        // "Accept-Encoding" => "gzip, deflate, br",
        "User-Agent" => "com.nintendo.znca/1.6.1.2 (Android/7.1.2)",
        "Connection" => "keep-alive",
        "Authorization" => "Bearer",
        // "Content-Length" => strlen(http_build_query($body)),
        "X-Platform" => "Android",
    );
    $context = array(
        "http" =>
        array(
            "method" => "POST",
            "header" => implode("\r\n", $header),
            "content" => json_encode($body),
            "ignore_errors" => true,
        ),
    );
    $result = file_get_contents($url, false, stream_context_create($context));
    return $result;
}

function getSplatoonAccessToken()
{
}

function getIksmSession()
{
}

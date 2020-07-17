<?php
require_once("splatnet2.php");

preg_match("|" . dirname($_SERVER["SCRIPT_NAME"]) . "/([\w%/]*)|", $_SERVER["REQUEST_URI"], $matches);
$paths = explode("/", $matches[1]);
$id = isset($paths[1]) ? htmlspecialchars($paths[1]) : null;
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
switch (strtolower($_SERVER["REQUEST_METHOD"]) . ":" . $paths[0]) {
    case "post:session_token":
        $body = json_decode(file_get_contents("php://input"), true);
        try {
            $session_token_code = $body["session_token_code"];
            $session_token_code_verifier = $body["session_token_code_verifier"];
            $message = getSessionToken($session_token_code, $session_token_code_verifier);
        } catch (Exception $e) {
            $message = json_encode(array(
                "error" => "invalid_request",
                "error_description" => "The request does not satisfy the schema",
            ));
        }
        echo ($message);
        break;
    case "post:access_token":
        $body = json_decode(file_get_contents("php://input"), true);
        try {
            $session_token = $body["session_token"];
            // $message = $session_token;
            $message = getAccessToken($session_token);
        } catch (Exception $e) {
            $message = json_encode(array(
                "error" => "invalid_request",
                "error_description" => "The request does not satisfy the schema",
            ));
        }
        echo ($message);
        break;
    case "post:splatoon_token":
        $body = json_decode(file_get_contents("php://input"), true);
        try {
            // $message = $body["f"];
            $message = getSplatoonToken($body);
        } catch (Exception $e) {
            $message = json_encode(array(
                "error" => "invalid_request",
                "error_description" => "The request does not satisfy the schema",
            ));
        }
        echo ($message);
        break;
    case "post:login":
        $body = json_decode(file_get_contents("php://input"), true);
        try {
            $type = $body["type"];
            $access_token = $body["access_token"];
            $message = callFlapgAPI($access_token, $type);
        } catch (Exception $e) {
            $message = json_encode(array(
                "error" => "invalid_request",
                "error_description" => "The request does not satisfy the schema",
            ));
        }
        echo ($message);
        break;
    case "post:account":
        $body = json_decode(file_get_contents("php://input"), true);
        try {
            $access_token = $body["f"];
            $timestamp = time();
            // $message =  $access_token;
            $message = callS2SAPI($access_token, $timestamp);
        } catch (Exception $e) {
            $message = json_encode(array(
                "error" => "invalid_request",
                "error_description" => "The request does not satisfy the schema",
            ));
        }
        echo ($message);
        break;
    case "post:iksm_session":
        break;
    case "post:private":
        $body = json_decode(file_get_contents("php://input"), true);
        try {
            $session_token_code = $body["session_token_code"];
            $session_token_code_verifier = $body["session_token_code_verifier"];
            $session_token = getSessionToken($session_token_code, $session_token_code_verifier);
            $access_token = getAccessToken($session_token);
            $flapg_nso = callFlapgAPI($access_token, "nso");
            $splatoon_token = getSplatoonToken($flapg_nso);
            $flapg_app = callFlapgAPI($splatoon_token, "app");
            $splatoon_access_token = getSplatoonAccessToken($flapg_app);
            $iksm_session = getIksmSession($splatoon_access_token);
            $message = json_encode(array(
                "iksm_session" => $iksm_session
            ));
        } catch (Exception $e) {
            $message = json_encode(array(
                "error" => "invalid_request",
                "error_description" => "The request does not satisfy the schema",
            ));
        }
        echo ($message);
        break;
    default:
        $message = array(
            "error" => "Only POST allowed"
        );
        http_response_code(405);
        echo (json_encode($message));
        break;
}

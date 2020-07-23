<?php
require_once("splatnet2.php");

preg_match("|" . dirname($_SERVER["SCRIPT_NAME"]) . "/([\w%/]*)|", $_SERVER["REQUEST_URI"], $matches);
$paths = explode("/", $matches[1]);
$id = isset($paths[1]) ? htmlspecialchars($paths[1]) : null;
header("Content-Type: application/json");
// header("Access-Control-Allow-Origin: https://tkgstrator.github.io");
header("Access-Control-Allow-Origin: *");
switch (strtolower($_SERVER["REQUEST_METHOD"]) . ":" . $paths[0]) {
    case "post:session_token":
        $body = json_decode(file_get_contents("php://input"), true);
        $session_token_code = $body["session_token_code"];
        $session_token_code_verifier = $body["session_token_code_verifier"];
        $message = getSessionToken($session_token_code, $session_token_code_verifier);
        echo ($message);
        break;
    case "post:access_token":
        $body = json_decode(file_get_contents("php://input"), true);
        $session_token = $body["session_token"];
        $message = getAccessToken($session_token);
        echo ($message);
        break;
    case "post:splatoon_token":
        $body = json_decode(file_get_contents("php://input"), true);
        $message = getSplatoonToken($body);
        echo ($message);
        break;
    case "post:splatoon_access_token":
        $body = json_decode(file_get_contents("php://input"), true);
        $flapg_app = $body["parameter"];
        $splatoon_token = $body["splatoon_token"];
        $message = getSplatoonAccessToken($flapg_app, $splatoon_token);
        echo ($message);
        break;
    case "post:iksm_session":
        $body = json_decode(file_get_contents("php://input"), true);
        $splatoon_access_token = $body["splatoon_access_token"];
        $message = getIksmSession($splatoon_access_token);
        echo ($message);
        break;
    case "post:gen2":
        $body = json_decode(file_get_contents("php://input"), true);
        $access_token = $body["access_token"];
        $timestamp = time();
        $message = callS2SAPI($access_token, $timestamp);
        echo ($message);
        break;
    case "post:login":
        $body = json_decode(file_get_contents("php://input"), true);
        $type = $body["type"];
        $access_token = $body["access_token"];
        // echo $access_token;
        $message = callFlapgAPI($access_token, $type);
        echo ($message);
        break;
    case "post:timeline": // ホーム画面の情報
    case "post:nickname_and_icon": // 現在のニックネームとアイコン
    case "post:stages": // ステージ情報
    case "post:hero": // ヒーローモード
    case "post:records": // 塗りポイントなど
    case "post:results": // バトルの履歴
    case "post:schedules": // スケジュール
    case "post:coop_results": // サーモンランの履歴
        $body = json_decode(file_get_contents("php://input"), true);
        $iksm_session = $body["iksm_session"];
        $message = getResults($iksm_session, $matches[1]);
        break;
    default:
        http_response_code(405);
        echo (json_encode(array("from" => "salmonia api", "error" => "invalid_protocol", "Salmonia api allowed only post request")));
        break;
}

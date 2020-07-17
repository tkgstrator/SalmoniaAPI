<?php
function urlsafe_b64encode($val) {
  $val = base64_encode($val);
  return str_replace(["/","+","="], ["_","-",""], $val);
}
$auth_state = urlsafe_b64encode(random_bytes(36));
$auth_code_verifier =  urlsafe_b64encode(random_bytes(32));
$auth_cv_hash = hash("sha256", $auth_code_verifier);
$auth_code_challenge = urlsafe_b64encode(hex2bin($auth_cv_hash));

$base_url = "https://accounts/nintendo.com/connect/1.0.0/authorize?";
$base_url = "https://accounts.nintendo.com/connect/1.0.0/authorize?";

$param = array( 
	"state" => $auth_state,
	"redirect_uri" => "npf71b963c1b7b6d119://auth",
	"client_id" => "71b963c1b7b6d119",
	"scope" => "openid user user.birthday user.mii user.screenName",
	"response_type" => "session_token_code",
	"session_token_code_challenge" => $auth_code_challenge,
	"session_token_code_challenge_method" => "S256",
	"theme" => "login_form"
);
$auth_url = $base_url . http_build_query($param);
$response = array(
	"auth_code_verifier" => $auth_code_verifier,
	"auth_url" => $auth_url);

header('content-type: application/json; charset=utf-8');
echo(json_encode($response, JSON_UNESCAPED_SLASHES));
?>

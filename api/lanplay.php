<?php
function getLanPlayServerList()
{
    $server_list = array(
        "JP" => array(
            "Name" => "Japan",
            "Host" => "tkgstrator.work",
            "Location" => "JP"
        ),
        "CA" => array(
            "Name" => "Canada",
            "Host" => "salmonia.mydns.jp",
            "Location" => "CA"
        ),
        "FR" => array(
            "Name" => "France",
            "Host" => "switch.lan-play.com",
            "Location" => "FR"
        ),
        "US" => array(
            "Name" => "USA",
            "Host" => "frog-skins.com",
            "Location" => "US"
        ),
        "DE" => array(
            "Name" => "Germany",
            "Host" => "lan.nonny.horse",
            "Location" => "DE"
        ),
    );
    return json_encode($server_list);
}

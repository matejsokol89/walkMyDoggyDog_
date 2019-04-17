<?php

error_reporting(E_ALL);
ini_set("display_errors",1);
echo "https://fantasy.premierleague.com/drf/bootstrap-static";
$handle = curl_init();
curl_setopt($handle, CURLOPT_URL, "https://fantasy.premierleague.com/drf/bootstrap-static");
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
$fpl = curl_exec($handle);
curl_close($handle);

$fpl = json_decode($fpl,true);

print_r($fpl);
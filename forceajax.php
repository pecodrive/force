<?php

require 'vendor/autoload.php';
$request    = json_decode(file_get_contents( "php://input" ) , true);
$xPathQuery = 
    [ 
        "gSiteUrl"    =>"//*[@id=\"rso\"]//h3[@class=\"r\"]/a",
        "gSiteDisp"   =>"//*[@id=\"rso\"]//span[@class=\"st\"]",
        "encodeCheck" =>"//meta[http-equiv]"
        // "gSiteUrl"  =>"//*[@id=\"rso\"]/div[@class=\"srg\"]/div[@class=\"g\"]/div[@class=\"rc\"]/h3[@class=\"r\"]/a",
        // "gSiteDisp" =>"//*[@id=\"rso\"]/div[@class=\"srg\"]/div[@class=\"g\"]/div[@class=\"rc\"]/div[@class=\"s\"]/div/span[@class=\"st\"]"
        // "test"  =>"//*[@id=\"rso\"]/div[@class=\"srg\"]/div[@class=\"g\"]/div[@class=\"rc\"]",
    ];
$regex      =
    [
        "host"     => "/https?:\/\/([_\-0-9a-z\.]+)\//",
        "equiv"   => "/<meta\shttp\-equiv=\"content\-type\"\scontent=\"text\/html;\scharset=([\-a-zA-Z0-9]+)\"\s?\/?>/i",
        "charset"  => "/charset=\"?([_\-utf8shijecpUTFSHIJECP]+)\"/"
    ];

$ua =  "user-agent:Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.134 Safari/537.36\r\n";
$requestHtml = $request["html"];
$url = new General\FetchSiteUrl($requestHtml, $xPathQuery["gSiteUrl"], $xPathQuery["gSiteDisp"], $regex["host"], $regex["equiv"], $regex["charset"]);
$sentens = $url->fetchHtml($ua, $regex["equiv"], $regex["charset"]); 
var_dump($sentens);
// $jsonData = json_encode($sentens);
// header( "Content-Type: application/json; X-Content-Type-Options: nosniff; charset=utf-8" );
// echo $jsonData;
// die();


<?php
$request    = json_decode(file_get_contents( "php://input" ) , true);
$fixed      =
    [
        "googleSearchUrl"=>"https://www.google.co.jp/search?q=",
        "googleUrl"=>"https://www.google.co.jp",
        "googleSufix"=>"\&safe=off\&start=",
        "googleHost"=>"www.google.co.jp",
        "sourceSufic"=>"view-source:"
    ];
$xPathQuery = 
    [ 
        "gSiteUrl" =>"body//div[@id=\"ires\"]/ol/li/h3/a",
        "gNavUrl"  =>"body//table[@id=\"nav\"]//td/a[@class=\"fl\"]"
    ];

class FetchSearchEngineNavUrl{

    private $searchEngineNavUrl;

    public function __construct($html, $sourcesufix, $urlsufix, $xPathQuery){
        $dom                      = $this->getDomObject($html);
        $xPathObject              = $this->getXPathObject($dom);
        $this->searchEngineNavUrl = $this->stealSearchEngineNavUrl($xPathObject, $sourcesufix, $urlsufix, $xPathQuery);
    }
    private function stealSearchEngineNavUrl($xPath, $sourcesufix, $urlsufix, $xPathQuery){
        $result = $xPath->query($xPathQuery);
        foreach ($result as $value) {
            $list[] = $sourcesufix . $urlsufix . $value->getAttribute("href");
        }
        return $list;
    }

    private function getDomObject($resultHtml){
        $dom = new DOMDocument();
        @$dom->loadHTML($resultHtml);
        return $dom;
    }

    private function getXPathObject($dom){
        $xPath = new DOMXPath($dom);
        return $xPath;
    }
    public function getSearchEngineNavUrl(){
        return $this->searchEngineNavUrl;
    }
}

$url = new FetchSearchEngineNavUrl($request["html"], $fixed["sourceSufic"], $fixed["googleUrl"], $xPathQuery["gNavUrl"]);
$jsonData = json_encode($url->getSearchEngineNavUrl());

header( "Content-Type: application/json; X-Content-Type-Options: nosniff; charset=utf-8" );
echo $jsonData;
die();

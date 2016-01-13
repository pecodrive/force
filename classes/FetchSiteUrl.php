<?php

namespace General;

class FetchSiteUrl{
    private $siteUrl;
    private $result;
    private $contextHost;

    public function __construct($requestHtml, $xPathQuery4A, $xPathQuery4Disp, $regex4Host, $regex4Equiv, $regex4Charaset ){
        $encodedHtml       = $this->fixEncode4Se($requestHtml, $regex4Equiv, $regex4Charaset);
        $dom4SiteUrl       = $this->createDomObject($encodedHtml);
        $xPathObj4SiteUrl  = $this->createXPathObject($dom4SiteUrl);
        $this->siteUrl     = $this->stealSiteUrl($xPathObj4SiteUrl, $xPathQuery4A, $xPathQuery4Disp);
        $this->siteUrl     = $this->getRequestHost($this->siteUrl, $regex4Host);
    }

    private function createDomObject($resultHtml)
    {
        $dom = new \DOMDocument();
        @$dom->loadHTML($resultHtml);
        return $dom;
    }

    private function createDomEmpty()
    { 
        $dom = new \DOMDocument();
        return $dom;
    }

    private function createXPathObject($dom)
    {
        $xPath = new \DOMXPath($dom);
        return $xPath;
    }

    private function stealSiteUrl($xPathObj4SiteUrl, $xPathQuery4A, $xPathQuery4Disp)
    {
        $resultA    = $xPathObj4SiteUrl->query($xPathQuery4A);
        $resultDisp = $xPathObj4SiteUrl->query($xPathQuery4Disp);
        foreach ($resultA as $key => $value) {
            $list[$key]["url"]  = $value->getAttribute("href");
            $list[$key]["disp"] = $value->nodeValue;
        }
        return $list;
    }

    private function getRequestHost($siteUrlArray, $regex)
    {
        foreach ($siteUrlArray as $key => $url) {
            preg_match($regex, $url["url"], $contextHost);
            $siteUrlArray[$key]["host"] = $contextHost[1];
        }
        return $siteUrlArray;
    }

    // private function createContext($contextHost, $contextUa)
    // {
    //     $option =
    //         [
    //             "http"=> 
    //             [
    //                 "ignore_error"=>true,
    //                 // "method"=>"GET",
    //                 // "header"=>
    //                 // "host:{$contextHost[1]}\r\n"
    //                 // ."{$contextUa}",
    //                 // "ignore_error"=>true
    //             ]
    //         ];
    //     $context = stream_context_create($option);
    //     return $context;
    // }
    private function createContext()
    {
        $option =
            [
                "http"=> 
                [
                    "ignore_error"=>true,
                ]
            ];
        $context = stream_context_create($option);
        return $context;
    }
    private function fileGetContents($url)
    {
        try{
            $html = file_get_contents($url, false, $this->createContext());
            preg_match("/HTTP\/[0-9\.]+\s([0-9]{3})/", $http_response_header[0], $match);
            var_dump($match);
            $statCode = (int)$match[1];
            if($statCode <= 399){
                return $html;
            }elseif($statCode >= 400){
                throw new \Exception("statcode 400 uper");
            }
        }catch(\Exception $e){
            $e->getMessage();
        }

    }

    private function isCharaset($word)
    {
        if($word === "shift_jis" or "SHIFT_JIS" or "Shift_Jis" or "SHIFT_jis" or "shift_JIS"){
            $byChar = "SJIS"; 
        }elseif($word === "EUCJP" or "EUC-JP" or "eucjp" or "euc-jp"){
            $byChar = "EUC-JP"; 
        }else{
            //todo
            //throw exception
        }
        return $byChar;
    }

    //phpのアホンダラがenquivでchar判断している
    //googleはちゃんとcharset使っているので強制的にequivタグを付加して文字化けを防ぐ
    private function fixEncode4Se($html, $regex4Equiv, $regex4Charaset)
    {
        $equivCharsetTag = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />";
        $encodedHtml     = $equivCharsetTag . $html;
        return $encodedHtml;
    }
    private function encodeCheck($html, $regex4encode, $regex4Charset)
    {
        $isEqiuv   = preg_match_all($regex4encode, $html, $equivMatch, PREG_SET_ORDER);
        $isCharset = preg_match_all($regex4Charset, $html, $charsetMatch, PREG_SET_ORDER);
        if(!$isEqiuv && !$isCharset){
            return $html;
        }elseif($isEqiuv && !$isCharset){
            return $html;
        }elseif(!$isEqiuv && $charsetMatch){
            $equivCharsetTag = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset={$charsetMatch[0][1]}\" />";
            $fixhtml = $equivCharsetTag. $html;
            return $fixhtml;
        }else{
            return $html;
        }
    }


    //google配下のドメインはスクレイピングしない
    public function fetchHtml($ua, $regex4encode, $regex4Charset)
    {
        //*** google domain is scripting to ban
        $dom = $this->createDomEmpty();
        $i=0;
        foreach ($this->siteUrl as $data) {
            if($i > 20){break;} 
            $isGoogle     = preg_match("/google/", $data["host"], $match);
            if($isGoogle){
                continue;
            }
            $context      = $this->createContext($data["host"], $ua);
            // $html         = file_get_contents($data["url"], false, $context);
            $html         = $this->encodeCheck($this->fileGetContents($data["url"]), $regex4encode, $regex4Charset);
            @$dom->loadHTML($html);
            $tempArray         = $this->removeTagEts($dom);
            $tempArray        = $this->fixEmptyValue($tempArray);
            $tempArray         = $this->remove1ByteChar($tempArray);
            $sentensArray[]   = $this->splitComma($tempArray);
            // $sentensArray[] = $this->removeLatin1($tempArray);
            // $http_response_header;
            $i++;
        } 
        return $sentensArray;
    }

    private function removeTagEts($dom4SiteHtml)
    {
        //*** separate by \n
        preg_match_all("/.*\n/u", $dom4SiteHtml->textContent, $match);

        //*** remove tab(ets) by \s
        foreach ($match as $value) {
            $tempFixTabArray = preg_replace("/\s/", "", $value);
        }
        return $tempFixTabArray;
    }

    private function fixEmptyValue($tempArray){
        //*** remove empty value
        foreach ($tempArray as $value) {
            if(empty($value)){
                continue;
            }
            $tempFixEmptyArray[] = $value;
        }
        return $tempFixEmptyArray;
    }

    private function remove1ByteChar($tempArray)
    {
        //*** remove value of only 1byte character
        foreach ($tempArray as $value) {
                $bool = preg_match("/[^\x01-\x7E]/u", $value, $match);
                if(!$bool){
                    continue;
                }
                $tempFixScriptArray[] = $value;
        }
        return $tempFixScriptArray;
    }

    private function splitComma($tempArray)
    {
        //*** split textline by 。
        foreach ($tempArray as $value) {
            $tempSplitFixArray[] = preg_split("/。/", $value);
            foreach ($tempSplitFixArray as $valueFix) {
                $tempSplitedArray[] = $valueFix[0];
            }
            //*** !!!! if this unset remove crash!! 
            unset($tempSplitFixArray);
        }
        return $tempSplitedArray;
    }

    private function removeLatin1($tempArray)
    {

        //*** Latin-1 remove
        foreach ($tempArray as $value) {
            $length = mb_strlen($value);
            if($length < 10){
                continue;
            }
            $bool = preg_match("/ã/", $value);
            if($bool){
                continue;
            }
            $bool = preg_match("/å/", $value);
            if($bool){
                continue;
            }
            $bool = preg_match("/æ/", $value);
            if($bool){
                continue;
            }
            $bool = preg_match("/ç/", $value);
            if($bool){
                continue;
            }
            $bool = preg_match("/ä/", $value);
            if($bool){
                continue;
            }
            $tempShortFixArray[] = $value;
        }
    }
    public function getSiteUrl(){
        return $this->siteUrl;
    }
    public function getResult(){
        return $this->result;
    }
    public function getContextHost(){
        return $this->contextHost;
    }
}




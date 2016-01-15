<?php
namespace General;

class Db
{
    private $dbHandle;
    private $prepearSt;
    private $result;

    public function __construct()
    {
        $dsn = 'mysql:dbname=BruteForce;host=127.0.0.1';
        $user = 'root';
        $password = 'iop26tyufgh26asd';
        $this->dbHandle = new \PDO($dsn, $user, $password);
    }

    public function setPrepearSt($prepearSt)
    {
        $chkedPrepearSt     = $this->checkPlaceHolder($prepearSt);
        $arrayedPlaceHolder = $this->analyzedPrepearSt($chkedPrepearSt);

    }

    public function sqQuery($query)
    {
        $this->result = $this->dbHandle->query($query);
    }

    private function sqPrepear()
    {
        $prepear = $this->dbHandle->prepear($this->prepearSt);
    }

    public function checkPlaceHolder($prepearSt)
    {
        try{
            $isMatch = preg_match("/:[a-z0-9]+/", $prepearSt, $match);
            if($isMatch){
                return $prepearSt;
            }else{
                throw new \Exception("Missing PlaceHorder");
            }
        }catch(Exception $e){
            $e->getMessage();
        }
    }

    public function analyzedPrepearSt()
    {
        try{
            $isMatch = preg_match_all("/:[a-z0-9]+/", $this->prepearSt, $placeHolders, PREG_SET_ORDER);
            if($isMatch){
                foreach ($placeHolders as $value) {
                    $arrayedPlaceHolder[] = $value;
                }
                return $arrayedPlaceHolder;
            }else{
                throw new \Exception("prepear Analyzed error!");
            }
        }catch(\Exception $e){
            echo $e->getMessage();
        }
    }
}

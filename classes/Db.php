<?php
namespace General;


class Db
{
    private $dbHandle;
    private $result;
    public function __construct()
    {
        $this->dbHandle = new \PDO();
    }
    public function sqQuery($query)
    {
        $this->result = $this->dbHandle->query($query);
    }
    public function sqPrepear($prepearSt)
    {
        $prepear = $this->dbHandle->prepear($prepearSt);
    }
    public function analyzedPrepearSt($prepearSt)
    {
        try{
            $isMatch = preg_match_all("/:[a-z0-9]+/", $prepearSt, $placeHolders, PREG_SET_ORDER);
            if($isMatch){
                foreach ($placeHolders as $value) {
                    $rePlaceHolder[] = $value[1];
                }
                return $rePlaceHolder;
            }else{
                throw new Exception("prepear Analyzed error!");
            }
        }catch(\Exception $e){
            echo $e->getMessage();
        }
    }
}

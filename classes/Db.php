<?php
namespace General;


class Db
{
    private $dbHandle;
    private $result;
    public function __construct()
    {
        $dsn = 'mysql:dbname=BruteForce;host=127.0.0.1';
        $user = 'root';
        $password = 'iop26tyufgh26asd';
        $this->dbHandle = new \PDO($dsn, $user, $password);
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
                    $rePlaceHolder[] = $value;
                }
                return $rePlaceHolder;
            }else{
                throw new Exception("prepear Analyzed error!");
            }
        }catch(\Exception $e){
            echo $e->getMessage();
        }
        // debug_print_backtrace();
    }
}

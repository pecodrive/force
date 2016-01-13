<?php
namespace General;


class Db
{
    private $dbHandle;
    private $result;
    public function __construct()
    {
        $this->dbHandle = new PDO();
    }
    public function sqQuery($query)
    {
        $this->result = $this->dbHandle->query($query);
    }
    public function sqPrepear($prepearSt)
    {
        $prepear = $this->dbHandle->prepear($prepearSt);
    }
    public function fetchResult()
    {


    }
}

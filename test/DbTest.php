<?php
require 'vendor/autoload.php';
class DbTest extends PHPUnit_Framework_TestCase
{
    private $db;
    public function setUp()
    {
        $this->db = new General\Db();
    }
    public function testAnalyzedPrepearSt()
    {
        $placeHolders = $db->analyzedPrepearSt(":peco, :anino, :desini");

        var_dump($placeHolders);

    }


}

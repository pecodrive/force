<?php
require '/var/www/html/force/vendor/autoload.php';
class DbTest extends PHPUnit_Framework_TestCase
{
    private $db;
    public function setUp()
    {
        $this->db = new General\Db();
    }
    public function testAnalyzedPrepearSt()
    {
        $placeHolders = $this->db->analyzedPrepearSt("");
        $this->assertNotEmpty($placeHolders);
        //var_dump($placeHolders);
    }


}

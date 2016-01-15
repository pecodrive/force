<?php
require '/var/www/html/force/vendor/autoload.php';
class DbTest extends PHPUnit_Framework_TestCase
{
    private $db;
    public function setUp()
    {
        $this->db = new General\Db();
    }

    public function testCheckplaceHolder()
    {
        $prepearSt = $this->db->checkPlaceHolder("INSERT INTO REGISTRY (name, value) VALUES (:name, :value)");
        $this->assertRegExp("/:[a-z0-9]/", $prepearSt);
        var_dump($prepearSt);
        return $prepearSt;
    }
    /**
     * @depends testCheckplaceHolder
     */
    public function testAnalyzedPrepearSt($prepearSt)
    {
        $placeHolders = $this->db->analyzedPrepearSt($prepearSt);
        $this->assertNotEmpty($placeHolders);
        var_dump($placeHolders);
    }
}

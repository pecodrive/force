<?php
require 'vendor/autoload.php';
class DbTest extends PHPUnit_Framework_TestCase
{
    public function testAnalyzedPrepearSt()
    {
        $db = new General\Db();
        $placeHolders = $db->analyzedPrepearSt(":peco, :anino, :desini");

        var_dump($placeHolders);

    }


}

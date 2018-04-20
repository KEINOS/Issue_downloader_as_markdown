<?php
include_once('vendor/autoload.php');
include_once('src/Functions.php');

use PHPUnit\Framework\TestCase;

class FunctionsTest extends TestCase
{
    public function setUp()
    {
        //
    }

    public function test_assertTrue()
    {
        $this->assertTrue(is_array(fetch_option_default()));
        $this->assertTrue(is_string(fetch_option_default()));
    }

    public function test_2()
    {
        $this->assertTrue(is_array(fetch_option_default()));
    }


    /*
     * 未実装・テスト準備済みは`markTestIncomplete(理由)`メソッドを使う
     */
    public function test_unknown()
    {
        $this->markTestIncomplete('unknown関数は準備中です');
    }
}

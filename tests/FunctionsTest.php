<?php
include_once('vendor/autoload.php');
include_once('src/Functions.php');

use PHPUnit\Framework\TestCase;

class FunctionsTest extends TestCase
{

    public function setUp()
    {
        $this->array_sample1 = [
            'one' => true,
            'two' => false,
        ];
        $this->string_sample1 = 'sample1';
    }

    public function test_assertTrue()
    {
        $this->assertTrue(is_array(fetch_option_default()));
        $this->assertTrue(fetch_value($this->array_sample1, 'one'));
    }

    public function test_assertFalse()
    {
        $this->assertFalse(fetch_value($this->string_sample1, 'one'));
        $this->assertFalse(fetch_value($this->array_sample1, 'none'));
    }


    /*
     * 未実装・テスト準備済みは`markTestIncomplete(理由)`メソッドを使う
     */
    public function test_unknown()
    {
        $this->markTestIncomplete('unknown関数は準備中です');
    }
}

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
        $this->string_sample1  = 'sample1';
        $this->string_default1 = 'default1';
    }

    public function test_fetch_option_default()
    {
        $this->assertTrue(is_array(fetch_option_default()));
    }

    public function test_fetch_value()
    {
        $default = $this->string_default1;

        /* True is OK area */
        $this->assertTrue(fetch_value($this->array_sample1, 'one'));

        $value = fetch_value($this->array_sample1, 'none', $default);
        $this->assertTrue($default === $value);

        $value = fetch_value($this->string_sample1, 'one', $default);
        $this->assertTrue($default === $value);

        /* False is OK area */
        $this->assertFalse(fetch_value($this->string_sample1, 'one'));
        $this->assertFalse(fetch_value($this->array_sample1, 'none'));
    }

    /*
     * 未実装・テスト準備済みは`markTestIncomplete(理由)`メソッドを使う
     */
    public function test_unknown()
    {
        //$this->markTestIncomplete('unknown関数は準備中です');
    }
}

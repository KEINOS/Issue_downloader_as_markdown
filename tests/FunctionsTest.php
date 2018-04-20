<?php
include_once('vendor/autoload.php');
include_once('src/Functions.php');

use PHPUnit\Framework\TestCase;

/*  PHP >= ^7.0 は PHPUnit ^6.0 であるため PHP >= ^5.6 の対応バージョン
 *  である PHPUnit 5.7.x の上位互換用の親クラスを継承
 *   ref: https://qiita.com/tanakahisateru/items/ef9f4c9b8ca39e6d0ed8
 *   PHPUnit_Framework_TestCase -> TestCase
 * //class FunctionsTest extends PHPUnit_Framework_TestCase
 */

class FunctionsTest extends TestCase
{
    public function setUp()
    {
        //
    }

    /*
     * テストを行うメソッド名は「test*」
     */    
    public function test_return_message()
    {
        $message = 'Hello, World!';
        $result  = return_message($message);

        $this->assertTrue($result === 'Hello, World!');
    }


    /*
     * 未実装・テスト準備済みは`markTestIncomplete(理由)`メソッドを使う
     */    
    public function test_unknown()
    {
        $this->markTestIncomplete('unknown関数は準備中です');        
    }

}

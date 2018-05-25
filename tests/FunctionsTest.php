<?php
include_once('vendor/autoload.php');
include_once('src/Functions.php');

use PHPUnit\Framework\TestCase;

class FunctionsTest extends TestCase
{

    public function setUp()
    {
        // Warning も確実にエラーとして扱うようにする
        set_error_handler(function ($errno, $errstr, $errfile, $errline) {
            $msg  = 'Error #' . $errno . ': ';
            $msg .= $errstr . " on line " . $errline . " in file " . $errfile;
            throw new RuntimeException($msg);
        });

        $this->array_sample1 = [
            'one' => true,
            'two' => false,
        ];
        $this->string_sample1  = 'sample1';
        $this->string_default1 = 'default1';
    }

    public function testRequestApiIssue()
    {
        include_once('tests/test_request_api_issue.php.inc');
    }

    public function testFetchEndpointIssues()
    {
        include_once('tests/test_fetch_endpoint_issues.php.inc');
    }

    public function testFetchOptionDefault()
    {
        include_once('test_fetch_option_default.php.inc');
    }

    public function testFetchUrlRequest()
    {
        include_once('tests/test_fetch_url_request.php.inc');
    }

    public function testFetchValue()
    {
        include_once('tests/test_fetch_value.php.inc');
    }


    /*
     * 未実装・テスト準備済みは`markTestIncomplete(理由)`メソッドを使う
     */
    public function testUnknown()
    {
        //$this->markTestIncomplete('unknown関数は準備中です');
    }
}

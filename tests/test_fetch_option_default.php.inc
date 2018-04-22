<?php
/**
 * `fetch_option_default`関数の仕様テスト.
 *
 * この関数の要件のみをテスト。
 */

$result = fetch_option_default();

/* 型の確認 */
$this->assertInternalType('array',$result);

/* オプション配列の必須項目確認 */
$this->assertArrayHasKey('access_token',$result);
$this->assertArrayHasKey('name_repo_owner',$result);
$this->assertArrayHasKey('name_repo',$result);

<?php
/**
 * `fetch_value`関数の仕様テスト.
 *
 * この関数の要件のみをテスト。
 */

/* テストの準備 */
$option = [
    'name_repo_owner' => 'Qithub-BOT',
    'name_repo'       => 'Qithub-ORG',
];

/* テストの実行 */

// 処理実行
$result = request_api_issue($option);

// 要件1 PHP 配列で API のリクエスト結果を取得できるか
$this->assertInternalType('array', $result);

<?php
/**
 * `fetch_url_request`関数の仕様テスト.
 *
 * この関数の要件のみをテスト。
 */

/* テストデータの準備 */

// 引数１（標準 盛り）
$option1 = [
    'access_token'    => 'hogehoge',
    'name_repo_owner' => 'qithub-bot',
    'name_repo'       => 'sample_repo',
    'page'            => 1,
];
// 引数２（全部盛り）
$option2 = [
    'access_token'    => 'hogehoge',
    'name_repo_owner' => 'qithub-bot',
    'name_repo'       => 'sample_repo',
    'page'            => 2,
    'state'           => 'some',
    'sort'            => 'updated',
    'direction'       => 'des',
];
// 引数３（Minimum 盛り）
$option3 = [
    'access_token'    => 'hogehoge',
    'name_repo_owner' => 'qithub-bot',
    'name_repo'       => 'sample_repo',
];
// テストの正解データ１
$url_right1  = 'https://api.github.com';
$url_right1 .= '/repos/qithub-bot/sample_repo/issues?';
$url_right1 .= 'page=1&state=all&sort=created&direction=asc';
$url_right1 .= '&access_token=hogehoge';
// テストの正解データ２
$url_right2  = 'https://api.github.com';
$url_right2 .= '/repos/qithub-bot/sample_repo/issues?';
$url_right2 .= 'page=2&state=some&sort=updated&direction=des';
$url_right2 .= '&access_token=hogehoge';
// テストの正解データ３
$url_right3  = 'https://api.github.com';
$url_right3 .= '/repos/qithub-bot/sample_repo/issues?';
$url_right3 .= 'state=all&sort=created&direction=asc';
$url_right3 .= '&access_token=hogehoge';

/* テスト開始 */

// 関数の処理結果の読み込み
$result1 = fetch_url_request($option1);
$result2 = fetch_url_request($option2);
$result3 = fetch_url_request($option3);

/* 要件1 型の確認 */
$this->assertInternalType('string',$result1);
$this->assertInternalType('string',$result2);
$this->assertInternalType('string',$result3);

/* 要件2 出力結果の確認 */
$this->assertSame($url_right1,$result1);
$this->assertSame($url_right2,$result2);
$this->assertSame($url_right3,$result3);



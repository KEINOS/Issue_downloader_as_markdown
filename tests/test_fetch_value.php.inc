<?php
/**
 * `fetch_value`関数の仕様テスト.
 *
 * この関数の要件のみをテスト。
 */

/* テストの準備 */

// テストデータ１
$string_sample  = 'sample1';
$array_sample = [
    'one' => $string_sample,
    'two' => false,
];

/* テストの開始 */

// 要件1 型の確認
$key    = 'one';
$result = fetch_value($array_sample, $key);
$this->assertInternalType('string', $result);

// 要件2 指定されたキー名の値を返す
$key    = 'one';
$result = fetch_value($array_sample, $key);
$this->assertSame($array_sample[$key], $result);

// 要件3 キー名が存在しない場合はデフォルト値を返す
$key     = 'none';
$default = 'default';
$result  = fetch_value($array_sample, $key, $default);
$this->assertSame($default, $result);

// 要件4 キー名が存在しない場合でデフォルト値がない場合は False を返す
$key    = 'none';
$result = fetch_value($array_sample, $key);
$this->assertFalse($result);

// 要件5 引数の型が違う場合はデフォルト値を返す
$key     = 'one';
$default = 'default';
$result  = fetch_value($string_sample, $key, $default);
$this->assertSame($default, $result);

// 要件6 引数の型が違う場合でデフォルト値がない場合は False を返す
$key    = 'one';
$result = fetch_value($string_sample, $key);
$this->assertFalse($result);




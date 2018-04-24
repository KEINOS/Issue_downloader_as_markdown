[![Build Status](https://travis-ci.org/KEINOS/GitHub_Issue-DL-As-MD.svg?branch=master)](https://travis-ci.org/KEINOS/GitHub_Issue-DL-As-MD)
![PHP Tested](https://img.shields.io/badge/PHP%20Tested-5.6.35-brightgreen.svg)
![PHP Tested](https://img.shields.io/badge/PHP%20Tested-7.1.12-brightgreen.svg)
![PHP Tested](https://img.shields.io/badge/PHP%20Tested-7.1.14-brightgreen.svg)
![PHP Tested](https://img.shields.io/badge/PHP%20Tested-7.2.4-brightgreen.svg)

## GitHub Issue Downloader As Markdown File

PHP で GitHub の issue を Markdown 形式のファイルでダウンロードするスクリプトです。

## 目的

GitHub の issue を閉鎖しないといけなくなった場合など、過去の事例の設置先として **issue を wiki に転載するため**に一括ダウンロードします。

## 用途

[GitHub の Wiki も１つの個別リポジトリになっている](https://help.github.com/articles/adding-and-editing-wiki-pages-locally/)ので、Wiki を `clone` して `push` するとローカルからも Wiki を更新することができます。

その仕組みを利用し、Markdown 形式で一括ダウンロードした issue を `clone` した Wiki のリポジトリに保存して `push` すれば、簡単に Wiki に反映できます。

## ディレクトリ構成

```
GitHub_Issue-DL-As-MD/
	┣━ README.md （このファイル）
	┣━ .git/ （このリポジトリの git 情報）
	┣━ .gitignore （git 同期で除外するファイル／ディレクトリを指定）
	┣━ .travis.yum （Travis CI の設定ファイル。実行チェック）
	┣━ sideci.yum （Side CI の設定ファイル。書式チェック）
	┣━ composer.json （PHPUnit インストール用 Composer 設定ファイル）
	┣━ composer.lock （検証時の Composer 環境再現ファイル）
	┣━ src/ （メインとなるソースコード）
	┃	┣━ index.php （本体の実行ファイル）
	┃	┣━ Functions.php （ユーザ関数一覧）
	┃	┣━ （option_settings.json）（実行後作成されるユーザ設定ファイル）
	┃	┣━ （issues/）（実行後作成される issue の MD ファイル出力先ディレクトリ）
	┃	┗━ （issues_json/）（実行後作成される issue の JSON ファイル出力先ディレクトリ）
	┗━ test/ （Travis CI で実行するテスト）
		┗━ FunctionsTest.php
```

## 実行方法

1. `src/index.php` を実行。`$ php src/index.php`
1. 設定ファイル `src/option_settings.json` が作成されるので設定情報を記載する。
    - `access_token`：GitHub の personal access token
    - `name_repo`：抜き出したい Issue のリポジトリ名
    - `name_repo_owner`：リポジトリのオーナー名
    - `https://github.com/NAME_REPO_OWNER/NAME_REPO`の場合
        - `name_repo` -> `NAME_REPO`
        - `name_repo_owner` -> `NAME_REPO_OWNER`
1. `src/index.php` を再実行
1. 出力された Issues を確認する。
    - `src/issues/` -> Issues の Markdown ファイル出力先
    - `src/issues_json/` -> Issues の JSON ファイル出力先

## 検証環境

このスクリプトは以下の環境で動作検証しています。

- macOS High Sierra (OSX 10.13.4)
    - PHP 7.1.14 (cli)
    - PHPUnit v.5.0.10 via Composer



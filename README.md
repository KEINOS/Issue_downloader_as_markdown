[![Build Status](https://travis-ci.org/KEINOS/GitHub_Issue-DL-As-MD.svg?branch=master)](https://travis-ci.org/KEINOS/GitHub_Issue-DL-As-MD)

## GitHub Issue Downloader As Markdown File

PHP で GitHub の issue を Markdown 形式のファイルでダウンロードするスクリプトです。

## 目的

GitHub の issue を閉鎖しないといけなくなった場合など、過去の事例の設置先として **issue を wiki に転載するため**に一括ダウンロードします。

[GitHub の Wiki も１つの個別リポジトリになっている](https://help.github.com/articles/adding-and-editing-wiki-pages-locally/)ので、`clone` して `push` するとローカルから Wiki を更新することができます。

そのため、Markdown 形式で一括ダウンロードした issue であれば、簡単に Wiki に反映できることを期待します。

## ディレクトリ構成

```
GitHub_Issue-DL-As-MD/
	┣━ README.md （このファイル）
	┣━ .git/ （このリポジトリの git 情報）
	┣━ .gitignore/ （git 同期で除外するファイル／ディレクトリを指定）
	┣━ .travis.yum （Travis CI の設定ファイル）
	┣━ composer.json （PHPUnit インストール用 Composer 設定ファイル）
	┣━ composer.lock （検証時の Composer 環境再現ファイル）
	┣━ src/ （メインとなるソースコード）
	┃	┣━ index.php
	┃	┣━ Functions.php （ユーザ関数一覧）
	┃	┗━ Classes.php （クラス一覧）
	┗━ test/ （Travis CI で実行するテスト）
		┣━ FunctionsTest.php
		┗━ ClassesTest.php
```

## 検証環境

このスクリプトは以下の環境で動作検証しています。

- macOS High Sierra (OSX 10.13.4)
    - PHP 7.1.14 (cli)
    - PHPUnit v.5.0.10 via Composer



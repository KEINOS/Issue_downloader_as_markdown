[![Build Status](https://travis-ci.org/KEINOS/Practice_Travis-CI.svg?branch=master)](https://travis-ci.org/KEINOS/Practice_Travis-CI)

## Travis CI's PHP Template with PHPUnit

とりあえず [Travis CI](https://ja.wikipedia.org/wiki/Travis_CI) で動く [PHPUnit](https://phpunit.de/manual/current/ja/) テスト付き「Hello World」の PHP テンプレート。

## 目標

1. 当リポジトリをコピーするだけで Travis CI のテストが通るテンプレートの作成。
2. 「Hello World」から徐々に実装できるようなシンプルなテンプレートであること。
3. クラスやメソッド中心でなく、関数（`functions`）のテストができるようなもの。

## 検証環境

以下の環境で動作した PHP スクリプトを Travis CI で PHPUnit テストを通します。

- macOS High Sierra (OSX 10.13.4)
    - PHP 7.1.14 (cli)
- Raspbian Jessie (Debian GNU/Linux 8.0)
    - PHP 7.1.12 (cli)
- CentOS 7.4.1708 (Redhat Linux, Core) 
    - PHP 5.6.35 (cli) 
    - PHP 7.2.4 (cli)

- PHPUnit v.5.0.10 via Composer
    - PHP 5.6, 7.0, 7.1 コンパチは PHPUnit 5 であるため

## ディレクトリ構成

```
Practice_Travis-CI/
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

## テンプレートの使い方

1. GitHub と [Travis CI](https://travis-ci.org/) にアカウントを作成する。
1. GitHub に空のリポジトリを作成する。
1. Travis CI 上で作成した GitHub のリポジトリを追加する。
1. 作成した GitHub リポジトリをローカルにクローンする。
1. クローンしたローカル・リポジトリ内に、この[リポジトリをダウンロード](https://github.com/KEINOS/Practice_Travis-CI/archive/master.zip)、解凍したものを移動する。
1. 移動したファイルやディレクトリをコミットする（イニシャルコミット）
1. リモート（GitHub）にマージ後プッシュ／プルリクエストします。
1. Travis CI が連動してテストを始めるのを確認します。


## ローカルにテスト環境を作る

1. 自分の環境の PHP バージョンを確認します。
1. カレントディレクトリをクローンしたリポジトリに移します。
1. `.travis.yml` に自分の PHP バージョンを追記します。
1. `composer.lock` ファイルを削除します。（`$ rm composer.lock`）
1. `composer` コマンドが使えるのを確認します。（`$ composer --version`）
1. PHPUnit をインストールする。
    - `$ composer update`
    - `$ composer install`
1. `vendor` ディレクトリが出来たのを確認し、PHPUnit のバージョンを確認する。
    - `$ vendor/bin/phpunit --version`
1. `tests` ディレクトリ内のテストを実行する。
    - `$ vendor/bin/phpunit tests`
    - 「OK, but incomplete, skipped, or risky tests!」と出れば OK。記述中の「..I」は、３つのテストのうち２つがパスして１つをスキップしたことを意味します。







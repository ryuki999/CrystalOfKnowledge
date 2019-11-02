# CrystalOfKnowledge
こちらは読書記録管理システムです。
日ごろの読書記録を付け、書籍の管理・感想のまとめを行い、登録ユーザ間で読書記録の共有やモチベーションの維持を目的としている。
ユーザは複数人を想定。
- 新規登録時:メール認証 → ユーザ名・パスワードの登録を行う。
- ログイン後:ユーザ情報確認・他ユーザ確認・他ユーザ登録本確認・本検索と本登録・登録本リスト・登録本詳細
  - ユーザ情報画面で登録冊数と読了ページ総数を表示。
  - 他ユーザ確認で当システムに登録されているユーザを確認。
  - 他ユーザ登録本確認でそのユーザが登録している本の情報やコメントなどが確認できる。
  - 本検索にはGoogleBooksApiを利用。
  - 登録本リストではログイン中のユーザが登録している本を一覧表示。
  - 登録本詳細ではログイン中のユーザが登録している本の情報やコメントの確認・編集が出来る。


# Screen shot
![read2](https://github.com/ryuki999/CrystalOfKnowledge/blob/master/img/read2.JPG)
#
![read1](https://github.com/ryuki999/CrystalOfKnowledge/blob/master/img/read1.JPG)


# Dependency
PHP 7.3

html

Mysql 5.6.23

used php libraries: phpmailer

# Authors
- Github: [ryuki999](https://github.com/ryuki999)

# License
This software is released under the MIT License, see LICENSE.

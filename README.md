# CrystalOfKnowledge
こちらは読書記録管理システムです。
日ごろの読書記録を付け、書籍の管理・感想のまとめを行い、登録ユーザ間で読書記録の共有やモチベーションの維持を目的としている。
ユーザは複数人を想定。
- 新規登録時 : メール認証 → ユーザ名・パスワードの登録を行う。
- ログイン後 :
  - 1.ユーザ情報画面 : 登録冊数と読了ページ総数を表示。
  - 2.他ユーザ確認 : 当システムに登録されているユーザを確認。
  - 3.他ユーザ登録本確認 : そのユーザが登録している本の情報やコメントなどが確認できる。
  - 4.本検索 : GoogleBooksApiを利用。
  - 5.登録本リスト : ログイン中のユーザが登録している本を一覧表示。
  - 6.登録本詳細 : ログイン中のユーザが登録している本の情報やコメントの確認・編集が出来る。


# Screen shot
![read2](https://github.com/ryuki999/CrystalOfKnowledge/blob/master/img/read2.JPG)
#
![read1](https://github.com/ryuki999/CrystalOfKnowledge/blob/master/img/read1.JPG)


# Requirement
PHP 7.3

html

Mysql 5.6.23

used php libraries: phpmailer

# Authors
- Github: [ryuki999](https://github.com/ryuki999)

# License
This software is released under the MIT License, see LICENSE.

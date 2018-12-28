# AMS2
AMS2 Auto Make SlideShow

## DB - DataBase
画像を保存しているホスト名やそのファイル名、ユーザ情報、アクセス情報を保存する。
PHPプログラムにPOSTを送って操作する。

## ID - ImageDisplay
スライドショーを表示するページ。定期的にISへ画像を要求する。

## IS - ImageSave
IUから送られてきた画像の保存。IDから要求されたときに画像を返すサーバ

## IU - ImageUpload
画像をアップロードするページ。
ISのsave.phpにPOSTで画像を送信する。

## 使い方
- LAMPサーバを構築する。
- 各ディレクトリにあるconfig.phpにIPアドレスなどの設定を記入しドキュメントルートに設置する。  
- DBサーバではcreate.sqlにあるCREATE文を実行しデータベースとテーブルを作成する。

また以下のようにデータベース接続用のユーザを作成する
`grant all on AMS2.* to dbuser@localhost identified by 'password';`

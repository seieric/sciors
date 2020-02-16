# Sciors
This is simple PHP url shortener. Everyone can host one on your web server.
簡単なPHPの短縮URL生成プログラム。誰でも、自分のWEBサーバーでホストできます。

# License
MIT

# Usage
1. Clone or download ZIP and upload files on your server.
クローンするかZIPをダウンロードして、ファイル群をサーバにアップロードしてください。
2. Access install.php with your web browser.(ex. https://example.com/)
ブラウザでinstall.phpにアクセスしてください。
3. Fill the blanks to configure MySQL.
MySQLの設定を空欄に入力してください。
4. If installation succeeds, you will see "Successfully installed Sciors!"
インストールが成功すると、成功を示すメッセージが表示されます。
5. Access set.php and generate your short url.
set.phpにアクセスして短縮URLを生成してください。
### WARNING
As there is no authorization for generating short urls, so please control access to set.php by using basic auth or diget auth.
短縮URLの生成に認証がなく、だれでも使えてしまうので、ベーシック認証や、ダイジェスト認証でset.phpにアクセスできないように設定してください。

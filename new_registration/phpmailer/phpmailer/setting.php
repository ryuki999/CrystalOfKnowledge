<?php

// メール情報
// メールホスト名・gmailでは smtp.gmail.com
//define('MAIL_HOST','smtp.gmail.com');
define('MAIL_HOST','smtp.lolipop.jp');

// メールユーザー名・アカウント名・メールアドレスを@込でフル記述
//define('MAIL_USERNAME','****************');
define('MAIL_USERNAME','***********');

// メールパスワード・上で記述したメールアドレスに即したパスワード
//define('MAIL_PASSWORD','***********');
define('MAIL_PASSWORD','***********');

// SMTPプロトコル(sslまたはtls)
define('MAIL_ENCRPT','ssl');

// 送信ポート(ssl:465, tls:587)
define('SMTP_PORT', 465);

// メールアドレス・ここではメールユーザー名と同じでOK
//define('MAIL_FROM','***************');
define('MAIL_FROM','**************');

// 表示名
define('MAIL_FROM_NAME','FURUKAWA RYUKI');

// メールタイトル
define('MAIL_SUBJECT','お問い合わせいただきありがとうございます');


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

        <!-- Styles -->
        
    </head>
    <body>
        <div>
            <p>ログイン</p>
            <p>メールアドレス</p>
            <input type="text" value="メールアドレス">
            <p>パスワード</p>
            <input type="text" value="パスワード">
            <input type="submit" value="ログイン">
            <a href="">アカウントをお持ちでない方はこちら</a>
        </div>
    </body>
</html>

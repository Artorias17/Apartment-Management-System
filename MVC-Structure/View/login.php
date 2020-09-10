<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href='/<?php echo $dir?>'/>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald&display=swap" rel="stylesheet">

    <title>User Login</title>
</head>
<body>
    <div class="c">
        <div class="login-box">
            <h1>LOGIN</h1>
                <form method="post" action="<?php echo baseURL?>/UserController/login">
                <div class="textbox">
                    <input type="text" placeholder="USERNAME" name="user" value="" required>
                </div>

                <div class="textbox">
                    <input type="password" placeholder="PASSWORD" name="pass" value="" required>
                </div>

                <input id="btn" class="btn" type="submit" name="send" value="Sign In">
            </form>
        </div>
    </div>
</body>
</html>

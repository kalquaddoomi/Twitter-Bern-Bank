<?php
/**
 * Created by PhpStorm.
 * User: khaled
 * Date: 2/21/16
 * Time: 10:12 AM
 */

session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tweet For Bernie</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            display: table;
            font-weight: 100;
            font-family: 'Lato';
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 96px;
        }
        .subtitle {
            font-size: 36px;
            width:80%;
            padding-left:10%;
            padding-right:10%;
            margin-top:20px;
        }
        .signup-login input {
            background-color: deeppink;
            color:white;
            margin-top:20px;
            width:40%;
            font-size:36px;
            font-weight: bold;
            font-family: 'Lato';
            height:70px;
            -webkit-border-radius: 15px;
            -moz-border-radius: 15px;
            border-radius: 15px;
            cursor:pointer;
            outline:none;

        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        <div class="title">Tweet For Bernie</div>
        <div class="subtitle">
            Help mobilize your friends and get the vote out for Bernie Sanders by reminding friends to register, and go caucus or vote. Log in to your Twitter account to start.
        </div>
        <div class="signup-login">
            <form action="<?php echo (isset($_SESSION['access_token']) ? "/app/index.php" : "/app/login_to_twitter.php"); ?>" method="get">
                <input type="submit" value="Get Started!" />
            </form>
        </div>
    </div>
</div>
</body>
</html>


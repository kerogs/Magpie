<?php

$type = $_GET['t'];

$serverConfig = json_decode(file_get_contents("./data/serverconfig.json"), true);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <base href="/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Magpie | <?= $type ?></title>
    <link rel="stylesheet" href="./src/css/login.css">

    <?php require_once './src/php/head.php' ?>
</head>

<body>

    <div class="login-go-index">
        <p><a href="./">GGA<b>CHI</b></a></p>
    </div>

    <div class="login-select">
        <?php

        echo $serverConfig['server']['signinWithAccountKey'] ? '<a href="/login/accountkey"><button>Account Key</button></a>' : "";
        echo $serverConfig['server']['signinWithPassword'] ? '<a href="/login/password"><button>Sign in</button></a>' : "";
        echo $serverConfig['server']['registerAccount'] ? '<a href="/login/register"><button>Register</button></a>' : "";

        ?>
    </div>

    <?php



    ?>
    <div class="login">

        <?php

        // password
        if ($type == 'password') {
            if ($serverConfig['server']['signinWithPassword'] == true) {
                echo '
                        <h2>Sign in to your account</h2>
                        <h3>With an password</h3>

                        <form action=" login-send.php" method="post">
                        <p class="label">Username</p>
                        <input type="text" name="username" maxlength="18" id=""   required>

                        <p class="label">Password</p>
                        <input type="password" name="password" maxlength="30" id=""   required>

                        <button type="submit">Sign in</button>
                        <p class="change"><a href="/login/register">I don\'t have an account</a></p>
                    </form>
                ';
                if ($serverConfig['server']['signinWithAccountKey'] == true) {
                    echo '
                        <a class="alt" href="/login/accountkey"><button>Use a key</button></a>
                    ';
                }
            } else {
                echo '
                    <p>NunaLab administrator has disabled password sign in.</p>
                    ';

                if ($serverConfig['server']['signinWithAccountKey'] == true) {
                    echo '
                        <a class="alt" href="/login/accountkey"><button>Use a Key</button></a>
                    ';
                }
            }
        }
        // accountkey
        if ($type == 'accountkey') {
            if ($serverConfig['server']['signinWithAccountKey'] == true) {
                echo '
                        <h2>Sign in to your account</h2>
                        <h3>With an account key</h3>

                        <form action=" login-send.php" method="post">
                        <p class="label">Account Key</p>
                        <input type="password" name="key" maxlength="30" id=""   required>

                        <button type="submit">Sign in</button>
                        <p class="change"><a href="/login/register">I don\'t have an account</a></p>
                    </form>
                ';
                if ($serverConfig['server']['signinWithPassword'] == true) {
                    echo '
                        <a class="alt" href="/login/password"><button>Use a password</button></a>
                    ';
                }
            } else {
                echo '
                    <p>NunaLab administrator has disabled account key sign in.</p>
                    ';

                if ($serverConfig['server']['signinWithPassword'] == true) {
                    echo '
                        <a class="alt" href="/login/password"><button>Use a password</button></a>
                    ';
                }
            }
        }

        // register
        if ($type == 'register') {
            if ($serverConfig['server']['registerAccount'] == true) {
                echo '
                    <h2>Create an account</h2>
        
                        <form action=" login-send.php" method="post">
                        <p class="label">Username</p>
                        <input type="text" name="username" maxlength="18" id=""   required>

                        <p class="label">Password</p>
                        <input type="password" name="password" maxlength="30" id=""   required>

                        <input type="hidden" name="register" value="true">
        
                        <button type="submit">Register</button>
                        <p class="change"><a href="/login/password">I already have an account, sign in</a></p>
                    </form>
                ';
            } else {
                echo '
                    <p>NunaLab administrator has disabled register.</p>
                ';
            }
        }

        // error
        if ($type == "error") {
            echo '
                <h2>Error</h2>
                <h3>Something has just happened</h3>
                <p>'.$_GET['m'].'</p>
            ';
        }

        ?>
    </div>

</body>

</html>
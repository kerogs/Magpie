<?php

require_once __DIR__ . '/src/php/core.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Magpie</title>

    <link rel="stylesheet" href="./src/css/style.css">

    <?php require_once __DIR__ . '/src/php/inc/head.php'; ?>
</head>

<body>

    <main>
        <?php require_once './src/php/inc/header.php'; ?>
        <div class="content">
            <div class="sub_content">

                <div class="banner" style="background-image: url(<?= $userBanner ?>);">
                    <div class="filter">
                        <div class="message">
                            Welcome back, <a href=""><?= $userName ?></a>
                        </div>
                    </div>
                </div>

                <div class="content_padding">

                

                </div>

            </div>
        </div>
    </main>

</body>

</html>
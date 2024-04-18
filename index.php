<?php

require_once __DIR__ . '/src/php/core.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GGACHI</title>

    <link rel="stylesheet" href="./src/css/style.css">

    <?php require_once __DIR__ . '/src/php/head.php'; ?>
</head>

<body>

    <main>
        <div class="nav">
            <div class="website">
                <div class="logo"><a href="./"><img src="./src/img/icon_white.svg" alt=""></a></div>
                <div class="information">
                    <div class="subtitle">GGACHI</div>
                    <div class="title">Home</div>
                </div>
                <div class="listbtn">
                    <i class='bx bx-arrow-from-right'></i>
                </div>
            </div>

            <nav>
                <ul>
                    <a href="./">
                        <li class="active"><i class='bx bxs-dashboard'></i>
                            <p>Home</p>
                        </li>
                    </a>
                    <a href="./">
                        <li class="admin"><i class='bx bxs-castle'></i>
                            <p>Settings</p>
                            <p class="admin">ADMIN</p>
                        </li>
                    </a>
                </ul>
            </nav>

            <div class="account">
                <div class="account__in" style="background-image:url(<?= $userPfp ?>)">
                    <div class="filter">
                        <div class="account__container">
                            <div class="img">
                                <img src="<?= $userPfp ?>" alt="">
                            </div>
                            <div class="name">
                                <p class="username"><?= $userName ?></p>
                                <p class="role"><?= $userRole ?></p>
                            </div>
                        </div>
                        <div class="account__buttons">
                            <div class="version"><a href="https://github.com/kerogs/ggachi" target="_blank"><?= $websiteVersion ?></a></div>
                            <div class="btn"><a href=""><i class='bx bx-cog'></i> Settings</a></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
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

                    <div class="topContent">
                        <!-- calendar -->
                        <div class="calendar">
                            <div class="calendar__header">
                                <h2>Calendar <span id="month">loading...</span></h2>
                                <div class="btn">
                                    <button id="before"><i class='bx bx-chevron-left'></i></button>
                                    <button id="after"><i class='bx bx-chevron-right'></i></button>
                                </div>
                            </div>
                            <div class="header">
                                <div class="day">Lun.</div>
                                <div class="day">Mar.</div>
                                <div class="day">Mer.</div>
                                <div class="day">Jeu.</div>
                                <div class="day">Ven.</div>
                                <div class="day">Sam.</div>
                                <div class="day">Dim.</div>
                            </div>
                            <div class="days">
                                <p class="loadingMsg">Loading...</p>
                            </div>
                        </div>

                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                const daysContainer = document.querySelector('.days');
                                const beforeButton = document.querySelector('#before');
                                const afterButton = document.querySelector('#after');

                                let currentDate = new Date();
                                let currentMonth = currentDate.getMonth();
                                let currentYear = currentDate.getFullYear();

                                renderCalendar(currentYear, currentMonth);

                                function renderCalendar(year, month) {
                                    // Clear previous days
                                    daysContainer.innerHTML = '';

                                    // Get the first day of the month
                                    const firstDay = new Date(year, month, 1);
                                    let startingDay = firstDay.getDay();

                                    // Adjust starting day to start from Monday
                                    startingDay = (startingDay === 0) ? 6 : startingDay - 1;

                                    // Get the number of days in the month
                                    const daysInMonth = new Date(year, month + 1, 0).getDate();

                                    // Get the name of the month
                                    const monthName = new Intl.DateTimeFormat('en-US', {
                                        month: 'long'
                                    }).format(firstDay);

                                    // Update the month element
                                    document.getElementById('month').textContent = monthName;

                                    // Render the days
                                    for (let i = 0; i < startingDay; i++) {
                                        const emptyDay = document.createElement('div');
                                        emptyDay.classList.add('empty');
                                        daysContainer.appendChild(emptyDay);
                                    }

                                    for (let day = 1; day <= daysInMonth; day++) {
                                        const dayElement = document.createElement('div');
                                        dayElement.classList.add('day');
                                        const numberElement = document.createElement('div');
                                        numberElement.classList.add('number');
                                        numberElement.textContent = day;
                                        dayElement.appendChild(numberElement);
                                        daysContainer.appendChild(dayElement);
                                    }
                                }

                                beforeButton.addEventListener('click', function() {
                                    currentMonth -= 1;
                                    if (currentMonth < 0) {
                                        currentMonth = 11;
                                        currentYear -= 1;
                                    }
                                    renderCalendar(currentYear, currentMonth);
                                });

                                afterButton.addEventListener('click', function() {
                                    currentMonth += 1;
                                    if (currentMonth > 11) {
                                        currentMonth = 0;
                                        currentYear += 1;
                                    }
                                    renderCalendar(currentYear, currentMonth);
                                });
                            });
                        </script>

                        <!-- playlist video streaming -->
                        <?php

                        // ? check if user playlist exists in the user.json file
                        if (!isset($accountJSON['playlist'])) {
                            // ? if not, do nothing, else display the playlist with the container
                        } else {
                            // detect first if link is youtube or not
                            if (strpos($accountJSON['playlist'], 'youtube.com') !== false) {
                                $playlistClass = 'youtube';
                            }

                            echo '
                                <div class="playlist ' . $playlistClass . '">
                                    <div class="tempMSG">Loading <br> <i class="bx bx-loader bx-spin"></i></div>
                                    <div class="iframe"> ' . $accountJSON['playlist'] . '</div>
                                </div>
                                ';
                        }

                        ?>
                    </div>

                    <hr class="sep">

                    <div class="grid-app">

                    </div>

                </div>

            </div>
        </div>
    </main>

</body>

</html>
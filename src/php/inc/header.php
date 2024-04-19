<div class="nav">
            <div class="website">
                <div class="logo"><a href="./"><img src="./src/img/icon_white.svg" alt=""></a></div>
                <div class="information">
                    <div class="subtitle">Magpie</div>
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
                            <div class="version"><a href="https://github.com/kerogs/Magpie" target="_blank"><?= $websiteVersion ?></a></div>
                            <div class="btn"><a href=""><i class='bx bx-cog'></i> Settings</a></div>
                        </div>
                    </div>
                </div>
            </div>
</div>
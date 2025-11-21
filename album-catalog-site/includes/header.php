<header>


    <?php
    // Ensure variables are defined
    if (!isset($nav_detail)) {
        $nav_detail = false;
    }
    if (!isset($nav_add)) {
        $nav_add = false;
    }
    ?>
    <div class="nav-left">
        <?php if ($nav_detail || $nav_add) { ?>
            <a class="back-arrow" href="/albums">
                &#10140;
            </a>
        <?php } ?>

        <h1 id="title"><?php echo htmlspecialchars($title); ?></h1>
    </div>

    <nav id="menu">
        <ul class="nav">
            <?php if (!$nav_add) { ?>

                <?php if (!is_user_logged_in()) { ?>
                    <li class="float-right"><a href="/login">Log In</a></li>
                <?php } else { ?>

                    <li class="float-right"><a href="<?php echo logout_url(); ?>">Log Out</a></li>

                    <li class="float-right"><a href="/add">Add Album</a></li>
                <?php } ?>
            <?php } ?>
        </ul>
    </nav>
</header>

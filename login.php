<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" type="text/css" href="/public/styles/site.css" media="all">

    <title>Log In</title>
</head>

<body class="login_page">

    <?php if (is_user_logged_in()) { ?>
        <p>Welcome <strong><?php echo htmlspecialchars($current_user['name']); ?></strong>!</p>

        <p>click <a href="/albums">here</a> to return to your browsing.</p>
    <?php } else { ?>

        <h1>Log In</h1>


    <?php
        echo login_form('/login', $session_messages);
    } ?>


</body>

</html>

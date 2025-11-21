<?php

$add = 'active_page';
define("MAX_FILE_SIZE", 1000000);


$form_feedback_classes = array(
    'artist' => 'hidden',
    'title' => 'hidden',
    'genre' => 'hidden',
    'user' => 'hidden'
);

$form_values = array(
    'artist' => '',
    'title' => '',
    'genre' => '',
    'user' => ''
);

$sticky_values = array(
    'artist' => '',
    'title' => '',
    'pop' => '',
    'alt' => '',
    'r&b' => '',
    'rap' => '',
    'kpop' => '',
    'both' => '',
    'user' => ''
);

$insert_values = array(
    'artist' => NULL,
    'title' => NULL,
    'genres' => NULL,
    'user' => NULL,
);

$db = init_sqlite_db('db/site.sqlite', 'db/init.sql');

// $reslit = exec_sql_query($db, 'SELECT * FROM eng_courses;');

// $records = $reslit->fetchAll();

if (isset($_POST['insert'])) {


    $form_values['artist'] = trim($_POST['artist']);
    $form_values['title'] = trim($_POST['title']);
    $form_values[''] = ($_POST['genres'] == '' ? NULL : (int)$_POST['genres']);
    $form_values['user'] = trim($_POST['user']);

    $form_valid = True;

    if ($form_values['artist'] == '') {
        $form_valid = False;
        $form_feedback_classes['artist'] = '';
    }

    if ($form_values['title'] == '') {
        $form_valid = False;
        $form_feedback_classes['title'] = '';
    }


    if ($form_values['genres'] == '') {
        $form_valid = False;
        $form_feedback_classes['genres'] = '';
    }

    if ($form_values['user'] == '') {
        $form_valid = False;
        $form_feedback_classes['user'] = '';
    }

    if ($form_valid) {

        $insert_values['artist'] = ($_POST['artist'] == '' ? NULL : $_POST['artist']);
        $insert_values['title'] = ($_POST['title'] == '' ? NULL : $_POST['title']);
        $insert_values['genres'] = ($_POST['genres'] == '' ? NULL : (int)$_POST['genres']);
        $insert_values['user'] = ($_POST['user'] == '' ? NULL : $_POST['user']);

        $result = exec_sql_query(
            $db,
            "INSERT INTO eng_courses (course_code, course_title, genres_offered, credits, user) VALUES (:course_code, :course_title, :genres_offered, :credits, :user);",
            array(
                ':course_code' => $insert_values['artist'],
                ':course_title' => $insert_values['title'],
                ':genres_offered' => $insert_values['genres'],
                ':user' => $insert_values['user']
            )
        );

        $show_confirmation = True;
    } else {
        $sticky_values['artist'] = $form_values['artist'];
        $sticky_values['title'] = $form_values['title'];
        $sticky_values['pop'] = ($form_values['genres'] ? 'checked' : '');
        $sticky_values['alt'] = ($form_values['genres'] ? 'checked' : '');
        $sticky_values['rap'] = ($form_values['genres'] ? 'checked' : '');
        $sticky_values['r&b'] = ($form_values['genres'] ? 'checked' : '');
        $sticky_values['kpop'] = ($form_values['genres'] ? 'checked' : '');
        $sticky_values['user'] = $form_values['user'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" type="text/css" href="/public/styles/site.css" media="all">

    <title>Add Your Own</title>
</head>

<body>
    <?php include 'includes/header.php'; ?>

    <h1>Add Your Own</h1>

    <main>

        <form action="/insert" method="post" enctype="multipart/form-data">

            <div class="form-in">
                <p class="feedback <?php echo $form_feedback_classes['artist']; ?>">Please provide a course code.</p>
                <div class="label-input">
                    <label for="code_field">Artist:</label>
                    <input id="code_field" type="text" name="code" value="<?php echo $sticky_values['artist']; ?>">
                </div>
            </div>

            <div class="form-in">
                <p class="feedback <?php echo $form_feedback_classes['title']; ?>">Please provide a course title.</p>
                <div class="label-input">
                    <label for="title_field">Album Title:</label>
                    <input id="title_field" type="text" name="title" value="<?php echo $sticky_values['title']; ?>">
                </div>
            </div>

            <div class="form-in">
                <div id="feedback-genres" class="feedback <?php echo $form_feedback_classes['genres']; ?>">Please select one or more
                    genresester.</div>
                <div class="genres-group label-input" role="group" aria-labelledby="genres_head">
                    <div class="genres-label" id="genres_head">Genre(s):</div>
                    <div class="form-label">
                        <input type="radio" name="genres" id="fall-input" value="1" <?php echo $sticky_values['fall']; ?>>
                        <label for="fall-input">Fall</label>
                    </div>
                    <div class="form-label">
                        <input type="radio" name="genres" id="spring-input" value="2" <?php echo $sticky_values['spring']; ?>>
                        <label for="spring-input">Spring</label>
                    </div>
                    <div class="form-label">
                        <input type="radio" name="genres" id="both-input" value="3" <?php echo $sticky_values['both']; ?>>
                        <label for="both-input">Both</label>
                    </div>
                </div>
            </div>

            <div class="form-in">
                <p class="feedback <?php echo $form_feedback_classes['user']; ?>">Please provide any course users.</p>
                <div class="label-input">
                    <label for="user">Username:</label>
                    <input class="user" id="user" type="text" name="user" value="<?php echo $sticky_values['user']; ?>">
                </div>
            </div>

            <div class="form-in">
                <div class="align-right">
                    <button type="submit" name="insert"> Add Album </button>
                </div>
            </div>

        </form>

    </main>

</body>

</html>

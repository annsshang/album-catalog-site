<?php

$title = "Add Your Album";

$nav_add = True;

$show_confirmation = False;


define("MAX_FILE_SIZE", 1000000);

$upload_feedback = array(
    'general_error' => False,
    'too_large' => False
);

$insert_values = array(
    'artist' => NULL,
    'title' => NULL,
    'user' => NULL
);

$genre_values = array();

$upload_source = NULL;
$upload_file_name = NULL;
$upload_file_ext = NULL;


if (isset($_POST['insert'])) {

    $upload_source = trim($_POST['source']);
    if (empty($upload_source)) {
        $upload_source = NULL;
    }

    $upload = $_FILES['jpg-file'];

    $form_valid = True;

    if ($upload['error'] == UPLOAD_ERR_OK) {

        $upload_file_name = basename($upload['name']);

        $upload_file_ext = strtolower(pathinfo($upload_file_name, PATHINFO_EXTENSION));

        if (!in_array($upload_file_ext, array('jpg'))) {
            $form_valid = False;
            $upload_feedback['general_error'] = True;
        }
    } else if (($upload['error'] == UPLOAD_ERR_INI_SIZE) || ($upload['error'] == UPLOAD_ERR_FORM_SIZE)) {
        $form_valid = False;
        $upload_feedback['too_large'] = True;
    } else {
        $form_valid = False;
        $upload_feedback['general_error'] = True;
    }

    if ($form_valid) {

        $show_confirmation = True;

        $insert_values['artist'] = ($_POST['artist'] == '' ? NULL : $_POST['artist']);
        $insert_values['title'] = ($_POST['title'] == '' ? NULL : $_POST['title']);

        $insert_values['user'] = ($_POST['user'] == '' ? NULL : $_POST['user']);

        if (!empty($_POST['genres'])) {
            foreach ($_POST['genres'] as $selected) {
                array_push($genre_values, $selected);
            }


            $result = exec_sql_query(
                $db,
                "INSERT INTO albums (title, artist, user, file_name, file_ext, source) VALUES (:title, :artist, :user, :file_name, :file_ext, :source);",
                array(
                    ':artist' => $insert_values['artist'],
                    ':title' => $insert_values['title'],
                    ':user' => $insert_values['user'],
                    ':file_name' => $upload_file_name,
                    ':file_ext' => $upload_file_ext,
                    ':source' => $upload_source
                )

            );


            if ($result) {

                $record_id = $db->lastInsertId('id');


                foreach ($_POST['genres'] as $selected) {

                    $tag_result = exec_sql_query(
                        $db,
                        "INSERT INTO album_genres (album_id, genre_id) VALUES (:album_id, :genre_id);",
                        array(
                            ':album_id' => $record_id,
                            ':genre_id' => $selected
                        )
                    );
                }

                $upload_storage_path = 'public/uploads/albums/' . $record_id . '.' . $upload_file_ext;

                if (move_uploaded_file($upload["tmp_name"], $upload_storage_path) == False) {
                    error_log("Failed to permanently store the uploaded file on the file server. Please check that the server folder exists.");
                }
            }
        }
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


    <main>


        <?php if ($show_confirmation) { ?>
            <h1 class="confirm">Your album was successfully uploaded! Click <a href="/albums">here</a> to return to your browsing.</h1>
        <?php } else { ?>

            <form action="/add" method="post" enctype="multipart/form-data">
                <div class="insert">


                    <div class="file-up">

                        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>">

                        <?php if ($upload_feedback['too_large']) { ?>
                            <p class="feedback">We're sorry. The file failed to upload because it was too big. Please select a file that&apos;s no larger than 1MB.</p>
                        <?php } ?>

                        <?php if ($upload_feedback['general_error']) { ?>
                            <p class="feedback">We're sorry. Something went wrong. Please select an jpg file to upload.</p>
                        <?php } ?>

                        <div class="label-input">
                            <label for="upload-file">jpg File:</label>
                            <!-- This site only accepts jpg files! -->
                            <input id="upload-file" type="file" name="jpg-file" accept=".jpg,image/jpg+xml">
                        </div>
                        <div class="label-input">
                            <label for="upload-source" class="optional">Source URL:</label>
                            <input id='upload-source' type="url" name="source" placeholder="URL where found. (optional)">
                        </div>

                    </div>

                    <div class="detail-up">
                        <div class="form-in">
                            <div class="label-input">
                                <label for="title_field">Album Title:</label>
                                <input id="title_field" type="text" name="title">
                            </div>
                        </div>

                        <div class="form-in">
                            <div class="label-input">
                                <label for="artist_field">Artist:</label>
                                <input id="artist_field" type="text" name="artist">
                            </div>
                        </div>

                        <div class="form-in">

                            <?php

                            $genre_records = exec_sql_query(
                                $db,
                                "SELECT * FROM genres"
                            )->fetchAll();
                            ?>

                            <div class="genres-group label-input" role="group" aria-labelledby="genres_head">
                                <div class="genres-label" id="genres_head">Genre(s):</div>

                                <?php foreach ($genre_records as $record) { ?>

                                    <div class="form-label">
                                        <input type="checkbox" id="<?php echo htmlspecialchars($record['genre']); ?>_input" name="genres[]" value="<?php echo htmlspecialchars($record['id']); ?>">
                                        <label for="<?php echo htmlspecialchars($record['genre']); ?>_input"><?php echo htmlspecialchars($record['genre']); ?></label>
                                    </div>

                                <?php } ?>

                            </div>
                        </div>

                        <div class="form-in">
                            <div class="label-input">
                                <label for="user">Username:</label>
                                <input class="user" id="user" type="text" name="user">
                            </div>
                        </div>

                        <div class="form-in">
                            <div class="align-right">
                                <button type="submit" name="insert"> Add Album </button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        <?php } ?>

    </main>

</body>

</html>

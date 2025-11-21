<?php
$add = 'active_page';
define("MAX_FILE_SIZE", 1000000);

$upload_feedback = array(
    'general_error' => False,
    'too_large' => False
);

$insert_values = array(
    'title' => NULL,
    'artist' => NULL,
    'user' => NULL,
    '' => NULL,
    'prereq' => NULL
);

$upload_source = NULL;
$upload_file_name = NULL;
$upload_file_ext = NULL;
$upload_title = NULL;
$upload_artist = NULL;
$upload_user = NULL;

if (isset($_POST["insert"])) {

    $upload_source = trim($_POST['source']); // untrusted
    if (empty($upload_source)) {
        $upload_source = NULL;
    }

    // get the info about the uploaded files.
    $upload = $_FILES['png-file'];

    // Assume the form is valid...
    $form_valid = True;

    // file is required
    if ($upload['error'] == UPLOAD_ERR_OK) {
        // The upload was successful!

        // Get the name of the uploaded file without any path
        $upload_file_name = basename($upload['name']);

        // Get the file extension of the uploaded file and convert to lowercase for consistency in DB
        $upload_file_ext = strtolower(pathinfo($upload_file_name, PATHINFO_EXTENSION));

        // This site only accepts png files!
        if (!in_array($upload_file_ext, array('png'))) {
            $form_valid = False;
            $upload_feedback['general_error'] = True;
        }
    } else if (($upload['error'] == UPLOAD_ERR_INI_SIZE) || ($upload['error'] == UPLOAD_ERR_FORM_SIZE)) {
        // file was too big, let's try again
        $form_valid = False;
        $upload_feedback['too_large'] = True;
    } else {
        // upload was not successful
        $form_valid = False;
        $upload_feedback['general_error'] = True;
    }

    if ($form_valid) {
        $db = init_sqlite_db('db/site.sqlite', 'db/init.sql');

        $result = exec_sql_query(
            $db,
            "INSERT INTO albums (title, artist, user, file_name, file_ext, source) VALUES (:title, :artist, :user, :file_name, :file_ext, :source)",
            array(
                ':title' => $upload_title,
                ':artist' => $upload_artist,
                ':user' => $upload_user,
                ':file_name' => $upload_file_name,
                ':file_ext' => $upload_file_ext,
                ':source' => $upload_source
            )
        );

        if ($result) {
            // We successfully inserted the record into the database, now we need to
            // move the uploaded file to it's final resting place: public/uploads directory

            // get the newly inserted record's id
            $record_id = $db->lastInsertId('id');

            // uploaded file should be in folder with same name as table with the primary key as the filename.
            // Note: THIS IS NOT A URL; this is a FILE PATH on the server!
            //       Do NOT include / at the beginning of the path; path should be a relative path.
            //          NO: /public/...
            //         YES: public/...
            $upload_storage_path = 'public/uploads/entries/' . $record_id . '.' . $upload_file_ext;

            // Move the file to the public/uploads/albums folder
            // Note: THIS FUNCTION REQUIRES A PATH. NOT A URL!
            if (move_uploaded_file($upload["tmp_name"], $upload_storage_path) == False) {
                error_log("Failed to permanently store the uploaded file on the file server. Please check that the server folder exists.");
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

    <h1>Add Your Own</h1>

    <main>

        <form action="/insert" method="post" enctype="multipart/form-data">

            <!-- MAX_FILE_SIZE must precede the file input field -->

            <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>">

            <?php if ($upload_feedback['too_large']) { ?>
                <p class="feedback">We're sorry. The file failed to upload because it was too big. Please select a file that&apos;s no larger than 1MB.</p>
            <?php } ?>

            <!-- <?php if ($upload_feedback['general_error']) { ?>
                <p class="feedback">We're sorry. Something went wrong. Please select a png file to upload.</p>
            <?php } ?> -->

            <div class="label-input">
                <label for="upload-file">png File:</label>
                <!-- This site only accepts png files! -->
                <input id="upload-file" type="file" name="png-file" accept=".png,image/png+xml">
            </div>

            <!-- <div class="label-input">
                <label for="upload-source" class="optional">Source URL:</label>
                <input id='upload-source' type="url" name="source" placeholder="URL where found. (optional)">
            </div> -->
            <!--
            <div class="align-right">
                <button type="submit" name="upload">Upload</button>
            </div> -->


            <!-- <form method="post" action="/insert">

            <div class="label-input">
                <label for="name_field">Album Title:</label>
                <input id="name_field" type="text" name="name" value="">
            </div>

            <div class="label-input">
                <label for="title_field">Artist:</label>
                <input id="title_field" type="text" name="title" value="">
            </div>

            <div class="label-input">
                <label for="insert-genre">Genre:</label>
                <select id="insert-genre" name="genre">
                    <option value='' disabled selected>Select genres</option>
                </select>
            </div>

            <div class="label-input">
                <label for="name_field">Name:</label>
                <input id="name_field" type="text" name="name" value="">
            </div>

            <div class="align-right">
                <button type="submit" name="insert">Add Album</button>
            </div>

        </form> -->
            <form action="/insert" method="post" novalidate>

                <div class="form-in">
                    <p class="feedback <?php echo $form_feedback_classes['code']; ?>">Please provide a course code.</p>
                    <div class="label-input">
                        <label for="code_field">Course Code:</label>
                        <input id="code_field" type="text" name="code" value="<?php echo $sticky_values['code']; ?>">
                    </div>
                </div>

                <div class="form-in">
                    <p class="feedback <?php echo $form_feedback_classes['title']; ?>">Please provide a course title.</p>
                    <div class="label-input">
                        <label for="title_field">Course Title:</label>
                        <input id="title_field" type="text" name="title" value="<?php echo $sticky_values['title']; ?>">
                    </div>
                </div>

                <div class="form-in">
                    <div id="feedback-sem" class="feedback <?php echo $form_feedback_classes['sem']; ?>">Please select one or more
                        semester.</div>
                    <div class="sem-group label-input" role="group" aria-labelledby="sem_head">
                        <div class="sem-label" id="sem_head">Semester Offered:</div>
                        <div class="form-label">
                            <input type="radio" name="sem" id="fall-input" value="1" <?php echo $sticky_values['fall']; ?>>
                            <label for="fall-input">Fall</label>
                        </div>
                        <div class="form-label">
                            <input type="radio" name="sem" id="spring-input" value="2" <?php echo $sticky_values['spring']; ?>>
                            <label for="spring-input">Spring</label>
                        </div>
                        <div class="form-label">
                            <input type="radio" name="sem" id="both-input" value="3" <?php echo $sticky_values['both']; ?>>
                            <label for="both-input">Both</label>
                        </div>
                    </div>
                </div>

                <div class="form-in">
                    <p class="feedback <?php echo $form_feedback_classes['credit']; ?>">Please provide the number of credits.</p>
                    <div class="label-input">
                        <label for="credit_field"># of Credits:</label>
                        <input class="credit_field" id="credit_field" name="credit" value="<?php echo $sticky_values['credit']; ?>">
                    </div>
                </div>

                <div class="form-in">
                    <p class="feedback <?php echo $form_feedback_classes['prereq']; ?>">Please provide any course prereqs.</p>
                    <div class="label-input">
                        <label for="prereq">Prerequisites:</label>
                        <input class="prereq" id="prereq" type="text" name="prereq" value="<?php echo $sticky_values['prereq']; ?>">
                    </div>
                </div>

                <div class="form-in">
                    <div class="align-right">
                        <button type="submit" name="submit"> Submit </button>
                    </div>
                </div>

            </form>

    </main>

</body>

</html>

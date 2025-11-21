<?php
$add = 'active_page';
define("MAX_FILE_SIZE", 1000000);

$upload_feedback = array(
    'general_error' => False,
    'too_large' => False
);

$upload_source = NULL;
$upload_file_name = NULL;
$upload_file_ext = NULL;

if (isset($_POST["upload"])) {

    $upload_source = trim($_POST['source']); // untrusted
    if (empty($upload_source)) {
        $upload_source = NULL;
    }

    // get the info about the uploaded files.
    $upload = $_FILES['svg-file'];

    // Assume the form is valid...
    $form_valid = True;

    // file is required
    if ($upload['error'] == UPLOAD_ERR_OK) {
        // The upload was successful!

        // Get the name of the uploaded file without any path
        $upload_file_name = basename($upload['name']);

        // Get the file extension of the uploaded file and convert to lowercase for consistency in DB
        $upload_file_ext = strtolower(pathinfo($upload_file_name, PATHINFO_EXTENSION));

        // This site only accepts SVG files!
        if (!in_array($upload_file_ext, array('svg'))) {
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
        $result = exec_sql_query(
            $db,
            "INSERT INTO clipart (file_name, file_ext, source) VALUES (:file_name, :file_ext, :source)",
            array(
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
            $upload_storage_path = 'public/uploads/clipart/' . $record_id . '.' . $upload_file_ext;

            // Move the file to the public/uploads/clipart folder
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

            <?php if ($upload_feedback['general_error']) { ?>
                <p class="feedback">We're sorry. Something went wrong. Please select an SVG file to upload.</p>
            <?php } ?>

            <div class="label-input">
                <label for="upload-file">SVG File:</label>
                <!-- This site only accepts SVG files! -->
                <input id="upload-file" type="file" name="svg-file" accept=".svg,image/svg+xml">
            </div>

            <div class="label-input">
                <label for="upload-source" class="optional">Source URL:</label>
                <input id='upload-source' type="url" name="source" placeholder="URL where found. (optional)">
            </div>

            <div class="align-right">
                <button type="submit" name="upload">Upload</button>
            </div>

        </form>

        <form method="post" action="/pages/insertform.php">

            <div class="label-input">
                <label for="name_field">Album Title:</label>
                <input id="name_field" type="text" name="name" value="">
            </div>

            <div class="label-input">
                <label for="title_field">Artist:</label>
                <input id="title_field" type="text" name="title" value="">
            </div>

            <div class="label-input">
                <label for="artist_field">Songs:</label>
                <textarea id="artist_field" name="artist" value="">
                </textarea>
            </div>

            <div class="label-input">
                <label for="insert-genre">Genre:</label>
                <select id="insert-genre" name="genre" required>
                    <option value='' disabled selected>Select genres</option>
                </select>
            </div>

            <div class="label-input">
                <label for="name_field">Name:</label>
                <input id="name_field" type="text" name="name" value="">
            </div>

            <div class="align-right">
                <button type="submit" name="request-insert">Add Album</button>
            </div>

        </form>
    </main>

</body>

</html>

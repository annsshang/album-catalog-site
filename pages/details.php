<?php

$detail_id = $_GET['id'] ?? NULL;

$title = $detail_id;

$nav_detail = True;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />


    <link rel="stylesheet" type="text/css" href="/public/styles/site.css" media="all">

    <title><?php echo htmlspecialchars($detail_id); ?></title>
</head>

<body>

    <?php include 'includes/header.php'; ?>

    <?php

    $result = exec_sql_query(
        $db,
        "SELECT albums.id AS 'albums.id', albums.title AS 'albums.title', albums.artist AS 'albums.artist', albums.user AS 'albums.user', albums.file_ext AS 'albums.file_ext', albums.source AS 'albums.source' FROM albums WHERE albums.title = :detail_id",
        array(':detail_id' => $detail_id)
    );
    $records = $result->fetchAll();
    ?>

    <div class="album-info">
        <?php foreach ($records as $record) { ?>

            <div class="album-cover">
                <picture>
                    <img src="<?php echo htmlspecialchars('public/uploads/albums/' . $record['albums.id'] . '.' . $record['albums.file_ext']); ?>" alt="<?php echo htmlspecialchars($record['albums.title']); ?>" album cover>
                </picture>
                <!-- <cite>Source: <?php echo htmlspecialchars($record['albums.source']); ?></cite> -->
            </div>

            <div class="album-text">
                <h2> Album Name: <?php echo htmlspecialchars($record['albums.title']); ?>
                </h2>

                <h2> Artist: <?php echo htmlspecialchars($record['albums.artist']); ?>
                </h2>

                <h3>Uploaded by: <?php echo htmlspecialchars($record['albums.user']); ?></h3>

            <?php } ?>

            <!-- <?php

                    $result = exec_sql_query(
                        $db,
                        "SELECT albums.title AS 'albums.title', genres.genre AS 'genres.genre' FROM albums INNER JOIN album_genres ON (albums.id = album_id) INNER JOIN genres ON (album_genres.genre_id = genres.id) WHERE albums.title = :detail_id",
                        array(':detail_id' => $detail_id)
                    );
                    $records = $result->fetchAll();
                    ?> -->

            <h2>
                Genres:
            </h2>

            <ul>
                <?php foreach ($records as $record) { ?>
                    <li>- <?php echo htmlspecialchars($record['genres.genre']); ?></li>
                <?php } ?>
                <ul>

            </div>
    </div>
</body>

</html>

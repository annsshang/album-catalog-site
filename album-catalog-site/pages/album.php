<?php
$title = "Albums";


$filter_param = isset($_GET['filter']) ? $_GET['filter'] : NULL;
$filter_input = isset($_GET['filter']) ? (bool)$_GET['filter'] : false;

if ($filter_input) {

    $has_filter = True;

    $select_query = "SELECT albums.id AS 'albums.id', albums.title AS 'albums.title', albums.artist AS 'albums.artist', albums.file_ext AS 'albums.file_ext', albums.source AS 'albums.source', genres.genre AS 'genres.genre' FROM albums INNER JOIN album_genres ON (albums.id = album_id) INNER JOIN genres ON (album_genres.genre_id = genres.id)";


    $filter_params = $_GET['genre'];

    $filter_expr = "(genres.genre = '$filter_params')";

    $select_query = $select_query . ' WHERE ' . $filter_expr;
} else {
    $select_query = "SELECT * FROM albums";
    $has_filter = false;
}


$records = exec_sql_query(
    $db,
    "$select_query"
)->fetchAll();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" type="text/css" href="/public/styles/site.css" media="all">

    <title>Albums</title>
</head>

<body>

    <?php include 'includes/header.php';

    $filter_records = exec_sql_query(
        $db,
        "SELECT * FROM genres"
    )->fetchAll();
    ?>

    <main>
        <div class="albums-page">
            <form id="submit" method="get" action="/albums" novalidate>
                <div class="filter">

                    <h2>Filter by Genre:</h2>

                    <a class="reset" href="/albums">Reset</a>


                    <?php foreach ($filter_records as $record) { ?>

                        <div class="check">
                            <input type="radio" id="<?php echo htmlspecialchars($record['genre']); ?>_input" name="genre" value="<?php echo htmlspecialchars($record['genre']); ?>">
                            <label for="<?php echo htmlspecialchars($record['genre']); ?>_input"><?php echo htmlspecialchars($record['genre']); ?></label>
                        </div>

                    <?php } ?>

                    <div class="align-right">
                        <input class="filter-sub" type="submit" name="filter" value="filter">
                    </div>

                </div>
            </form>


            <div class="albums">

                <?php foreach ($records as $record) { ?>

                    <div class="album-entry">

                        <?php if ($has_filter) { ?>

                            <picture class="alb-cover">
                                <img src="<?php echo htmlspecialchars('public/uploads/albums/' . $record['albums.id'] . '.' . $record['albums.file_ext']); ?>" alt=" <?php echo htmlspecialchars($record['albums.title']); ?> album cover">
                            </picture>


                            <a href="/details?<?php echo http_build_query(
                                                    array('id' => $record["albums.title"])
                                                ); ?>">
                                <div class="det-button">
                                    <h1>
                                        <?php echo htmlspecialchars($record['albums.title']); ?>
                                    </h1>
                                    <h2>
                                        <?php echo htmlspecialchars($record['albums.artist']); ?>
                                    </h2>
                                </div>
                            </a>
                    </div>
                <?php } else { ?>
                    <picture class="alb-cover">
                        <img src="<?php echo htmlspecialchars('public/uploads/albums/' . $record['id'] . '.' . $record['file_ext']); ?>" alt=" <?php echo htmlspecialchars($record['title']); ?> album cover">
                    </picture>

                    <a href="/details?<?php echo http_build_query(
                                            array('id' => $record["title"])
                                        ); ?>">
                        <div class="det-button">
                            <h1>
                                <?php echo htmlspecialchars($record['title']); ?>
                            </h1>
                            <h2>
                                <?php echo htmlspecialchars($record['artist']); ?>
                            </h2>
                        </div>
                    </a>
            </div>
    <?php }
                    } ?>


        </div>

        </div>
    </main>

</body>

</html>

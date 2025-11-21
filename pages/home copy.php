<?php
$home = 'active_page';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title> Home</title>
</head>

<body>
  <?php include 'includes/header.php'; ?>


  <h1>Explore Albums</h1>
  <h2>Log In</h2>


  <h2>Filter By</h2>
  <h3>Artist</h3>
  <ul>
    <li></li>
  </ul>
  <h3>Genre</h3>
  <ul>
    <li></li>
  </ul>
  <h3>Year</h3>
  <ul>
    <li></li>
  </ul>

  <main>
    <?php

    $db = init_sqlite_db('db/site.sqlite', 'db/init.sql');

    $result = exec_sql_query(
      $db,
      "SELECT albums.title AS 'albums.title', albums.artist AS 'albums.artist', albums.user AS 'albums.artsit'
  FROM albums"
    );
    $records = $result->fetchAll();
    ?>

    <?php foreach ($records as $record) { ?>

      <div class="album">
        <picture>
          <img src="uploads/clairo_immunity.png">
        </picture>
        <div="album_contain">
          <div class="albuml_iclassnfo"></div>
          <h3>
            <?php echo htmlspecialchars($record['albums.title']); ?>
          </h3>
          <h3>
            <?php echo htmlspecialchars($record['tags.artist']); ?>
          </h3>
      </div>
      <h3>
        <?php echo htmlspecialchars($record['users.name']); ?>
      </h3>
      </div>
      </div>
    <?php } ?>
  </main>

</body>

</html>

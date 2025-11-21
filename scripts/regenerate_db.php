<?php
// Regenerate the SQLite database from db/init.sql
// Usage: php scripts/regenerate_db.php

require_once __DIR__ . "/../includes/db.php";

$dbfile = __DIR__ . "/../db/site.sqlite";
$checksum = __DIR__ . "/../db/init.sql.checksum";
$initsql = __DIR__ . "/../db/init.sql";

if (file_exists($dbfile)) {
    echo "Removing existing database: $dbfile\n";
    unlink($dbfile);
}

if (file_exists($checksum)) {
    echo "Removing existing checksum: $checksum\n";
    unlink($checksum);
}

try {
    $db = init_sqlite_db($dbfile, $initsql);
    if ($db) {
        echo "Database created successfully.\n";
        $query = exec_sql_query($db, "SELECT COUNT(*) AS c FROM albums;");
        $row = $query->fetch(PDO::FETCH_ASSOC);
        echo "Albums rows: " . ($row ? $row['c'] : 'unknown') . "\n";
    } else {
        echo "init_sqlite_db returned NULL.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

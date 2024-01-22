<?php

$db_connection = mysqli_connect(
    $_POST['db_host'], $_POST['db_user'], $_POST['db_pass'], $_POST['db_name']
);

if (!$db_connection) {
    die('DB connection failed: ' . mysqli_connect_error());
}

$tables = mysqli_query($db_connection, 'SHOW TABLES');

if (!$tables) {
    die('DB query "SHOW TABLES" failed: ' . mysqli_error($db_connection));
}
$found = [];

while ($table = mysqli_fetch_array($tables)) {
    $table_name = $table[0];

    $tableData = mysqli_query($db_connection, 'SELECT * FROM ' . $table_name);

    if (!$tableData) {
        die('DB query "SELECT * FROM ' . $table_name . '" failed: ' . mysqli_error($db_connection));
    }
    $found[$table_name] = [];
    foreach ($tableData as $row) {
        foreach ($row as $column => $value) {
            if (strpos($value, $_POST['target_content']) !== false) {
                $found[$table_name]['column'] = $column;
                $found[$table_name]['value'] = $value;
            }
        }
    }
}

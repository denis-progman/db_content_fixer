<?php
session_start();

$db_connection = mysqli_connect(
    $_POST['db_host'], $_POST['db_user'], $_POST['db_pass'], $_POST['db_name']
);
$db_connection->set_charset('utf8');

if (!$db_connection) {
    die('DB connection failed: ' . mysqli_connect_error());
}

if (isset($_POST['finder'])) {
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
            $found[$table_name][$row] = [];
            foreach ($row as $column => $value) {
                if (strpos($value, $_POST['target_content']) !== false) {
                    $found[$table_name][$row]['column'] = $column;
                    $found[$table_name][$row]['value'] = $value;
                }
            }
        }
        $_SESSION['found'] = $found;
    }
} elseif (isset($_POST['fixer'])){
    $found = $_SESSION['found'];
    foreach ($found as $table => $data) {
        foreach ($data as $row) {
            $query = 'UPDATE ' . $table . ' SET ' . $row['column'] . ' = "' . str_replace($_POST['target_content'], $_POST['replace_content'], $row['value']) . '" WHERE ' . $row['column'] . ' = "' . $row['value'] . '"';
            $result = mysqli_query($db_connection, $query);
            if (!$result) {
                die('DB query "' . $query . '" failed: ' . mysqli_error($db_connection));
            }
        }
    }
    unset($_SESSION['found']);
    echo count($found) . 'changes is Done!';
    $found = [];
}

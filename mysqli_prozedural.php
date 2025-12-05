<?php
//Aufbau der Verbindung der DB
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "info_db_anbindung";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "Connected successfully<br>";

// Aufrufen der Funktionen
readDB($conn);
$lastId = insertDB($conn);
readDB($conn);
deleteDB($conn, $lastId);
readDB($conn);

//Verbindung schließen
mysqli_close($conn);


// --- Funktionen ---

function readDB($conn) {
    $sql = "SELECT * FROM personen";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

function insertDB($conn) {
    $sql = "INSERT INTO personen (vorname, nachname, age)
            VALUES (?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    $vorname = "Test";
    $nachname = "Testuser";
    $age = 100;

    mysqli_stmt_bind_param($stmt, "ssi", $vorname, $nachname, $age);
    mysqli_stmt_execute($stmt);

    return mysqli_insert_id($conn);
}

function deleteDB($conn, $id) {
    $sql = "DELETE FROM personen WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
}

?>
<?php
//Aufbau der Verbindung der DB
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "info_db_anbindung";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully<br>";

// Aufrufen der Funktionen
readDB($conn);
$lastId = insertDB($conn);
readDB($conn);
deleteDB($conn, $lastId);
readDB($conn);

//Verbindung schließen
$conn->close();


// --- Funktionen ---

function readDB($conn) {
    $sql = "SELECT * FROM personen";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);

    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

function insertDB($conn) {
    $sql = "INSERT INTO personen (vorname, nachname, age)
            VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $vorname = "Test";
    $nachname = "Testuser";
    $age = 100;

    $stmt->bind_param("ssi", $vorname, $nachname, $age);
    $stmt->execute();

    return $conn->insert_id;
}

function deleteDB($conn, $id) {
    $sql = "DELETE FROM personen WHERE id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("i", $id);
    $stmt->execute();
}

?>
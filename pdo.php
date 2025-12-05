<?php
//Aufbau der Verbindung der DB
$servername = "localhost";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$servername;dbname=info_db_anbindung", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Aufrufen der Funktionen
readDB($conn);
$lastId = insertDB($conn);
readDB($conn);
deleteDB($conn, $lastId);
readDB($conn);

//Verbindung schließen
$conn = null;


function readDB($conn) {
    $stmt = $conn->prepare("SELECT * FROM personen");
    $stmt->execute();

    $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<pre>";
    print_r($user);
    echo "</pre>";
}

function insertDB($conn) {
    $stmt = $conn->prepare("INSERT INTO personen (vorname, nachname, age)
        VALUES (:vorname, :nachname, :age)");

    $stmt->execute([
        ':vorname'  => "Test",
        ':nachname' => "Testuser",
        ':age'      => 100
    ]);

    return $conn->lastInsertId();
}

function deleteDB($conn, $lastId) {
    // Delete
    $stmt = $conn->prepare("DELETE FROM personen WHERE id = :id");
    $stmt->execute([':id' => $lastId]);
}

?>
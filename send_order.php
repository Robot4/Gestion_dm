<?php
// send_order.php


// Receive the data from the client-side
$data = json_decode(file_get_contents('php://input'), true);

// Connect to the database (replace with your connection details)
$servername = 'localhost';
$username = 'root';
$password = "";
$dbname = 'gestion_dm';

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Insert the data into the "dm" table
$sql = "INSERT INTO dm (n_nomenclature, designation, prix_unitaire, quantite, projet)
        VALUES ('".$data['nomenclature']."', '".$data['designation']."', '".$data['prixUnitaire']."', '".$data['quantite']."', '".$data['projet']."')";

if ($conn->query($sql) === TRUE) {
    echo 'Order data inserted successfully!';
} else {
    echo 'Error inserting order data: ' . $conn->error;
}

$conn->close();
?>

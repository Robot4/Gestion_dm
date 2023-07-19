<?php
// send_orders.php

// Receive the data from the client-side
$data = json_decode(file_get_contents('php://input'), true);

// Connect to the database (replace with your connection details)
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'gestion_dm';

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Function to calculate the prix_total for each order
function calculatePrixTotal($prixUnitaire, $quantite) {
    return $prixUnitaire * $quantite;
}

// Insert the data for each order into the "dm" table
if (isset($data['orders']) && is_array($data['orders'])) {
    foreach ($data['orders'] as $order) {
        $nomenclature = $conn->real_escape_string($order['nomenclature']);
        $designation = $conn->real_escape_string($order['designation']);
        $prixUnitaire = floatval($order['prixUnitaire']);
        $quantite = intval($order['quantite']);
        $projet = $conn->real_escape_string($order['project']);
        $prixTotal = calculatePrixTotal($prixUnitaire, $quantite);

        // Insert the data into the "dm" table
        $sql = "INSERT INTO dm (n_nomenclature, designation, prix_unitaire, quantite, projet, prix_total)
                VALUES ('$nomenclature', '$designation', $prixUnitaire, $quantite, '$projet', $prixTotal)";
        if ($conn->query($sql) !== TRUE) {
            echo 'Error inserting order data: ' . $conn->error;
            $conn->close();
            exit;
        }
    }

    echo 'Order data inserted successfully!';
} else {
    echo 'No orders found to insert.';
}

$conn->close();
?>

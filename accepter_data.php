<?php
// Replace these variables with your actual database credentials
$servername = "localhost";
$username = "root";
$password = '';
$dbname = "gestion_dm";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request contains the necessary data
if (
    isset($_POST['username']) &&
    isset($_POST['district']) &&
    isset($_POST['n_nomenclature']) &&
    isset($_POST['designation']) &&
    isset($_POST['prix_total']) &&
    isset($_POST['quantite_maintenu']) &&
    isset($_POST['date_envoie'])
) {
    // Prepare the SQL query for insertion into etat_dm table
    $insert_sql = "INSERT INTO etat_dm (username, district, n_nomenclature, designation, prix_total, quantite_maintenu, date_envoie) VALUES (?, ?, ?, ?, ?, ?, ?)";

    // Create a prepared statement for insertion
    $stmt_insert = $conn->prepare($insert_sql);

    // Bind parameters to the prepared statement for insertion
    $stmt_insert->bind_param(
        "sssssss",
        $_POST['username'],
        $_POST['district'],
        $_POST['n_nomenclature'],
        $_POST['designation'],
        $_POST['prix_total'],
        $_POST['quantite_maintenu'],
        $_POST['date_envoie']
    );

    // Execute the prepared statement for insertion
    if ($stmt_insert->execute()) {
        echo "Data accepted successfully.";

        // Now, let's delete the data from the reception table
        $delete_sql = "DELETE FROM reception WHERE username = ? AND district = ? AND n_nomenclature = ? AND designation = ? AND prix_total = ? AND quantite_maintenu = ? AND date_envoie = ?";

        // Create a prepared statement for deletion
        $stmt_delete = $conn->prepare($delete_sql);

        // Bind parameters to the prepared statement for deletion
        $stmt_delete->bind_param(
            "sssssss",
            $_POST['username'],
            $_POST['district'],
            $_POST['n_nomenclature'],
            $_POST['designation'],
            $_POST['prix_total'],
            $_POST['quantite_maintenu'],
            $_POST['date_envoie']
        );

        // Execute the prepared statement for deletion
        if ($stmt_delete->execute()) {
            echo "Data deleted from reception table.";
        } else {
            echo "Error deleting data from reception table: " . $conn->error;
        }

        // Close the statement for deletion
        $stmt_delete->close();
    } else {
        echo "Error inserting data into etat_dm table: " . $conn->error;
    }

    // Close the statement and connection for insertion
    $stmt_insert->close();
    $conn->close();
} else {
    echo "Incomplete data. Unable to accept.";
}
?>

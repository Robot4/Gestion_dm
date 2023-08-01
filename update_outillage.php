<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Get the updated values from the form submission
    $n_dm = $_POST['n_dm'];
    $valeur = $_POST['valeur_input'];

    // Prepare the SQL update query with placeholders
    $sql = "UPDATE etat_dm SET valeur = ? WHERE n_dm = ?";

    // Create a prepared statement
    $stmt = $conn->prepare($sql);

    // Bind the parameters to the prepared statement
    $stmt->bind_param("ii", $valeur, $n_dm); // Change "sii" to "ii" for integer type

    // Execute the update query
    if ($stmt->execute()) {
        // If the update is successful, redirect back to the page where the form was submitted
        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit();
    } else {
        // If the update fails, display an error message or handle it accordingly
        echo "Error updating data: " . $conn->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

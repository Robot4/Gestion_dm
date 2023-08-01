<?php

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
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



    // Get the values from the form submission
    $n_dm = $_POST['n_dm']; // Changed from "n_nomenclature" to "n_dm"
    $new_etat = isset($_POST['etat_select']) ? $_POST['etat_select'] : '';


    // Prepare the SQL query with placeholders for the update
    $sql = "UPDATE etat_dm SET etat = ? WHERE n_dm = ?"; // Changed from "n_nomenclature" to "n_dm"

    // Create a prepared statement
    $stmt = $conn->prepare($sql);

    // Bind the parameters to the prepared statement
    $stmt->bind_param("ss", $new_etat, $n_dm); // Changed from "n_nomenclature" to "n_dm"

    // Execute the update
    if ($stmt->execute()) {
        // The update was successful
        echo "Update successful!";
    } else {
        // An error occurred during the update
        echo "Error updating data: " . $conn->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
    header("Location: rabat.php");

}
?>

<?php
// Step 1: Replace these values with your actual database credentials
$host = 'localhost';
$username = 'root';
$password = "";
$database = 'gestion_dm';

// Step 2: Connect to the database
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 3: Function to execute arbitrary SQL queries
function executeQuery($query)
{
    global $conn;
    $result = $conn->query($query);
    return $result;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['n_dm']) && isset($_POST['operation']) && isset($_POST['quantite_maintenu']) && isset($_POST['date_envoie'])) {
        $n_dm = mysqli_real_escape_string($conn, $_POST['n_dm']);
        $operation = mysqli_real_escape_string($conn, $_POST['operation']);
        $quantiteMaintenu = mysqli_real_escape_string($conn, $_POST['quantite_maintenu']);
        $dateEnvoie = mysqli_real_escape_string($conn, $_POST['date_envoie']);

        // Update the specified columns for the specific row in the dm table
        $updateQuery = "UPDATE dmi SET operation = '$operation', quantite_maintenu = '$quantiteMaintenu', date_envoie = '$dateEnvoie' WHERE n_dm = '$n_dm'";
        $result = executeQuery($updateQuery);

        if ($result === TRUE) {
            // The update was successful
            echo "Update successful.";
        } else {
            // Failed to update
            echo "Error updating data: " . $conn->error;
        }
    } else {
        // Missing parameters
        echo "Missing parameters for update.";
    }
}

// Step 4: Close the database connection
$conn->close();
?>

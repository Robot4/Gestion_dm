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
    if (isset($_POST['n_dm']) && isset($_POST['operation']) && isset($_POST['quantite_maintenu'])) {
        $n_dm = mysqli_real_escape_string($conn, $_POST['n_dm']);
        $operation = mysqli_real_escape_string($conn, $_POST['operation']);
        $quantiteMaintenu = mysqli_real_escape_string($conn, $_POST['quantite_maintenu']);

        // Insert data into the "magasin" table
        $insertQuery = "INSERT INTO magasin (username, district, n_dm, n_nomenclature, designation, prix_unitaire, quantite, projet, date_saisie, prix_total, operation, quantite_maintenu, date_envoie) SELECT username, district, n_dm, n_nomenclature, designation, prix_unitaire, quantite, projet, date_saisie, prix_total, '$operation', '$quantiteMaintenu', NOW() FROM dmi WHERE n_dm = '$n_dm'";

        $result = executeQuery($insertQuery);

        if ($result === TRUE) {
            // The insert was successful
            echo "La Dm Inséré Au Magasinier";

            // Now, delete the data from the 'dmi' table
            $deleteQuery = "DELETE FROM dmi WHERE n_dm = '$n_dm'";
            $deleteResult = executeQuery($deleteQuery);

            if ($deleteResult === TRUE) {
                echo " .";
            } else {
                echo "Error deleting data from 'dmi' table: " . $conn->error;
            }
        } else {
            // Failed to insert
            echo "Error inserting data: " . $conn->error;
        }
    } else {
        // Missing parameters
        echo "Paramètres manquants pour la mise à jour.";
    }
}

// Step 4: Close the database connection
$conn->close();
?>

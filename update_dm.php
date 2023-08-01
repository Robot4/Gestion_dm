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

        // Get the values of date_verification and nom_verificateur from the dmi table
        $selectQuery = "SELECT date_verification, nom_verificateur FROM dmi WHERE n_dm = '$n_dm'";
        $result = executeQuery($selectQuery);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $dateVerification = $row['date_verification'];
            $nomVerificateur = $row['nom_verificateur'];

            // Insert data into the "magasin" table
            $insertQuery = "INSERT INTO magasin (username, district, n_dm, n_nomenclature, designation, prix_unitaire, quantite, projet, date_saisie, prix_total, operation, quantite_maintenu, date_envoie, date_verification, nom_verificateur) 
                            SELECT username, district, n_dm, n_nomenclature, designation, prix_unitaire, quantite, projet, date_saisie, prix_total, '$operation', '$quantiteMaintenu', NOW(), '$dateVerification', '$nomVerificateur' 
                            FROM dmi WHERE n_dm = '$n_dm'";

            $insertResult = executeQuery($insertQuery);

            if ($insertResult === TRUE) {
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
            echo "No data found in 'dmi' table for n_dm = '$n_dm'";
        }
    } else {
        // Missing parameters
        echo "Paramètres manquants pour la mise à jour.";
    }
}


// Step 4: Close the database connection
$conn->close();
?>

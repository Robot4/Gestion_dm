<?php
// Start the session
session_start();


$host = 'localhost';
$username = 'root';
$password = "";
$database = 'gestion_dm';

// Step 2: Connect to the database
$conn = new mysqli($host, $username, $password, $database);
// Check if the $conn variable representing the database connection is available
if (isset($conn) && $conn !== null) {
    if (isset($_POST["n_dm"])) {
        // Get the n_dm value sent from AJAX
        $n_dm = $_POST["n_dm"];

        // Query to fetch the data from the dm table based on the n_dm value
        $sql = "SELECT * FROM dm WHERE n_dm = $n_dm";

        $result = $conn->query($sql);

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();

            // Fetch the current date
            $current_date = date("Y-m-d");

            // Check if the username session variable is set
            if (isset($_SESSION["username"]) && !empty($_SESSION["username"])) {
                // Get the username of the verificateur from the session
                $username_verificateur = $_SESSION["username"];
            } else {
                // If the username is not set or empty, handle the error or redirect the user to the login page
                // For example, you can display an error message and exit the script
                echo "Error: User not authenticated or session expired.";
                exit;
            }

            // Insert the data into the dmi table with 'date_verification' and 'nom_verificateur' fields
            $insert_query = "INSERT INTO dmi (username, district, n_dm, n_nomenclature, designation, prix_unitaire, quantite, projet, date_saisie, prix_total, operation, quantite_maintenu, date_envoie, date_verification, nom_verificateur) VALUES (
                '" . $row["username"] . "',
                '" . $row["district"] . "',
                " . $row["n_dm"] . ",
                '" . $row["n_nomenclature"] . "',
                '" . $row["designation"] . "',
                " . $row["prix_unitaire"] . ",
                " . $row["quantite"] . ",
                '" . $row["projet"] . "',
                '" . $row["date_saisie"] . "',
                " . $row["prix_total"] . ",
                '" . $row["operation"] . "',
                " . $row["quantite_maintenu"] . ",
                '" . $row["date_envoie"] . "',
                '$current_date',
                '$username_verificateur'
            )";

            if ($conn->query($insert_query) === true) {
                // Delete the data from the dm table after successful insertion into the dmi table
                $delete_query = "DELETE FROM dm WHERE n_dm = $n_dm";
                if ($conn->query($delete_query) === true) {
                    echo "La DM envoyer";
                } else {
                    echo "Erreur lors de la suppression des données de la table dm " . $conn->error;
                }
            } else {
                echo "Erreur lors de l'insertion de données dans la table dmi : " . $conn->error;
            }
        } else {
            echo "Aucune donnée trouvée pour le n_dm spécifié dans la table dm.";
        }
    }
} else {
    echo "No internet ";
}
?>

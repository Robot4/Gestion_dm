<?php
// ... Previous code for database connection ...

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

            // Insert the data into the dmi table
            $insert_query = "INSERT INTO justifications (username, district, n_dm, n_nomenclature, designation, prix_unitaire, quantite, projet, date_saisie, prix_total) VALUES (
                '" . $row["username"] . "',
                '" . $row["district"] . "',
                " . $row["n_dm"] . ",
                '" . $row["n_nomenclature"] . "',
                '" . $row["designation"] . "',
                " . $row["prix_unitaire"] . ",
                " . $row["quantite"] . ",
                '" . $row["projet"] . "',
                '" . $row["date_saisie"] . "',
                " . $row["prix_total"] . "
            )";

            if ($conn->query($insert_query) === true) {
                // Delete the data from the dm table after successful insertion into the dmi table
                $delete_query = "DELETE FROM dm WHERE n_dm = $n_dm";
                if ($conn->query($delete_query) === true) {
                    echo "Data inserted successfully into the justifications table and deleted from the dm table.";
                } else {
                    echo "Error deleting data from the dm table: " . $conn->error;
                }
            } else {
                echo "Error inserting data into the dmi table: " . $conn->error;
            }
        } else {
            echo "No data found for the specified n_dm in the dm table.";
        }
    }
} else {
    echo "Database connection is not available.";
}
?>

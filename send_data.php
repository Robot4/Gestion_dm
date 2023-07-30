<?php
// Step 1: Check if the n_dm value is provided in the URL
if (isset($_GET['n_dm'])) {
    $n_dm = $_GET['n_dm'];

    // Step 2: Establish a database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "gestion_dm";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Step 3: Fetch the data from the justifications table based on the provided n_dm value
    $sql_select = "SELECT * FROM justifications WHERE n_dm = $n_dm";
    $result_select = $conn->query($sql_select);

    if ($result_select->num_rows > 0) {
        // Step 4: Insert the data into the dmi table
        $row = $result_select->fetch_assoc();
        $username = $row['username'];
        $district = $row['district'];
        $n_nomenclature = $row['n_nomenclature'];
        $designation = $row['designation'];
        $prix_unitaire = $row['prix_unitaire'];
        $quantite = $row['quantite'];
        $projet = $row['projet'];
        $date_saisie = $row['date_saisie'];
        $prix_total = $row['prix_total'];

        $sql_insert = "INSERT INTO dmi (username, district, n_nomenclature, designation, prix_unitaire, quantite, projet, date_saisie, prix_total) 
                VALUES ('$username', '$district', '$n_nomenclature', '$designation', $prix_unitaire, $quantite, '$projet', '$date_saisie', $prix_total)";

        if ($conn->query($sql_insert) === TRUE) {
            // Step 5: Data successfully inserted into the dmi table, now delete it from the justifications table
            $sql_delete = "DELETE FROM justifications WHERE n_dm = $n_dm";
            if ($conn->query($sql_delete) === TRUE) {
                $response = array("success" => true, "message" => "Data sent to the DMI table and deleted from the justifications table successfully.");
            } else {
                $response = array("success" => false, "message" => "Error deleting data from justifications table: " . $conn->error);
            }
        } else {
            $response = array("success" => false, "message" => "Error inserting data into DMI table: " . $conn->error);
        }
    } else {
        $response = array("success" => false, "message" => "No data found for the provided n_dm value.");
    }

    // Close the database connection
    $conn->close();

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>
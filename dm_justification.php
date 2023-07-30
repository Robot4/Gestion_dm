<!DOCTYPE html>
<html>
<head>
    <title>User Data</title>
    <link rel="stylesheet" href="assets/css/users.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

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

// Check if the user is logged in and their username is stored in the session
if (isset($_SESSION['username'])) {
    // Get the username of the currently logged-in user
    $desired_username = $_SESSION['username'];

    // Handle form submission to update justifications
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST['update'])) {
            $justification_id = isset($_POST['justification_id']) ? $_POST['justification_id'] : null;
            $new_justification = $_POST['justification'];

            // Update the justification in the database
            if ($justification_id !== null) {
                $stmt = $conn->prepare("UPDATE justifications SET justification = ? WHERE n_dm = ?");
                $stmt->bind_param("si", $new_justification, $justification_id);
                $stmt->execute();
                $stmt->close();
            } else {
                echo "Invalid justification_id.";
            }
        }
    }

    // Prepare the SQL query with a placeholder for the username
    $sql = "SELECT * FROM justifications WHERE username = ?";

    // Create a prepared statement
    $stmt = $conn->prepare($sql);

    // Bind the username parameter to the prepared statement
    $stmt->bind_param("s", $desired_username);

    // Execute the query
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    // Check if there are any rows returned
    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr>";
        echo "<th>Username</th>";
        echo "<th>District</th>";
        echo "<th>N_demande</th>";
        echo "<th>n_nomenclature</th>";
        echo "<th>Designation</th>";
        echo "<th>quantite</th>";
        echo "<th>Prix Unitaire</th>";
        echo "<th>Prix Total</th>";
        echo '<th>Date Saisie</th>';
        echo '<th style="color: red;">Justification</th>';
        echo '<th>Action</th>';
        echo "</tr>";

        // Loop through the rows and display the data in table rows
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . $row['district'] . "</td>";
            echo "<td>" . $row['n_dm'] . "</td>";
            echo "<td>" . $row['n_nomenclature'] . "</td>";
            echo "<td>" . substr($row['designation'], 0, 10) . "</td>"; // Show only the first 10 characters
            echo '<td>' . $row['quantite'] . '</td>';
            echo '<td>' . $row['prix_unitaire'] . '</td>';
            echo "<td>" . $row['prix_total'] . "</td>";
            echo "<td>" . $row['date_saisie'] . "</td>";
            echo '<td>
                    <form method="post">
                        <input type="hidden" name="justification_id" value="' . $row['n_dm'] . '">
                        <input type="text" name="justification" value="' . $row['justification'] . '">
                    </td>';
            echo '<td><button type="submit" name="update">Envoyer</button></form></td>';
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No data username.";
    }
} else {
    echo "User not logged in."; // Add appropriate handling if the user is not logged in
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>

</body>
</html>
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

    // Prepare the SQL query with a placeholder for the username
    $sql = "SELECT * FROM etat_dm WHERE username = ?";

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
        echo "<th>n_nomenclature</th>";
        echo "<th>Designation</th>";
        echo "<th>Prix Total</th>";
        echo "<th>Quantite </th>";
        echo "<th>Date Envoie</th>";
        echo "</tr>";

        // Loop through the rows and display the data in table rows
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . $row['district'] . "</td>";
            echo "<td>" . $row['n_nomenclature'] . "</td>";
            echo "<td>" . $row['designation'] . "</td>";
            echo "<td>" . $row['prix_total'] . "</td>";
            echo "<td>" . $row['quantite_maintenu'] . "</td>";
            echo "<td>" . $row['date_envoie'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "votre stock est vide.";
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

<!DOCTYPE html>
<html>
<head>
    <title>User Data</title>
    <link rel="stylesheet" href="assets/css/users.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <style>


        .accepter {
            font-family: 'Helvetica', 'Arial', sans-serif;
            display: inline-block;
            font-size: 1em;
            padding: 12.1px 3em;
            margin-top: -1px;
            margin-bottom: 11px;
            -webkit-appearance: none;
            appearance: none;
            background-color: green;
            border-radius: -25px;
            border: none;
            cursor: pointer;
            position: relative;
            /* transition: transform cubic-bezier(0, 0, 0, 0.79) 0.1s, box-shadow ease-in 0.25s; */
            box-shadow: 0 0px 7px rgb(30 26 28 / 50%);


        }
    </style>
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
    $sql = "SELECT * FROM reception WHERE username = ?";

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
        echo "<table border='1' class='table table-hover'>";
        echo "<tr>";
        echo "<th>Username</th>";
        echo "<th>District</th>";
        echo "<th>n_nomenclature</th>";
        echo "<th>Designation</th>";
        echo "<th>Prix Total</th>";
        echo "<th>Quantite </th>";
        echo "<th>Date Envoie</th>";
        echo "<th>Actions</th>";
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
            echo "<td><a href='rabat.php'> <button class='accepter' onclick=\"accepterData('" . $row['username'] . "', '" . $row['district'] . "', '" . $row['n_nomenclature'] . "', '" . $row['designation'] . "', '" . $row['prix_total'] . "', '" . $row['quantite_maintenu'] . "', '" . $row['date_envoie'] . "')\">Accepter</button></a></td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<h2>vous ñ'avez aucun DM pour réceptionner.</h2>";
    }
} else {
    echo "User not logged in."; // Add appropriate handling if the user is not logged in
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>

<script>
    function accepterData(username, district, n_nomenclature, designation, prix_total, quantite_maintenu, date_envoie) {
        // AJAX request to send the data to the etat_dm table
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Handle the response from the server if needed
                console.log(this.responseText);
            }
        };
        xhttp.open("POST", "accepter_data.php", true); // Change "accepter_data.php" to the file handling the insertion into etat_dm table
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("username=" + encodeURIComponent(username) + "&district=" + encodeURIComponent(district) + "&n_nomenclature=" + encodeURIComponent(n_nomenclature) + "&designation=" + encodeURIComponent(designation) + "&prix_total=" + encodeURIComponent(prix_total) + "&quantite_maintenu=" + encodeURIComponent(quantite_maintenu) + "&date_envoie=" + encodeURIComponent(date_envoie));
    }
</script>

</body>
</html>

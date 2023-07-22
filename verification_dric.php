<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="assets/css/users.css">

    <style>
        /* Limit the width of the "Designation" column and add ellipsis for overflow */
        td.designation-column {
            max-width: 200px; /* Adjust the width as per your requirement */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</head>

<body>
<?php
// ... Previous code for database connection ...
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

// Check if a search query has been submitted
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    // Query to fetch specific columns from the dm table based on the search query
    $sql = "SELECT username, district, n_dm, n_nomenclature, designation, prix_unitaire, quantite, projet, date_saisie, prix_total, operation, quantite_maintenu, date_envoie FROM dm WHERE username LIKE '%$search%' OR district LIKE '%$search%' OR n_nomenclature LIKE '%$search%'";
    $result = $conn->query($sql);
    // Check if there are any records in the result
    if ($result->num_rows > 0) {
        // Start the table
        echo '<table border="1">';
        // Display the table header
        echo "<tr>";
        echo "<th>Username</th>";
        echo "<th>District</th>";
        echo "<th>n_dm</th>";
        echo "<th>n_nomenclature</th>";
        echo "<th>Designation</th>";
        echo "<th>Prix Unitaire</th>";
        echo "<th>Quantite</th>";
        echo "<th>Projet</th>";
        echo "<th>Date Saisie</th>";
        echo "<th>Prix Total</th>";
        echo "<th>Decision</th>"; // New column for the buttons
        echo "</tr>";

        // Fetch each row from the result and display the data in a table row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["username"] . "</td>";
            echo "<td>" . $row["district"] . "</td>";
            echo "<td>" . $row["n_dm"] . "</td>";
            echo "<td>" . $row["n_nomenclature"] . "</td>";
            echo '<td class="designation-column">' . $row["designation"] . "</td>";
            echo "<td>" . $row["prix_unitaire"] . "</td>";
            echo "<td>" . $row["quantite"] . "</td>";
            echo "<td>" . $row["projet"] . "</td>";
            echo "<td>" . $row["date_saisie"] . "</td>";
            echo "<td>" . $row["prix_total"] . "</td>";

            // Decision column with buttons
            echo '<td>';
            echo '<button class="envoyer-btn" data-n_dm="' . $row["n_dm"] . '">Envoyer</button>';
            echo '<button>Annuler</button>';
            echo '</td>';
            echo "</tr>";
        }

        // Close the table
        echo "</table>";
    } else {
        // If no records are found, display a message
        echo "<h1>Aucune information trouvée pour la requête de recherche: " . $search . "</h1>";
    }
} else {
    // If no search query is provided, display all data from the dm table
    $sql = "SELECT username, district, n_dm, n_nomenclature, designation, prix_unitaire, quantite, projet, date_saisie, prix_total, operation, quantite_maintenu, date_envoie FROM dm";
    $result = $conn->query($sql);
    // Check if there are any records in the result
    if ($result->num_rows > 0) {
        // Start the table
        echo '<table border="1">';
        // Display the table header
        echo "<tr>";
        echo "<th>Username</th>";
        echo "<th>District</th>";
        echo "<th>n_dm</th>";
        echo "<th>n_nomenclature</th>";
        echo "<th>Designation</th>";
        echo "<th>Prix Unitaire</th>";
        echo "<th>Quantite</th>";
        echo "<th>Projet</th>";
        echo "<th>Date Saisie</th>";
        echo "<th>Prix Total</th>";
        echo "<th>Decision</th>"; // New column for the buttons
        echo "</tr>";

        // Fetch each row from the result and display the data in a table row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["username"] . "</td>";
            echo "<td>" . $row["district"] . "</td>";
            echo "<td>" . $row["n_dm"] . "</td>";
            echo "<td>" . $row["n_nomenclature"] . "</td>";
            echo '<td class="designation-column">' . $row["designation"] . "</td>";
            echo "<td>" . $row["prix_unitaire"] . "</td>";
            echo "<td>" . $row["quantite"] . "</td>";
            echo "<td>" . $row["projet"] . "</td>";
            echo "<td>" . $row["date_saisie"] . "</td>";
            echo "<td>" . $row["prix_total"] . "</td>";

            // Decision column with buttons
            echo '<td>';
            echo '<button class="envoyer-btn" data-n_dm="' . $row["n_dm"] . '">Envoyer</button>';
            echo '<button>Annuler</button>';
            echo '</td>';
            echo "</tr>";
        }

        // Close the table
        echo "</table>";
    } else {
        // If no records are found, display a message
        echo "<h1>There is no order yet</h1>";
    }
}

// Close the connection
$conn->close();
?>

<!-- Display the search bar after the table -->
<form class="here" method="GET" action="">
    <input type="text" name="search" placeholder="Search...">
    <input type="submit" value="Search">
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $(".envoyer-btn").click(function () {
            // Get the n_dm value from the data attribute of the clicked button
            const n_dm = $(this).data("n_dm");

            // Store the reference to the current row to remove it later
            const clickedRow = $(this).closest("tr");

            // Send the n_dm value to the server using AJAX
            $.ajax({
                type: "POST",
                url: "verification_server.php",
                data: {
                    n_dm: n_dm
                },
                success: function (response) {
                    // Update the table dynamically by removing the row for the successful n_dm value
                    clickedRow.remove();
                    console.log(response);
                },
                error: function (error) {
                    console.error(error);
                },
            });
        });
    });
</script>
</body>

</html>

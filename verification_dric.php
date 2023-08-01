<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="assets/css/users.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <style>
        /* Limit the width of the "Designation" column and add ellipsis for overflow */
        td.designation-column {
            max-width: 200px; /* Adjust the width as per your requirement */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .envoyer-btn{
            font-family: 'Helvetica', 'Arial', sans-serif;
            display: inline-block;
            font-size: 1em;
            padding: 1em 2em;
            margin-top: 14px;
            margin-bottom: 28px;
            -webkit-appearance: none;
            appearance: none;
            background: linear-gradient(to right, #338f33d6, #3df93d);
            border-radius: 17px;
            border: none;
            cursor: pointer;
            position: relative;
            transition: transform cubic-bezier(0, 0, 0, 0.79) 0.1s, box-shadow ease-in 0.25s;
            box-shadow: 0 -6px 12px rgb(30 26 28 / 50%);

        }
        .anuller-btn{
            font-family: 'Helvetica', 'Arial', sans-serif;
            display: inline-block;
            font-size: 1em;
            padding: 1em 2em;
            margin-top: 14px;
            margin-bottom: 28px;
            -webkit-appearance: none;
            appearance: none;
            background: linear-gradient(to right, #df8585d6, #a70000);
            border-radius: 17px;
            border: none;
            cursor: pointer;
            position: relative;
            transition: transform cubic-bezier(0, 0, 0, 0.79) 0.1s, box-shadow ease-in 0.25s;
            box-shadow: 0 -6px 12px rgb(30 26 28 / 50%);

        }
        .here{

            margin-bottom: 1000px;
            margin-left: -137px;
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
        echo '<table border="1" class="table table-hover">';
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
            echo '<br>';

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
        echo '<table border="1" class="table table-hover">';
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

            echo '<button class="anuller-btn" data-n_dm="' . $row["n_dm"] . '">Annuler</button>';

            echo '</td>';
            echo "</tr>";
        }

        // Close the table
        echo "</table>";
    } else {
        echo "<center>";

        echo "<p>Aucune DM pour l'instant</p>";
        echo "</center>";

    }
}

// Close the connection
$conn->close();
?>

<!-- Display the search bar after the table -->


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

    $(document).ready(function () {
        $(".anuller-btn").click(function () {
            // Get the n_dm value from the data attribute of the clicked button
            const n_dm = $(this).data("n_dm");

            // Store the reference to the current row to remove it later
            const clickedRow = $(this).closest("tr");

            // Send the n_dm value to the server using AJAX
            $.ajax({
                type: "POST",
                url: "justification_server.php",
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
<form class="here" method="GET" action="">
    <input type="text" name="search" placeholder="Search...">
    <input type="submit" value="Search">
</form>
</body>

</html>

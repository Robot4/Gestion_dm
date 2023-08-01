<?php
// Step 1: Replace these values with your actual database credentials
$host = 'localhost';
$username = 'root';
$password = '';
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

        // Check if the 'operation' field is empty or null, and set a default value if needed
        if (empty($operation) || is_null($operation)) {
            $operation = 'envoyer'; // Set a default value
        }

        // Get all the relevant data from the 'magasin' table for the specified n_dm
        $selectQuery = "SELECT username, district, n_nomenclature, designation, prix_unitaire, quantite, projet, date_verification, nom_verificateur FROM magasin WHERE n_dm = '$n_dm'";
        $result = executeQuery($selectQuery);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $username = mysqli_real_escape_string($conn, $row['username']);
            $district = mysqli_real_escape_string($conn, $row['district']);
            $n_nomenclature = mysqli_real_escape_string($conn, $row['n_nomenclature']);
            $designation = mysqli_real_escape_string($conn, $row['designation']);
            $prix_unitaire = mysqli_real_escape_string($conn, $row['prix_unitaire']);
            $quantite = mysqli_real_escape_string($conn, $row['quantite']);
            $projet = mysqli_real_escape_string($conn, $row['projet']);
            $date_saisie = $_POST['date_saisie']; // Get the date_saisie value from the form
            $prix_total = $_POST['prix_total']; // Get the prix_total value from the form
            $date_verification = $row['date_verification']; // Get date_verification from the magasin table
            $nom_verificateur = mysqli_real_escape_string($conn, $row['nom_verificateur']); // Get nom_verificateur from the magasin table

            // Insert data into the "etat_dm" table
            $insertQuery = "INSERT INTO etat_dm (username, district, n_dm, n_nomenclature, designation, prix_unitaire, quantite, projet, date_saisie, prix_total, operation, quantite_maintenu, date_envoie, date_verification, nom_verificateur) 
            VALUES ('$username', '$district', '$n_dm', '$n_nomenclature', '$designation', '$prix_unitaire', '$quantite', '$projet', '$date_saisie', '$prix_total', '$operation', '$quantiteMaintenu', NOW(), '$date_verification', '$nom_verificateur')";
            $insertResult = executeQuery($insertQuery);

            if ($insertResult === TRUE) {
                // Successfully inserted data into the "etat_dm" table

                // Now, delete the data from the 'magasin' table
                $deleteQuery = "DELETE FROM magasin WHERE n_dm = '$n_dm'";
                $deleteResult = executeQuery($deleteQuery);

                if ($deleteResult === TRUE) {
                    // Successfully deleted data from the "magasin" table
                    echo "La dm envoyer";
                } else {
                    // Failed to delete data from the "magasin" table
                    echo "Error deleting data from 'magasin' table: " . $conn->error;
                }
            } else {
                // Failed to insert data
                echo "Error sending data to 'etat_dm' table: " . $conn->error;
            }

            // Stop further execution to prevent the entire page content from being sent back
            exit();
        } else {
            // Data not found in the "magasin" table for the specified n_dm
            echo "Data not found in 'magasin' table for n_dm: $n_dm";
            exit();
        }
    }
}

// Fetch data from the "magasin" table
$query = "SELECT * FROM magasin";
$result = executeQuery($query);
if ($result && $result->num_rows > 0) {
    // Output data in a table format
    echo '<table border="1" class="table table-hover">';
    echo '<tr>';
    echo '<th>n_dm</th>'; // Unique identifier column
    echo '<th>Username</th>';
    echo '<th>District</th>';
    echo '<th>n_nomenclature</th>';
    echo '<th>Designation</th>';
    echo '<th>Prix Unitaire</th>';
    echo '<th>Quantite</th>';
    echo '<th>Projet</th>';
    echo '<th>Date Saisie</th>'; // Add the column for Date Saisie
    echo '<th>Prix Total</th>'; // Add the column for Prix Total
    echo '<th>status</th>';
    echo '<th>Quantite Maintenu</th>';
    echo '<th>Envoyer</th>'; // New column header for the "Envoyer" button
    echo '</tr>';

    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['n_dm'] . '</td>'; // Unique identifier column
        echo '<td>' . $row['username'] . '</td>';
        echo '<td>' . $row['district'] . '</td>';
        echo '<td>' . $row['n_nomenclature'] . '</td>';
        echo '<td>' . $row['designation'] . '</td>';
        echo '<td>' . $row['prix_unitaire'] . '</td>';
        echo '<td>' . $row['quantite'] . '</td>';
        echo '<td>' . $row['projet'] . '</td>';
        echo '<td><input readonly type="date" id="date_saisie_' . $row['n_dm'] . '" value="' . date('Y-m-d') . '"></td>'; // Display the current date in the Date Saisie field
        echo '<td><input readonly type="number" id="prix_total_' . $row['n_dm'] . '" value="' . $row['prix_total'] . '"></td>'; // Display the Prix Total value
        echo '<td>';
        echo '<select id="operation_' . $row['n_dm'] . '" class="operation" required>';
        echo '<option value="envoyer" ' . ($row['operation'] === 'envoyer' ? 'selected' : '') . '>envoyer</option>';
        echo '</select>';
        echo '</td>';
        echo '<td contenteditable="true" data-field="quantite_maintenu" id="quantite_maintenu_' . $row['n_dm'] . '">' . $row['quantite_maintenu'] . '</td>';
        echo '<td><button data-n-dm="' . $row['n_dm'] . '" class="envoyer-btn">Envoyer</button></td>'; // Add the "Envoyer" button with data-n-dm attribute
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo "<center><h1>Aucune dm disponible.</h1></center>";
}

// Step 4: Close the database connection
$conn->close();
?>

<head>
    <link rel="stylesheet" href="assets/css/users.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <style>
        .envoyer-btn {
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

        .operation {
            font-size: 20px;
            padding: 16px 16px 10px 9px;
            display: block;
            width: 266px;
            border: none;
            border-bottom: 4px solid #757575;
        }
    </style>
</head>
<script>
    // JavaScript function to send data to the server
    function sendData(n_dm) {
        // Get the modified values from the selectable dropdown and the editable field using the unique identifiers
        var operationDropdown = document.querySelector('#operation_' + n_dm);
        var quantiteMaintenuElement = document.querySelector('#quantite_maintenu_' + n_dm);
        var dateSaisieElement = document.querySelector('#date_saisie_' + n_dm);
        var prixTotalElement = document.querySelector('#prix_total_' + n_dm);
        var dateSaisie = dateSaisieElement ? dateSaisieElement.value : "";
        var prixTotal = prixTotalElement ? prixTotalElement.value : "";

        // Check if the 'operationDropdown' exists and has a selected option
        if (operationDropdown && operationDropdown.value !== "") {
            var operation = operationDropdown.value;

            // Check if the 'quantiteMaintenuElement' exists
            if (quantiteMaintenuElement) {
                var quantiteMaintenu = quantiteMaintenuElement.innerText;

                // Create a FormData object and add the data to be sent
                var formData = new FormData();
                formData.append('n_dm', n_dm);
                formData.append('operation', operation);
                formData.append('quantite_maintenu', quantiteMaintenu);
                formData.append('date_saisie', dateSaisie);
                formData.append('prix_total', prixTotal);

                // Create an XMLHttpRequest object
                var xhr = new XMLHttpRequest();

                // Configure the request
                xhr.open('POST', 'magasinier_dm.php', true);

                // Set up the callback function
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                        // Handle the response here
                        var response = xhr.responseText;
                        alert(response); // Show the response in an alert box (for testing)
                        // You can also update the table or provide any other feedback to the user here
                    }
                };

                // Send the request with the FormData object
                xhr.send(formData);
            } else {
                // Handle the case where the 'quantiteMaintenuElement' does not exist
                alert('Quantite Maintenu element not found.');
            }
        } else {
            // Handle the case where the 'operationDropdown' does not exist or has no selected option
            alert('Please select a valid operation.');
        }
    }

    // Add event listeners to the "Envoyer" buttons
    var envoyerButtons = document.querySelectorAll('.envoyer-btn');
    envoyerButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            var n_dm = this.getAttribute('data-n-dm');
            sendData(n_dm);
        });
    });
</script>
</body>
</html>

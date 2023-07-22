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

// Step 4: Display data from the dm table
$query = "SELECT * FROM dmi";
$result = executeQuery($query);

if ($result->num_rows > 0) {
    // Output data in a table format
    echo '<table border="1">';
    echo '<tr>';
    echo '<th>n_dm</th>'; // Unique identifier column
    echo '<th>Username</th>';
    echo '<th>District</th>';
    echo '<th>n_nomenclature</th>';
    echo '<th>Designation</th>';
    echo '<th>Prix Unitaire</th>';
    echo '<th>Quantite</th>';
    echo '<th>Projet</th>';
    echo '<th>Date Saisie</th>';
    echo '<th>Prix Total</th>';
    echo '<th>Operation</th>';
    echo '<th>Quantite Maintenu</th>';
    echo '<th>Date Envoie</th>';
    echo '<th>Edit</th>'; // New column header for editing
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
        echo '<td>' . $row['date_saisie'] . '</td>';
        echo '<td>' . $row['prix_total'] . '</td>';
        echo '<td contenteditable="true" data-field="operation" id="operation_' . $row['n_dm'] . '">' . $row['operation'] . '</td>'; // Make the operation cell editable
        echo '<td contenteditable="true" data-field="quantite_maintenu" id="quantite_maintenu_' . $row['n_dm'] . '">' . $row['quantite_maintenu'] . '</td>'; // Make the Quantite Maintenu cell editable
        echo '<td contenteditable="true" data-field="date_envoie" id="date_envoie_' . $row['n_dm'] . '">' . $row['date_envoie'] . '</td>'; // Make the Date Envoie cell editable
        echo '<td><button onclick="updateRow(' . $row['n_dm'] . ')">Update</button></td>'; // Add an update button to save changes
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo "No data found.";
}

// Step 5: Close the database connection
$conn->close();
?>

<head>
    <link rel="stylesheet" href="assets/css/users.css">
</head>

<script>
    // JavaScript function to update data on the server
    function updateRow(n_dm) {
        // Get the modified values from the editable fields using the unique identifiers
        var operation = document.querySelector('#operation_' + n_dm).innerText;
        var quantiteMaintenu = document.querySelector('#quantite_maintenu_' + n_dm).innerText;
        var dateEnvoie = document.querySelector('#date_envoie_' + n_dm).innerText;

        // Create an XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Configure the request
        xhr.open('POST', 'update_dm.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        // Set up the callback function
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                // Handle the response here (if needed)
                alert(xhr.responseText); // Show the response in an alert box (for testing)
            }
        };

        // Send the request with the new values and n_dm (unique identifier)
        xhr.send('n_dm=' + n_dm + '&operation=' + operation + '&quantite_maintenu=' + quantiteMaintenu + '&date_envoie=' + dateEnvoie);
    }
</script>

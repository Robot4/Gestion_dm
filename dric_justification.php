<?php
// Step 1: Establish a database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_dm";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 2: Fetch data from the justifications table
$sql = "SELECT * FROM justifications";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Step 3: Display data in a table with send and delete buttons for each row
    echo "<table class='table table-hover'>";
    echo "<tr><th>Username</th><th>District</th><th>Nomenclature</th><th>Designation</th><th>Unit Price</th><th>Quantity</th><th>Project</th><th>Date Saisie</th><th>Total Price</th><th>Justification</th><th>Actions</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row['username']."</td>";
        echo "<td>".$row['district']."</td>";
        echo "<td>".$row['n_nomenclature']."</td>";
        echo "<td>".$row['designation']."</td>";
        echo "<td>".$row['prix_unitaire']."</td>";
        echo "<td>".$row['quantite']."</td>";
        echo "<td>".$row['projet']."</td>";
        echo "<td>".$row['date_saisie']."</td>";
        echo "<td>".$row['prix_total']."</td>";
        echo "<td style='color: #2ecc71'>".$row['justification']."</td>";

        // Adding send and delete buttons with JavaScript function call
        echo '<td><button class="envoyer-btn" onclick="sendToDMI('.$row['n_dm'].')">Envoyer</button> ';

        echo '<a href="delete_data.php?n_dm='.$row['n_dm'].'"  class="supprimer">Supprimer</a></td>';

        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<center>";

    echo "Aucune justification pour l'instant";

    echo "</center>";

}

// Close the database connection
$conn->close();
?>
<html>
<body>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <style>
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
        .supprimer{
            font-family: 'Helvetica', 'Arial', sans-serif;
            display: inline-block;
            color: white;
            font-size: 1em;
            padding: 1em 1em;
            margin-top: 14px;
            margin-bottom: 28px;
            -webkit-appearance: none;
            appearance: none;
            background: linear-gradient(to right, #be1b1b, #c40b0b);
            border-radius: 17px;
            border: none;
            cursor: pointer;
            position: relative;
            transition: transform cubic-bezier(0, 0, 0, 0.79) 0.1s, box-shadow ease-in 0.25s;
            box-shadow: 0 -6px 12px rgb(30 26 28 / 50%);

        }
    </style>
</head>
<!-- Add jQuery (AJAX library) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Function to handle the "send" button click event
    function sendToDMI(n_dm) {
        $.ajax({
            type: "GET",
            url: "send_data.php",
            data: { n_dm: n_dm },
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    alert(response.message);
                    // You can also update the table here if needed
                    location.reload(); // Reload the page to reflect changes in the table
                } else {
                    alert("Error: " + response.message);
                }
            },
            error: function (xhr, status, error) {
                alert("An error occurred while sending data.");
            }
        });
    }
</script>
</body>
</html>
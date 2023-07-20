<?php
// Receive the data from the client-side
$data = json_decode(file_get_contents('php://input'), true);

// Start the session to access the user's district
session_start();

// Check if the user is authenticated
if (!isset($_SESSION['username'])) {
    echo 'Error: User not authenticated.';
    exit();
}

// Get the user's district from the session
$connected_user_district = $_SESSION['district'];
$connected_username = $_SESSION['username'];


// Connect to the database (replace with your connection details)
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'gestion_dm';

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Function to calculate the prix_total for each order
function calculatePrixTotal($prixUnitaire, $quantite) {
    return $prixUnitaire * $quantite;
}

// Function to get the district for the connected user
function getDistrictForConnectedUser($conn, $user_id) {
    $user_id = intval($user_id); // Ensure user_id is an integer
    $query = "SELECT district FROM users WHERE id = $user_id";
    $result = $conn->query($query);

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();
        return $row['district'];
    } else {
        return null;
    }
}
// Insert the data for each order into the "dm" table
if (isset($data['orders']) && is_array($data['orders'])) {
    foreach ($data['orders'] as $order) {
        $nomenclature = $conn->real_escape_string($order['nomenclature']);
        $designation = $conn->real_escape_string($order['designation']);
        $prixUnitaire = floatval($order['prixUnitaire']);
        $quantite = intval($order['quantite']);
        $projet = $conn->real_escape_string($order['project']);
        $date_saisie = date('Y-m-d'); // Current date
        $prixTotal = calculatePrixTotal($prixUnitaire, $quantite);


        // Insert the data into the "dm" table along with the connected user's district
        $sql = "INSERT INTO dm (username, district, n_nomenclature, designation, prix_unitaire, quantite, projet, date_saisie, prix_total)
        VALUES ('$connected_username', '$connected_user_district', '$nomenclature', '$designation', $prixUnitaire, $quantite, '$projet', '$date_saisie', '$prixTotal')";

        if ($conn->query($sql) !== TRUE) {
            echo 'Error inserting order data: ' . $conn->error;
            $conn->close();
            exit;
        }
    }

    echo 'Order data inserted successfully!';
} else {
    echo 'No orders found to insert.';
}

$conn->close();
?>

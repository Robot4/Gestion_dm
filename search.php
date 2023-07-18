<?php
require_once('config.php');

$keyword = $_GET['keyword'];

// SQL query to search for n_nomenclature, designation, and prix_unitaire matching the keyword
$query = "SELECT n_nomenclature, designation, prix_unitaire FROM materiel WHERE n_nomenclature LIKE '%$keyword%'";

// Execute the query
$result = mysqli_query($data, $query);

// Check if the query was successful
if ($result) {
    $suggestions = array();
    // Fetch the data and add it to the suggestions array
    while ($row = mysqli_fetch_assoc($result)) {
        $suggestions[] = array(
            'n_nomenclature' => $row['n_nomenclature'],
            'designation' => $row['designation'],
            'prix_unitaire' => $row['prix_unitaire']
        );
    }
    // Return the suggestions as JSON
    echo json_encode($suggestions);
} else {
    echo 'Error executing the query: ' . mysqli_error($data);
}

// Close the database connection
mysqli_close($data);
?>

<?php
require('rabat.php');

// Check if the user is logged in and authorized to access district.php
if (!isset($_SESSION["username"]) || $_SESSION["usertype"] !== "user") {
    header("location:login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>District - ONCF</title>
</head>
<body>

<a href="logout.php">Logout</a>
<a href="profile.php">Profile</a>

<?php
// Check if the user has access to the menu items in the district
if ($_SESSION["access_district"]) {
    ?>
    <!-- Display the specific menu items for the user -->
    <ul>
        <li>Gestion DM</li>
        <li>Gestion Stock</li>
        <li>Gestion d'outillage</li>
        <li>Valorisation</li>
    </ul>
    <?php
}
?>

</body>
</html>

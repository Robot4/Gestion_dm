<?php
require('rabat.php');


if(!isset($_SESSION["username"]))
{
    header("location:login.php");
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

</body>
</html>
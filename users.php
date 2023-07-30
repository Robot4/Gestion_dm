<?php
require('navbar.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Employés</title>
    <link rel="stylesheet" href="assets/css/users.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</head>
<body>
<br>
<div class="containers">
    <div class="button-container">
        <a href="admin.php" class="Btn_add">
            <img class="icon" src="assets/images/left.svg"> retour
        </a>
    </div>

    <form  action="" method="GET">
        <input type="text" name="search" placeholder="Chercher...">

        <input type="submit" value="Search">
    </form>

    <center>
    <div class="containers">
        <div class="button-container">
            <a href="fonctions/ajouter.php" class="Btn_add">
                <img class="icon" src="assets/images/plus.png"> Ajouter
            </a>
        </div>
    </center>
    <br>

    <table  class="table table-bordered">
        <tr id="items">
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Matricule</th>
            <th>CIN</th>
            <th>Téléphone</th>
            <th>Type d'utilisateur</th>
            <th>Dric</th>
            <th>District</th>
            <th>Modifier</th>
            <th>Supprimer</th>
        </tr>
        <?php

        // Include the database connection and other necessary files
        include_once "config.php";

        // Check if a search query has been submitted
        if (isset($_GET['search'])) {
            $search = $_GET['search'];
            // Prepare the query to search for matching employees
            $query = "SELECT * FROM users WHERE email LIKE '%$search%' OR nom LIKE '%$search%' OR cin LIKE '%$search%' OR username LIKE '%$search%'";
        } else {
            // Query to fetch all employees
            $query = "SELECT * FROM users";
        }

        // Execute the query
        $result = mysqli_query($data, $query);

        // Check if any employees are found
        if (mysqli_num_rows($result) == 0) {
            // Display a message if no employees are found
            echo "<center> <h1 style='color: black'>Aucun employé trouvé</h1></center>";
        } else {
            // Display the list of employees
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?= $row['nom'] ?></td>
                    <td><?= $row['prenom'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['matricule'] ?></td>
                    <td><?= $row['cin'] ?></td>
                    <td><?= $row['telephone'] ?></td>
                    <td><?= $row['usertype'] ?></td>
                    <td><?= $row['dric'] ?></td>
                    <td><?= $row['district'] ?></td>
                    <!-- Links to modify and delete employees -->
                    <td><a href="./fonctions/modifier.php?id=<?= $row['id'] ?>"><img class="icon" src="assets/images/pen.png"></a></td>
                    <td><a href="./fonctions/supprimer.php?id=<?= $row['id'] ?>"><img class="icon" src="assets/images/trash.png"></a></td>
                </tr>
                <?php
            }
        }
        ?>
    </table>


</div>
</body>
</html>



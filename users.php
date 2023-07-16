<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Employés</title>
    <link rel="stylesheet" href="assets/css/users.css">
</head>
<body>
<div class="containers">
    <div class="button-container">
        <a href="fonctions/ajouter.php" class="Btn_add">
            <img class="icon" src="assets/images/plus.png"> Ajouter
        </a>
    </div>

    <form action="" method="GET">
        <input type="text" name="search" placeholder="Search...">
        <input type="submit" value="Search">
    </form>

    <table>
        <tr id="items">
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Matricule</th>
            <th>CIN</th>
            <th>Téléphone</th>
            <th>Type d'utilisateur</th>
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
            echo "No employees found.";
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

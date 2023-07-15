<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter</title>
    <link rel="stylesheet" href="../assets/css/users.css">
</head>
<body>
<?php
// Check if the form has been submitted
if(isset($_POST['button'])){
    // Extract the form inputs
    extract($_POST);

    // Check if all required fields are filled
    if(isset($nom) && isset($prenom) && isset($email) && isset($matricule) && isset($cin) && isset($telephone) && isset($username) && isset($password) && isset($usertype)){
        // Include the database connection configuration file
        include_once "../config.php";

        // SQL query to insert a new row into the 'users' table
        $query = "INSERT INTO users (username, password, usertype, email, nom, prenom, matricule, cin, telephone) 
                  VALUES ('$username', '$password', '$usertype', '$email', '$nom', '$prenom', '$matricule', '$cin', '$telephone')";

        // Execute the query
        $result = mysqli_query($data, $query);

        if($result){
            // Redirect to the 'users.php' page if the query was successful
            header("location: ../users.php");
            exit();
        } else {
            // Display an error message if the query failed
            $message = "Employé non ajouté";
        }
    } else {
        // Display an error message if any of the required fields are empty
        $message = "Veuillez remplir tous les champs !";
    }
}
?>
<div class="form">
    <a href="../users.php" class="back_btn"><img src="../assets/images/back.png"> Retour</a>
    <h2>Ajouter un employé</h2>
    <p class="erreur_message">
        <?php
        // If the variable 'message' exists, display its content
        if(isset($message)){
            echo $message;
        }
        ?>
    </p>
    <form action="" method="POST">
        <label>Username</label>
        <input type="text" name="username">
        <label>Password</label>
        <input type="password" name="password">
        <label>User Type</label>
        <select name="usertype">
            <option value="user">User</option>
            <option value="dric">Dric</option>
            <option value="super_admin">Super Admin</option>
            <option value="dmi">DMI</option>
            <option value="magasinier">Magasinier</option>
        </select>
        <label>Email</label>
        <input type="email" name="email">
        <label>Nom</label>
        <input type="text" name="nom">
        <label>Prénom</label>
        <input type="text" name="prenom">
        <label>Matricule</label>
        <input type="text" name="matricule">
        <label>Cin</label>
        <input type="text" name="cin">
        <label>Téléphone</label>
        <input type="text" name="telephone">
        <input type="submit" value="Ajouter" name="button">
    </form>
</div>
</body>
</html>

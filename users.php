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
<div class="container">
    <a href="fonctions/ajouter.php" class="Btn_add"> <img src="assets/images/plus.png"> Ajouter</a>

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
        session_start();

        //inclure la page de connexion
        include_once "config.php";
        //requête pour afficher la liste des employés
        $req = mysqli_query($data , "SELECT * FROM users");
        if(mysqli_num_rows($req) == 0){
            //s'il n'existe pas d'employé dans la base de données, alors on affiche ce message :
            echo "Il n'y a pas encore d'employé ajouté !" ;
        } else {
            //si non, affichons la liste de tous les employés
            while($row = mysqli_fetch_assoc($req)){
                ?>
                <tr>
                    <td><?=$row['nom']?></td>
                    <td><?=$row['prenom']?></td>
                    <td><?=$row['email']?></td>
                    <td><?=$row['matricule']?></td>
                    <td><?=$row['cin']?></td>
                    <td><?=$row['telephone']?></td>
                    <td><?=$row['usertype']?></td>
                    <!--Nous allons mettre l'id de chaque employé dans ce lien -->
                    <td><a href="./fonctions/modifier.php?id=<?=$row['id']?>"><img src="assets/images/pen.png"></a></td>
                    <td><a href="./fonctions/supprimer.php?id=<?=$row['id']?>"><img src="assets/images/trash.png"></a></td>
                </tr>
                <?php
            }
        }
        ?>
    </table>
</div>
</body>
</html>

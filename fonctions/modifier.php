<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter</title>
    <link rel="stylesheet" href="../assets/css/users.css">
</head>
<body bgcolor="#d1d1d1">
<center>
<?php

         //connexion à la base de donnée
          include_once "../config.php";
         //on récupère le id dans le lien
          $id = $_GET['id'];
          //requête pour afficher les infos d'un employé
          $req = mysqli_query($data , "SELECT * FROM users WHERE id = $id");
          $row = mysqli_fetch_assoc($req);


       //vérifier que le bouton ajouter a bien été cliqué
       if(isset($_POST['button'])){
           //extraction des informations envoyé dans des variables par la methode POST
           extract($_POST);
           //verifier que tous les champs ont été remplis
           if(isset($nom) && isset($prenom) && $email && $matricule && $cin && $telephone){
               //requête de modifi²cation
               $req = mysqli_query($data, "UPDATE users SET nom = '$nom' , prenom = '$prenom' , email = '$email', password = '$password', usertype = '$usertype' , matricule = '$matricule' , cin = '$cin'  , telephone = '$telephone' WHERE id = $id");
                if($req){//si la requête a été effectuée avec succès , on fait une redirection
                    header("location: ../rabat.php");
                }else {//si non
                    $message = "Employé non modifié";
                }

           }else {
               //si non
               $message = "Veuillez remplir tous les champs !";
           }
       }

    ?>

    <div class="form">
        <a href="../rabat.php" class="back_btn"><img src="../assets/images/back.png"> Retour</a>
        <h2>Modifier l'employé : <?=$row['nom']?> </h2>
        <p class="erreur_message">
           <?php
              if(isset($message)){
                  echo $message ;
              }
           ?>
        </p>
        <form action="" method="POST">
            <label>Nom</label>
            <input type="text" name="nom" value="<?=$row['nom']?>">
            <label>Prénom</label>
            <input type="text" name="prenom" value="<?=$row['prenom']?>">
            <label>Email</label>
            <input type="email" name="email" value="<?=$row['email']?>">
            <label>Mote de Passe</label>
            <input type="password" name="password" value="<?=$row['password']?>">
            <label>user type</label>
            <input type="text" name="usertype" value="<?=$row['usertype']?>">
            <label>Matricule</label>
            <input type="text" name="matricule" value="<?=$row['matricule']?>">
            <label>Cin</label>
            <input type="text" name="cin" value="<?=$row['cin']?>">
            <label>Telephone</label>
            <input type="text" name="telephone" value="<?=$row['telephone']?>">

            <input type="submit" value="Modifier" name="button">
        </form>
    </div>
</center>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter</title>
    <link rel="stylesheet" href="../assets/css/users.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</head>
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
           if(isset($nom) && isset($prenom) && $email && $matricule && $cin && $telephone && $dric && $district){
               //requête de modifi²cation
               $req = mysqli_query($data, "UPDATE users SET nom = '$nom' , prenom = '$prenom' , email = '$email', password = '$password', usertype = '$usertype' , matricule = '$matricule' , cin = '$cin'  , telephone = '$telephone', dric = '$dric', district = '$district' WHERE id = $id");
                if($req){//si la requête a été effectuée avec succès , on fait une redirection
                    header("location: ../users.php");
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
        <a href="../users.php" class="back_btn"><img src="../assets/images/back.png"> Retour</a>
        <h2>Modifier l'employé : <?=$row['nom']?> </h2>
        <p class="erreur_message">
           <?php
              if(isset($message)){
                  echo $message ;
              }
           ?>
        </p>
        <form action="" method="POST">

            <div class="mb-3">
            <label class="form-label">Nom</label>
            <input class="form-control" type="text" name="nom" value="<?=$row['nom']?>">
            </div>

            <div class="mb-3">
            <label class="form-label">Prénom</label>
            <input class="form-control" type="text" name="prenom" value="<?=$row['prenom']?>">
            </div>

            <div class="mb-3">
            <label class="form-label">Email</label>
            <input class="form-control" type="email" name="email" value="<?=$row['email']?>">
            </div>

            <div class="mb-3">
            <label class="form-label">Mote de Passe</label>
            <input class="form-control" type="password" name="password" value="<?=$row['password']?>">
            </div>

            <div class="mb-3">
            <label class="form-label">user type</label>
            <input class="form-control" type="text" name="usertype" value="<?=$row['usertype']?>">
            </div>

            <div class="mb-3">
            <label class="form-label">Matricule</label>
            <input class="form-control" type="text" name="matricule" value="<?=$row['matricule']?>">
            </div>

            <div class="mb-3">
            <label class="form-label">Cin</label>
            <input class="form-control" type="text" name="cin" value="<?=$row['cin']?>">
            </div>

            <div class="mb-3">
            <label class="form-label">Telephone</label>
            <input class="form-control" type="text" name="telephone" value="<?=$row['telephone']?>">
            </div>

            <div class="mb-3">
            <label class="form-label">Dric</label>
            <input class="form-control" type="text" name="dric" value="<?=$row['dric']?>">
            </div>

            <div class="mb-3">
            <label class="form-label">District</label>
            <input class="form-control" type="text" name="district" value="<?=$row['district']?>">
            </div>

            <input class="btn btn-primary" type="submit" value="Modifier" name="button">
        </form>
    </div>
</center>
</body>
</html>
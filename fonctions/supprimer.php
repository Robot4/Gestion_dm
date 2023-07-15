<?php
  //connexion a la base de données
  include_once "../config.php";
  //récupération de l'id dans le lien
  $id= $_GET['id'];
  //requête de suppression
  $req = mysqli_query($data , "DELETE FROM users WHERE id = $id");
  //redirection vers la page index.php
  header("Location:../users.php")
?>
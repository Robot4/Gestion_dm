<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("location:login.php");
    exit();
}

$usertype = $_SESSION["usertype"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <style>
        body {
            background-image: url('assets/images/index.png');
            background-repeat: no-repeat;
            background-size: cover;
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
        }
    </style>
</head>
<body>


<header>
    <div class="header-left">
        <div class="logo">
            <a href="#">
                <img src="assets/images/logo.png" alt="">
            </a>
        </div>
        <nav>
            <ul>

            </ul>

        </nav>
    </div>
    <div class="header-right">

        <div class="hamburger">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
</header>
<br>
<center>
<h1 style="color: white"><?php echo "bienvenu " . $_SESSION["username"]; ?></h1>
</center>

<center>


    <div class="btn">

        <a href="users.php" class="btn btn-dark">Gestion D'utilisateur</a>
    </div>
    <div class="btn">

        <a href="rabat_dm.php" class="btn btn-dark">Les Dms</a>
    </div>
    <div class="btn">

        <a href="rabat_verification.php"class="btn btn-dark">Les Dm Validé</a>
    </div>

    <div class="btn">

        <a href="all.php" class="btn btn-dark">Stock District</a>
    </div>

    <div class="btn">

        <a href="gestion_materiel.php" class="btn btn-dark">Materiel</a>
    </div>



    <div class="btn">

        <a href="rabat_outillage.php" class="btn btn-dark">Stock outillage</a>
    </div>
    <div class="btn">

        <a href="rabat_valeur.php" class="btn btn-dark">Valeurisation District</a>
    </div>

    <div class="btn">

        <a href="rabat_justifications.php" class="btn btn-dark">Justification</a>
    </div>

    <div class="btn">

        <a href="profile.php" class="btn btn-dark">Profile</a>
    </div>


    <div class="btn">

        <a href="logout.php" class="btn btn-danger">Se déconnecter</a>
    </div>

</center>



<script>
    hamburger = document.querySelector(".hamburger");
    nav = document.querySelector("nav");
    hamburger.onclick = function() {
        nav.classList.toggle("active");
    }
</script>
</body>
</html>
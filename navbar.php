<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header>
    <div class="header-left">
        <div class="logo">
            <a href="index.php">
                <img src="assets/images/logo.png" alt="">
            </a>
        </div>
        <nav>
            <ul>
                <li>
                    <a href="index.php" class="active">Accueil</a>
                </li>
                <li>
                    <a href="creer_dm.php">add</a>
                </li>
                <li>
                    <a href="">Pricing</a>
                </li>
                <li>
                    <a href="">About</a>
                </li>
            </ul>
        </nav>
    </div>



    <div class="hamburger">
        <div></div>
        <div></div>
        <div></div>
    </div>
</header>

<script>
    const hamburger = document.querySelector(".hamburger");
    const nav = document.querySelector("nav");
    hamburger.onclick = function() {
        nav.classList.toggle("active");
    }
</script>

</body>
</html>

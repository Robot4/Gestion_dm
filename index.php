<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
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


<center>


<div class="btn">

    <a href="login.php">LOGIN</a>
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        body {
            background-image: url('assets/images/bg.jpg');
            background-repeat: no-repeat;
            background-size: cover;
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

                <li>
                    <a href="">Products</a>
                </li>
                <li>
                    <a href="">Pricing</a>
                </li>
                <li>
                    <a href="">About</a>
                </li>

            </ul>
            <div class="login-signup">
                <a href="login.php">Login</a>
            </div>
        </nav>
    </div>
    <div class="header-right">
        <div class="login-signup">
            <a href="login.php">Login</a>
        </div>
        <div class="hamburger">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
</header>
<script>
    hamburger = document.querySelector(".hamburger");
    nav = document.querySelector("nav");
    hamburger.onclick = function() {
        nav.classList.toggle("active");
    }
</script>
</body>
</html>
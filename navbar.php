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
                    <a href="">Products</a>
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

    <?php
    $current_page = basename($_SERVER['PHP_SELF']); // Get the current page filename

    if (isset($_SESSION['username'])) {
        echo '
        <div class="header-right">
            <div class="login-signup">';
        if ($current_page !== 'rabat.php') { // Check if the current page is not "rabat.php"
            echo '<a href="logout.php">Logout</a>';
        }
        echo '</div>
        </div>';
    } else {
        // User is not logged in, display login button
        echo '
        <div class="header-right">
            <div class="login-signup">';
        if ($current_page !== 'login.php') { // Check if the current page is not login.php
            echo '<a href="login.php">Login</a>';
        }
        echo '</div>
        </div>';
    }
    ?>

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

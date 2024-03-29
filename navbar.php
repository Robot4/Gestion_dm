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
            <ul id="menu">

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

    // Get the current page URL
    const currentPageURL = window.location.pathname;

    // Check if the current page is "login.php"
    if (currentPageURL.includes("login.php")) {
        // Hide the content in the <ul> element
        const menu = document.getElementById("menu");
        menu.style.display = "none";
    }
</script>

</body>
</html>

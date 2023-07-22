<?php
session_start();

require('config.php');
require('navbar.php');

// Check if the user is already logged in
if (isset($_SESSION['username'])) {
    header("Location: district.php");
    exit();
}

// Process the login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $remember = isset($_POST["remember"]); // Check if the "Remember Me" checkbox is checked

    $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
    $stmt = mysqli_prepare($data, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $email, $password);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_array($result);

        if ($row !== null) {
            $_SESSION["username"] = $row["username"]; // Store the username in the session
            $_SESSION["usertype"] = $row["usertype"]; // Store the usertype in the session
            $_SESSION["district"] = $row["district"]; // Store the district in the session


            if ($remember) {
                // Generate a long-lived session token
                $token = bin2hex(random_bytes(32)); // Generate a secure random token
                $user_id = $row["user_id"]; // Assuming your users table has a unique user_id column

                // Store the session token in the database
                $sql = "UPDATE users SET session_token = ? WHERE user_id = ?";
                $stmt = mysqli_prepare($data, $sql);

                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, "si", $token, $user_id);
                    mysqli_stmt_execute($stmt);

                    // Set a cookie with the session token
                    $cookie_name = "session_token";
                    $cookie_value = $token;
                    $cookie_expiry = time() + (30 * 24 * 60 * 60); // Cookie expires in 30 days
                    setcookie($cookie_name, $cookie_value, $cookie_expiry, '/', '', true, true); // Secure, HTTP-only cookie
                } else {
                    echo "Error in database query";
                }
            }

            if ($row["usertype"] == "user") {
                header("Location: district.php");
                exit();
            } elseif ($row["usertype"] == "dric") {
                header("Location: dric.php");
                exit();
            } elseif ($row["usertype"] == "super_admin") {
                header("Location: rabat.php");
                exit();
            }
            elseif ($row["usertype"] == "dmi") {
                header("Location: dmi.php");
                exit();
            }
            elseif ($row["usertype"] == "magasinier") {
                header("Location: magasin.php");
                exit();
            }
        } else {
            echo "Merci de vérifier vos informations.";
        }
    } else {
        echo "Error in database query";
    }


}
?>

<!DOCTYPE html>
<head>
    <title>ONCF-CONNECT</title>
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
<br><br><br><br><br><br><br><br><br><br><br><br><br>
<div>
    <div class="container eq">
        <div class="card info col">
            <div class="logo animated">
                <img src="assets/images/logo_blanc.png">
            </div>
            <h1 class="animated">L'avenir se lit sur nos lignes</h1>
            <p class="para animated">Si vous avez des problèmes d'accès à votre compte en raison d'un mot de passe oublié, notre équipe est disponible pour vous apporter une assistance professionnelle et efficace. N'hésitez pas à contacter Monsieur Mohsin pour obtenir de l'aide.</p>
            <p class="copy animated">&copy; 2023</p>
        </div>
        <div class="card col">
            <h1 class="title animated">Bienvenue</h1>
            <form action="#" method="POST">
                <div class="input-container animated">
                    <label for="Username">Email</label>
                    <input type="text" id="Username" name="email" required="required"/>
                    <div class="bar"></div>
                </div>
                <div class="input-container animated">
                    <label for="Password">Mot de passe</label>
                    <input type="password" id="Password" name="password" required="required"/>
                    <div class="bar"></div>
                </div>
                <div class="checkbox-container animated">
                    <input type="checkbox" id="Remember" name="remember"/>
                    <label class="remember" for="Remember" >Se souvenir de moi</label>
                </div>
                <br>
                <div class="button-container animated">
                    <button type="submit">Se connecter</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
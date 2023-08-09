<?php
// profile.php

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    header("Location: login.php"); // Redirect to the login page if not logged in
    exit();
}

// Retrieve user information from the database based on the logged-in username
$host = "localhost";
$user = "root";
$password = "";
$db = "gestion_dm";

$data = mysqli_connect($host, $user, $password, $db);

if ($data === false) {
    die("connection error");
}

$username = $_SESSION["username"];

$sql = "SELECT * FROM users WHERE username = ?";
$stmt = mysqli_prepare($data, $sql);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

// Initialize the success message and error message variables
$successMessage = '';
$errorMessage = '';

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize the input data
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $nom = isset($_POST["nom"]) ? trim($_POST["nom"]) : $row['nom'];
    $prenom = isset($_POST["prenom"]) ? trim($_POST["prenom"]) : $row['prenom'];
    $matricule = isset($_POST["matricule"]) ? trim($_POST["matricule"]) : $row['matricule'];
    $cin = isset($_POST["cin"]) ? trim($_POST["cin"]) : $row['cin'];
    $telephone = isset($_POST["telephone"]) ? trim($_POST["telephone"]) : $row['telephone'];

    // Validate email
    if (!$email) {
        $errorMessage = "Invalid email address.";
    } else {
        // Update the user's information in the database
        $updateSql = "UPDATE users SET email=?, nom=?, prenom=?, matricule=?, cin=?, telephone=? WHERE username=?";
        $stmt = mysqli_prepare($data, $updateSql);
        mysqli_stmt_bind_param($stmt, "sssssss", $email, $nom, $prenom, $matricule, $cin, $telephone, $username);
        mysqli_stmt_execute($stmt);

        // Handle profile image upload
        if ($_FILES["profile_image"]["name"]) {
            $targetDir = "profile_images/";
            $targetFile = $targetDir . basename($_FILES["profile_image"]["name"]);
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            // Check if the uploaded file is an actual image
            $check = getimagesize($_FILES["profile_image"]["tmp_name"]);
            if ($check === false) {
                $errorMessage = "The uploaded file is not an image.";
            } elseif ($imageFileType !== "jpg" && $imageFileType !== "png" && $imageFileType !== "jpeg" && $imageFileType !== "gif") {
                // Check file format (you can add more supported formats if needed)
                $errorMessage = "Only JPG, JPEG, PNG, and GIF files are allowed.";
            } else {
                if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetFile)) {
                    // If image upload is successful, update the profile image URL in the database
                    $updateImageSql = "UPDATE users SET profile_image=? WHERE username=?";
                    $stmt = mysqli_prepare($data, $updateImageSql);
                    mysqli_stmt_bind_param($stmt, "ss", $targetFile, $username);
                    mysqli_stmt_execute($stmt);

                    $successMessage = "Profile image uploaded and information updated successfully.";
                } else {
                    $errorMessage = "Sorry, there was an error uploading your image.";
                }
            }
        }

        $successMessage = "Your information is updated.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="assets/css/profile.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="user-container">
    <?php if (!empty($row['profile_image'])): ?>
        <img class="profile-image" src="<?php echo $row['profile_image']; ?>" alt="Profile Image">
    <?php else: ?>
        <img class="profile-image" src="profile_images/by_default.png" alt="Default Image">
    <?php endif; ?>
    <br>
    <h2><?php echo $_SESSION["username"]; ?></h2>
    <div class="user-info-form">
        <p>Email: <?php echo $row['email']; ?></p>
        <p>Nom: <?php echo $row['nom']; ?></p>
        <p>Prenom: <?php echo $row['prenom']; ?></p>
        <p>Matricule: <?php echo $row['matricule']; ?></p>
        <p>CIN: <?php echo $row['cin']; ?></p>
        <p>Telephone: <?php echo $row['telephone']; ?></p>
    </div>
</div>

<br>
<br>
<br>
<br>
<center>
    <div class="container">
        <div class="header">
            <h2>Modifier Vos Informations</h2>
        </div>
        <form id="form" class="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
            <div class="form-control">
                <label>Email:</label>
                <input type="email" name="email" value="<?php echo $row['email']; ?>" readonly><br>
                <i class="fas fa-check-circle"></i>
                <i class="fas fa-exclamation-circle"></i>
                <small>Error message</small>
            </div>

            <div class="form-control">
                <label>Nom:</label>
                <input type="text" name="nom" placeholder="Modifier Votre Nom" value="<?php echo $row['nom']; ?>"><br>
                <i class="fas fa-check-circle"></i>
                <i class="fas fa-exclamation-circle"></i>
                <small>Error message</small>
            </div>

            <div class="form-control">
                <label>Prenom:</label>
                <input type="text" name="prenom" placeholder="Modifier Votre Prénom" value="<?php echo $row['prenom']; ?>"><br>
            </div>

            <div class="form-control">
                <label>Matricule:</label>
                <input type="text" name="matricule" placeholder="Modifier Votre Matricule" value="<?php echo $row['matricule']; ?>"><br>
            </div>

            <div class="form-control">
                <label>CIN:</label>
                <input type="text" name="cin" placeholder="Modifier Votre CIN" value="<?php echo $row['cin']; ?>"><br>
            </div>

            <div class="form-control">
                <label>Telephone:</label>
                <input type="text" name="telephone" placeholder="Modifier Votre Télé" value="<?php echo $row['telephone']; ?>"><br>
            </div>

            <div class="form-control">
                <label>Profile Image:</label>
                <input type="file" name="profile_image"><br>
            </div>
            <input class="button" type="submit" name="update_profile" value="Save">
        </form>
    </div>
</center>

<center>
    <div class="vertical-line"></div>
</center>

<!-- Display success message -->
<?php if ($successMessage !== ''): ?>
    <p><?php echo $successMessage; ?></p>
<?php endif; ?>

<!-- Display error message -->
<?php if ($errorMessage !== ''): ?>
    <p><?php echo $errorMessage; ?></p>
<?php endif; ?>

<script src="assets/js/panel.js"></script>

<style>
    /* Your existing CSS */
    /* ... (Place your existing CSS code here) ... */

    /* Responsive adjustments */
    @media screen and (max-width: 768px) {
        .user-container, .container {
            padding: 10px;
            width: 90%;
            margin: 0 auto;
        }

        img.profile-image {
            width: 120px;
            height: 120px;
        }

        .vertical-line {
            display: none; /* Hide the vertical line on smaller screens */
        }
    }

    @media screen and (max-width: 480px) {
        .user-container, .container {
            padding: 10px;
            width: 90%;
            margin: 0 auto;
        }

        img.profile-image {
            width: 100px;
            height: 100px;
        }
    }
</style>

</body>
</html>
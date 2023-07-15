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

// Initialize the success message
$successMessage = '';

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update the user's information in the database
    $email = $_POST["email"];
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $matricule = $_POST["matricule"];
    $cin = $_POST["cin"];
    $telephone = $_POST["telephone"];

    $updateSql = "UPDATE users SET email=?, nom=?, prenom=?, matricule=?, cin=?, telephone=? WHERE username=?";
    $stmt = mysqli_prepare($data, $updateSql);
    mysqli_stmt_bind_param($stmt, "sssssss", $email, $nom, $prenom, $matricule, $cin, $telephone, $username);
    mysqli_stmt_execute($stmt);

    // Handle profile image upload
    if (isset($_FILES["profile_image"]) && $_FILES["profile_image"]["error"] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES["profile_image"]["tmp_name"];
        $imageFileName = $_FILES["profile_image"]["name"];
        $imageDestination = "profile_images/" . $imageFileName; // Specify the directory where the images will be saved
        move_uploaded_file($imageTmpPath, $imageDestination);

        // Update the profile image path in the database
        $updateImageSql = "UPDATE users SET profile_image=? WHERE username=?";
        $stmt = mysqli_prepare($data, $updateImageSql);
        mysqli_stmt_bind_param($stmt, "ss", $imageDestination, $username);
        mysqli_stmt_execute($stmt);
    }

    $successMessage = "Your information is updated.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="assets/css/profile.css">


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



<br><br><br><br><br><br>
<!-- Form to update information and profile image -->
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
    <input type="text" name="nom" placeholder="Modifier Votre Nom"><br>
        <i class="fas fa-check-circle"></i>
        <i class="fas fa-exclamation-circle"></i>
        <small>Error message</small>
    </div>

    <div class="form-control">
    <label>Prenom:</label>
    <input type="text" name="prenom" placeholder="Modifier Votre Prénom" ><br>

    </div>

    <div class="form-control">
    <label>Matricule:</label>
    <input type="text" name="matricule" placeholder="Modifier Votre Matricule" ><br>

    </div>

    <div class="form-control">
    <label>CIN:</label>
    <input type="text" name="cin" placeholder="Modifier Votre matricule"><br>

    </div>

    <div class="form-control">
    <label>Telephone:</label>
    <input type="text" name="telephone" placeholder="Modifier Votre Télé"><br>

    </div>

    <div class="form-control">
    <label>Profile Image:</label>
    <input type="file" name="profile_image"><br>

    </div>
    <input class="button" type="submit" value="Save">


</form>
    </div>
</center>

















<center>
    <div class="vertical-line"></div>

</center>
<script src="assets/js/panel.js"></script>

</body>
</html>


    <!-- Display success message -->
<?php if ($successMessage !== ''): ?>
    <p><?php echo $successMessage; ?></p>
<?php endif; ?>
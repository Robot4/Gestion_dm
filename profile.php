<?php
// profile.php
require('navbar.php');

session_start();

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
    <title>User Profile</title>
    <style>
        img.profile-image {
            max-width: 200px;
            max-height: 200px;
        }
    </style>
</head>
<body>
<h1>User Profile</h1>

<!-- Display success message -->
<?php if ($successMessage !== ''): ?>
    <p><?php echo $successMessage; ?></p>
<?php endif; ?>

<!-- Display current user information -->
<h2>Welcome, <?php echo $_SESSION["username"]; ?></h2>
<p>Email: <?php echo $row['email']; ?></p>
<p>Nom: <?php echo $row['nom']; ?></p>
<p>Prenom: <?php echo $row['prenom']; ?></p>
<p>Matricule: <?php echo $row['matricule']; ?></p>
<p>CIN: <?php echo $row['cin']; ?></p>
<p>Telephone: <?php echo $row['telephone']; ?></p>

<!-- Display user profile image -->
<?php if (!empty($row['profile_image'])): ?>
    <img class="profile-image" src="<?php echo $row['profile_image']; ?>" alt="Profile Image">
<?php endif; ?>

<!-- Form to update information and profile image -->
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
    <label>Email:</label>
    <input type="email" name="email" value="<?php echo $row['email']; ?>"><br>

    <label>Nom:</label>
    <input type="text" name="nom" value="<?php echo $row['nom']; ?>"><br>

    <label>Prenom:</label>
    <input type="text" name="prenom" value="<?php echo $row['prenom']; ?>"><br>

    <label>Matricule:</label>
    <input type="text" name="matricule" value="<?php echo $row['matricule']; ?>"><br>

    <label>CIN:</label>
    <input type="text" name="cin" value="<?php echo $row['cin']; ?>"><br>

    <label>Telephone:</label>
    <input type="text" name="telephone" value="<?php echo $row['telephone']; ?>"><br>

    <label>Profile Image:</label>
    <input type="file" name="profile_image"><br>

    <input type="submit" value="Save">
</form>


</body>
</html>



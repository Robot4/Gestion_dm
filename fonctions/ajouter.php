<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter</title>
    <link rel="stylesheet" href="../assets/css/users.css">
    <script>
        function updateDistrictOptions() {
            var dricSelect = document.getElementById("dric");
            var districtSelect = document.getElementById("district");
            var selectedDric = dricSelect.value;

            // Clear current options
            districtSelect.innerHTML = "";

            // Add options based on selected Dric
            if (selectedDric === "dric centre") {
                var optionRabat = document.createElement("option");
                optionRabat.value = "rabat";
                optionRabat.textContent = "Rabat";
                districtSelect.appendChild(optionRabat);

                var optionCasablanca = document.createElement("option");
                optionCasablanca.value = "casablanca";
                optionCasablanca.textContent = "Casablanca";
                districtSelect.appendChild(optionCasablanca);

                var optionSafi = document.createElement("option");
                optionSafi.value = "safi";
                optionSafi.textContent = "Safi";
                districtSelect.appendChild(optionSafi);

            } else if (selectedDric === "dric sud") {
                var optionCasablanca = document.createElement("option");
                optionCasablanca.value = "casablanca";
                optionCasablanca.textContent = "Casablanca";
                districtSelect.appendChild(optionCasablanca);
            } else if (selectedDric === "dric nord") {
                var optionSafi = document.createElement("option");
                optionSafi.value = "safi";
                optionSafi.textContent = "Safi";
                districtSelect.appendChild(optionSafi);
            }
        }
    </script>


</head>
<body>
<?php
if (isset($_POST['button'])) {
    // Extract the form inputs
    extract($_POST, EXTR_PREFIX_ALL, 'form');

    // Check if all required fields are filled
    if (isset($form_nom) && isset($form_prenom) && isset($form_email) && isset($form_matricule) && isset($form_cin) && isset($form_telephone) && isset($form_username) && isset($form_password) && isset($form_usertype) && isset($form_dric) && isset($form_district)) {
        // Include the database connection configuration file
        include_once "../config.php";

        // SQL query to insert a new row into the 'users' table
        $query = "INSERT INTO users (username, password, usertype, email, nom, prenom, matricule, cin, telephone, dric, district) 
                  VALUES ('$form_username', '$form_password', '$form_usertype', '$form_email', '$form_nom', '$form_prenom', '$form_matricule', '$form_cin', '$form_telephone', '$form_dric', '$form_district')";

        // Execute the query
        $result = mysqli_query($data, $query);

        if ($result) {
            // Redirect to the 'users.php' page if the query was successful
            header("location: ../rabat.php");
            exit();
        } else {
            // Display an error message if the query failed
            $message = "Employé non ajouté";
        }
    } else {
        // Display an error message if any of the required fields are empty
        $message = "Veuillez remplir tous les champs !";
    }
}
?>

<div class="form">
    <a href="../rabat.php" class="back_btn"><img src="../assets/images/back.png"> Retour</a>
    <h2>Ajouter un employé</h2>
    <p class="erreur_message">
        <?php
        // If the variable 'message' exists, display its content
        if(isset($message)){
            echo $message;
        }
        ?>
    </p>
    <form action="" method="POST">
        <label>Username</label>
        <input type="text" name="username">
        <label>Password</label>
        <input type="password" name="password">
        <label>User Type</label>
        <select name="usertype">
            <option value="user">User</option>
            <option value="dric">Dric</option>
            <option value="super_admin">Super Admin</option>
            <option value="dmi">DMI</option>
            <option value="magasinier">Magasinier</option>
        </select>
        <label>Email</label>
        <input type="email" name="email">
        <label>Nom</label>
        <input type="text" name="nom">
        <label>Prénom</label>
        <input type="text" name="prenom">
        <label>Matricule</label>
        <input type="text" name="matricule">
        <label>Cin</label>
        <input type="text" name="cin">
        <label>Téléphone</label>
        <input type="text" name="telephone">
        <label>Dric</label>
        <select name="dric" id="dric" onchange="updateDistrictOptions()">
            <option value="" disabled selected hidden>Select District</option>
            <option value="dric centre" >DRIC CENTRE</option>
            <option value="dric sud">DRIC SUD</option>
            <option value="dric nord">DRIC NORD</option>
        </select>

        <label>District</label>
        <select name="district" id="district">
            <!-- District options will be populated dynamically -->
        </select>
        <input type="submit" value="Ajouter" name="button">
    </form>
</div>
</body>
</html>

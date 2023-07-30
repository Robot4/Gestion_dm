

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</head>
<body bgcolor="#d1d1d1">
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
            header("location: ../users.php");
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
<center>
<div class="form">
    <a href="../users.php" class="back_btn"><img src="../assets/images/back.png"> Retour</a>
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
        <div class="mb-3">
        <b><label class="form-label">NOM D'UTILISATEUR</label></b>
        <input class="form-control" type="text" name="username" >
        </div>

        <div class="mb-3">

            <b><label class="form-label" >MOT DE PASSE</label></b>
        <input class="form-control" type="password" name="password">
        </div>

        <div class="mb-3">

            <b><label class="form-label" >TYPE D'UTILISATEUR</label></b>
        <select class="form-control" name="usertype">
            <option value="user">User</option>
            <option value="dric">Dric</option>
            <option value="super_admin">Super Admin</option>
            <option value="dmi">DMI</option>
            <option value="magasinier">Magasinier</option>
        </select>

        </div>

        <div class="mb-3">
        <b><label class="form-label" >E-MAIL</label></b>
        <input class="form-control" type="email" name="email">
        </div>

        <div class="mb-3">
            <b> <label class="form-label">Nom</label></b>
        <input class="form-control" type="text" name="nom">
        </div>


        <div class="mb-3">
            <b> <label class="form-label">Prénom</label></b>
        <input class="form-control" type="text" name="prenom">
        </div>

        <div class="mb-3">

            <b>  <label class="form-label">Matricule</label></b>
        <input class="form-control" type="text" name="matricule">
        </div>

        <div class="mb-3">

            <b>  <label class="form-label">Cin</label></b>
        <input class="form-control" type="text" name="cin">
        </div>

        <div class="mb-3">
            <b> <label class="form-label">Téléphone</label></b>
        <input class="form-control" type="text" name="telephone">
        </div>


        <div class="mb-3">
            <b><label class="form-label">Dric</label></b>
        <select class="form-control" name="dric" id="dric" onchange="updateDistrictOptions()">
            <option value="" disabled selected hidden>Select District</option>
            <option value="dric centre" >DRIC CENTRE</option>
            <option value="dric sud">DRIC SUD</option>
            <option value="dric nord">DRIC NORD</option>
        </select>
        </div>

        <div class="mb-3">

            <b><label class="form-label">District</label></b>
        <select class="form-control"  name="district" id="district">
            <!-- District options will be populated dynamically -->
        </select>
        </div>
        <input class="btn btn-primary" type="submit" value="Ajouter" name="button">

    </form>

</center>


</div>
</body>
</html>

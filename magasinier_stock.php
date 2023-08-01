<?php
// Database credentials
$host = "localhost";
$user = "root";
$password = "";
$database = "gestion_dm";

// Connect to the database
$conn = mysqli_connect($host, $user, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// Function to delete a row by its id
function deleteRow($conn, $id) {
    $id = intval($id);
    $sql = "DELETE FROM magasinier_stock WHERE id = $id";
    $result = $conn->query($sql);
    if ($result === TRUE) {
        echo "";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Handle delete button click
if (isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];
    deleteRow($conn, $id);
}

// Handle form submission
if (isset($_POST['submit'])) {
    // Get logged-in username from the session variable
    $username = $_SESSION['username'];
    $n_nomenclature = $_POST['n_nomenclature'];
    $designation = $_POST['designation'];
    $prix_unitaire = $_POST['prix_unitaire'];
    $quantite = $_POST['quantite'];
    $valeur = isset($_POST['valeur']) ? $_POST['valeur'] : 0; // Get valeur directly from user input or set to 0 if not provided

    $sql = "INSERT INTO magasinier_stock (username, n_nomenclature, designation, prix_unitaire, quantite, valeur) 
            VALUES ('$username', '$n_nomenclature', '$designation', '$prix_unitaire', '$quantite', '$valeur')";

    if ($conn->query($sql) === TRUE) {
        echo "Materiel Ajouter en successé .";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <title>View and Manage Data</title>
    <style>
        .supprimer{
            background-color: red;
            border-color: #198754;
            display: inline-block;
            color: white;
            font-weight: 400;
            line-height: 1.5;
            text-align: center;
            text-decoration: none;
            vertical-align: middle;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
            border: 1px solid transparent;
            padding: .375rem .75rem;
            font-size: 1rem;
            border-radius: .25rem;
            transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        }

        .add{
            background-color: forestgreen;
            border-color: #198754;
            display: inline-block;
            color: white;
            font-weight: 400;
            line-height: 1.5;
            text-align: center;
            text-decoration: none;
            vertical-align: middle;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
            border: 1px solid transparent;
            padding: .375rem .75rem;
            font-size: 1rem;
            border-radius: .25rem;
            transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        }

    </style>
</head>
<body>
<center>
<h1 class="h1">Stock Magasine</h1>
</center>
<table class="table table-striped">

    <tr>
        <th>N Materiel</th>
        <th>Nomenclature</th>
        <th>Designation</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Total Value</th>
        <th>Action</th>
    </tr>
    <?php
    $username = $_SESSION['username'];

    $sql = "SELECT * FROM magasinier_stock WHERE username = '$username'";;
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row['id']."</td>";
            echo "<td>".$row['n_nomenclature']."</td>";
            echo "<td>".$row['designation']."</td>";
            echo "<td>".$row['prix_unitaire']."</td>";
            echo "<td>".$row['quantite']."</td>";
            echo "<td>".$row['valeur']."</td>";
            echo "<td><form method='post' action=''><button class='supprimer' type='submit'  name='delete_id' value='".$row['id']."'>Delete</button></form></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='8'>Stock est vide</td></tr>";
    }
    ?>
</table>
<h1 class="h1">Ajouter Materiel</h1>
<form method="post" action="">
    <input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>">
    <div class="mb-3">

    <label class="form-label">Nom en clature</label>
    <input class="form-control" type="text" name="n_nomenclature" required>


    </div>

    <div class="mb-3">
    <label class="form-label">Designation</label>
    <input class="form-control" type="text" name="designation" required>
    </div>

    <div class="mb-3">

    <label class="form-label">Prix Unitaire</label>
    <input class="form-control" type="text" name="prix_unitaire" required>

    </div>

    <div class="mb-3">

    <label class="form-label">Quantité</label>
    <input class="form-control" type="text" name="quantite" required><br>
    </div>

    <div class="mb-3">

    <label class="form-label"> Valeur</label>
    <input class="form-control" type="text" name="valeur" value="0" required><br>
    </div>

    <button class="add" type="submit" name="submit">Add Data</button>
</form>
</body>
</html>
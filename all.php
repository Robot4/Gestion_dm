<?php
require('navbar.php');

// Replace these variables with your actual database credentials
$host = 'localhost';
$username = 'root';
$password = "";
$database = 'gestion_dm';

// Create a database connection
$conn = new mysqli($host, $username, $password, $database);

// Function to fetch all data from the 'dm' table
function fetchAllData($conn) {
    $sql = "SELECT * FROM etat_dm";
    $result = $conn->query($sql);
    return $result;
}

// Function to delete a row from the 'dm' table by n_dm value
function deleteRow($conn, $n_dm) {
    $sql = "DELETE FROM etat_dm WHERE n_dm = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $n_dm);
    $stmt->execute();
    $stmt->close();
}

// Function to fetch filtered data from the 'dm' table based on search criteria
function searchByUserOrDistrict($conn, $search) {
    $sql = "SELECT * FROM etat_dm WHERE username LIKE ? OR district LIKE ?";
    $stmt = $conn->prepare($sql);
    $search = "%{$search}%";
    $stmt->bind_param("ss", $search, $search);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}

// Check if the form is submitted for deletion
if (isset($_POST['delete_dm']) && isset($_POST['n_dm'])) {
    $n_dm_to_delete = $_POST['n_dm'];
    deleteRow($conn, $n_dm_to_delete);
}

// Check if the search form is submitted
if (isset($_POST['search_dm']) && isset($_POST['search'])) {
    $search = $_POST['search'];
    $result = searchByUserOrDistrict($conn, $search);
} else {
    // If the search form is not submitted, fetch all data
    $result = fetchAllData($conn);
}
?>



    <!DOCTYPE html>
    <html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

        <style>

            .chercher{
                margin-top: 25px;
                background-color: #f0801b;
                border: 1px solid #f0801b;
                cursor: pointer;
                color: #fff;
                text-transform: uppercase;
            }

            .supprimer{
                background-color: red;
                border: 1px solid #f0801b;
                cursor: pointer;
                color: #fff;
                text-transform: uppercase;
            }

            .Btn_add {
                width: fit-content;
                margin-bottom: 81px;
                background-color: #f0801b;
                padding: 7px 29px;
                color: #fff;
                display: flex;
                align-items: center;
                text-align: 0;
                border-radius: 18px;
                text-decoration: 0;
            }
        </style>

    </head>
    <body>
    <br>
    <div class="containers">
        <div class="button-container">
            <a href="admin.php" class="Btn_add">
                <img class="icon" src="assets/images/left.svg"> retour
            </a>
        </div>

    <form method="post">
        <input type="text" name="search" id="search" placeholder="Chercher...">
        <button type="submit" name="search_dm" class="chercher">Chercher</button>
    </form>
    <br>
    <center>
        <h1>Stock par district</h1>
    </center>

    <table border="1" class="table table-hover">
        <tr id="items">
            <th>Nom</th>
            <th>District</th>
            <th>n_dm</th>
            <th>n_nomenclature</th>
            <th>Designation</th>
            <th>Prix Unitaire</th>
            <th>Q_demandé</th>
            <th>Projet</th>
            <th>Date_dm</th>
            <th>Operation</th>
            <th>Q_Maintenu</th>
            <th>Date Envoie</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['district']; ?></td>
                <td><?php echo $row['n_dm']; ?></td>
                <td><?php echo $row['n_nomenclature']; ?></td>
                <td><?php echo $row['designation']; ?></td>
                <td><?php echo $row['prix_unitaire']; ?></td>
                <td><?php echo $row['quantite']; ?></td>
                <td><?php echo $row['projet']; ?></td>
                <td><?php echo $row['date_saisie']; ?></td>
                <td><?php echo $row['operation']; ?></td>
                <td><?php echo $row['quantite_maintenu']; ?></td>
                <td><?php echo $row['date_envoie']; ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="n_dm" value="<?php echo $row['n_dm']; ?>">
                        <button type="submit" name="delete_dm"  class="supprimer">supprimer</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>





    </body>
    </html>

<?php
// Close the database connection
$conn->close();
?>
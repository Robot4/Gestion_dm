<!DOCTYPE html>
<html>
<head>
    <title>Material Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

</head>
<body>

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

// Function to fetch paginated materials from the database
function getPaginatedMaterials($conn, $start, $limit) {
    $query = "SELECT * FROM materiel LIMIT $start, $limit";
    $result = mysqli_query($conn, $query);

    $materials = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $materials[] = $row;
    }

    return $materials;
}

// Function to search for materials based on n_nomenclature or designation
function searchMaterials($conn, $search_term) {
    $search_term = mysqli_real_escape_string($conn, $search_term);

    if (empty($search_term)) {
        // Return the 10 first materials when the search term is empty
        $query = "SELECT * FROM materiel LIMIT 10";
    } else {
        // Perform the regular search query
        $query = "SELECT * FROM materiel WHERE n_nomenclature LIKE '%$search_term%' OR designation LIKE '%$search_term%'";
    }

    $result = mysqli_query($conn, $query);

    $materials = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $materials[] = $row;
    }

    return $materials;
}

// Function to add a new material to the database
function addMaterial($conn, $n_nomenclature, $designation, $prix_unitaire) {
    $n_nomenclature = mysqli_real_escape_string($conn, $n_nomenclature);
    $designation = mysqli_real_escape_string($conn, $designation);
    $prix_unitaire = mysqli_real_escape_string($conn, $prix_unitaire);

    $query = "INSERT INTO materiel (n_nomenclature, designation, prix_unitaire) VALUES ('$n_nomenclature', '$designation', '$prix_unitaire')";
    mysqli_query($conn, $query);
}

// Function to delete a material from the database
function deleteMaterial($conn, $n_nomenclature) {
    $n_nomenclature = mysqli_real_escape_string($conn, $n_nomenclature);

    $query = "DELETE FROM materiel WHERE n_nomenclature = '$n_nomenclature'";
    mysqli_query($conn, $query);
}

// Pagination variables
$limit = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
    $page = 1;
}
$start = ($page - 1) * $limit;

// Get paginated materials
$materials = getPaginatedMaterials($conn, $start, $limit);

// Handle search
if (isset($_POST['search'])) {
    $search_term = $_POST['search_term'];
    $materials = searchMaterials($conn, $search_term);
}

// Handle adding new material
if (isset($_POST['add_material'])) {
    $n_nomenclature = $_POST['n_nomenclature'];
    $designation = $_POST['designation'];
    $prix_unitaire = $_POST['prix_unitaire'];
    addMaterial($conn, $n_nomenclature, $designation, $prix_unitaire);

    // Redirect to avoid form resubmission on refresh
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle deleting material
if (isset($_POST['delete_material'])) {
    $n_nomenclature = $_POST['n_nomenclature'];
    deleteMaterial($conn, $n_nomenclature);

    // Redirect to avoid form resubmission on refresh
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<h2>Material List</h2>
<table border="1">
    <tr>
        <th>Nomenclature</th>
        <th>Designation</th>
        <th>Prix Unitaire</th>
        <th>Operation</th>
    </tr>
    <?php
    foreach ($materials as $material) {
        echo "<tr>";
        echo "<td>" . $material["n_nomenclature"] . "</td>";
        echo "<td>" . $material["designation"] . "</td>";
        echo "<td>" . $material["prix_unitaire"] . "</td>";
        echo '<td>';
        echo '<a href="javascript:void(0);" onclick="deleteMaterial(\'' . $material["n_nomenclature"] . '\')"><i class="fas fa-trash"></i> Delete</a>';
        echo '</td>';
        echo "</tr>";
    }
    ?>
</table>

<!-- Pagination links -->
<?php
$prev_page = $page - 1;
$next_page = $page + 1;
?>
<div>
    <?php if ($prev_page > 0): ?>
        <a href="?page=<?php echo $prev_page; ?>">Previous</a>
    <?php endif; ?>

    <?php if (count($materials) == $limit): ?>
        <a href="?page=<?php echo $next_page; ?>">Next</a>
    <?php endif; ?>
</div>

<h2>Add Material</h2>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    Nomenclature: <input type="text" name="n_nomenclature" required><br>
    Designation: <input type="text" name="designation" required><br>
    Prix Unitaire: <input type="text" name="prix_unitaire" required><br>
    <input type="submit" name="add_material" value="Add Material">
</form>



<h2>Search Material</h2>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    Search by Nomenclature or Designation: <input type="text" name="search_term" >
    <input type="submit" name="search" value="Search">
</form>

<!-- JavaScript function for delete confirmation -->
<script>
    function deleteMaterial(n_nomenclature) {
        if (confirm("Are you sure you want to delete this material?")) {
            // Submit the form to delete the material
            var form = document.createElement("form");
            form.setAttribute("method", "post");
            form.setAttribute("action", "<?php echo $_SERVER['PHP_SELF']; ?>");
            form.style.display = "hidden";

            var inputField = document.createElement("input");
            inputField.setAttribute("type", "hidden");
            inputField.setAttribute("name", "n_nomenclature");
            inputField.setAttribute("value", n_nomenclature);
            form.appendChild(inputField);

            var deleteField = document.createElement("input");
            deleteField.setAttribute("type", "hidden");
            deleteField.setAttribute("name", "delete_material");
            deleteField.setAttribute("value", "Delete Material");
            form.appendChild(deleteField);

            document.body.appendChild(form);
            form.submit();
        }
    }
</script>

</body>
</html>

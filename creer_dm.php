<!DOCTYPE html>
<html>
<head>
    <script src="assets/js/creer_dm.js"></script>

    <title>Materiel Search</title>
    <style>
        /* CSS styles here */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .delete-button {
            color: red;
            background: none;
            border: none;
            cursor: pointer;
        }

        .prix-total {
            font-weight: bold;
        }
    </style>
</head>
<body>
<!-- Order Table -->
<table id="order-table">
    <thead>
    <tr>
        <th>n_nomenclature</th>
        <th>Designation</th>
        <th>Prix Unitaire</th>
        <th>Quantite</th>
        <th>Project</th>
        <th>Operation</th>
    </tr>
    </thead>
    <tbody id="order-table-body">
    <!-- Order Rows will be dynamically added here -->
    </tbody>
    <tfoot>
    <tr>
        <th colspan="5">Prix Total:</th>
        <th id="prix-total" class="prix-total">0.00 </th>
        <th>
            <button class="envoyer-button" onclick="envoyerDemandes()">Envoyer la demande</button>
        </th>
    </tr>
    </tfoot>
</table>

<!-- Search Form -->
<table id="search-form-table">
    <tr>
        <td>
            <label for="n_nomenclature" class="search-form-label">n_nomenclature:</label>
            <input type="text" id="n_nomenclature" onkeyup="fetchSuggestions(this.value)" class="search-form-input">
            <ul id="suggestions" class="search-form-suggestions"></ul>
        </td>
        <td>
            <label for="designation">Designation:</label>
            <input type="text" id="designation" readonly>
        </td>
        <td>
            <label for="prix_unitaire">Prix Unitaire:</label>
            <input type="text" id="prix_unitaire" readonly>
        </td>
        <td>
            <label for="quantite">Quantite:</label>
            <input type="number" id="quantite">
        </td>
        <td>
            <label for="project">Project:</label>
            <select id="project">
                <option value="" disabled selected hidden>Select Project</option>
                <option value="projet">Projet</option>
                <option value="cp 2024">CP-2024</option>
            </select>
        </td>
        <td>
            <button id="add-order-button" class="add-order-button" onclick="addOrderForm()">Ajouter la demande</button>
        </td>
    </tr>

</table>

<script>

    updateEnvoyerButtonVisibility();
    calculatePrixTotal();
</script>
</body>
</html>
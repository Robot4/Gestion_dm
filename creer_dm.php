<!DOCTYPE html>
<html>
<head>
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
        <th id="prix-total" class="prix-total">0.00</th>
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
            </select>
        </td>
        <td>
            <button id="add-order-button" class="add-order-button" onclick="addOrderForm()">Add Order</button>
        </td>
    </tr>
</table>
<script>
    var orderFormCounter = 1;
    var prixTotal = 0;
    var ordersArray = []; // Array to store added orders



    function fetchSuggestions(keyword) {
        var suggestionsElement = document.getElementById('suggestions');
        suggestionsElement.innerHTML = '';

        if (keyword.length >= 2) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var suggestions = JSON.parse(this.responseText);
                    var limitedSuggestions = suggestions.slice(0, 6); // Limit the suggestions to 6 items
                    limitedSuggestions.forEach(function(suggestion) {
                        var li = document.createElement('li');
                        li.textContent = suggestion.n_nomenclature;
                        li.addEventListener('click', function() {
                            selectMateriel(suggestion);
                        });
                        suggestionsElement.appendChild(li);
                    });
                }
            };
            xhttp.open('GET', 'search.php?keyword=' + keyword, true);
            xhttp.send();
        }
    }

    function fetchOrderSuggestions(keyword, formId) {
        var orderSuggestionsElement = document.getElementById('order-suggestions-' + formId);
        orderSuggestionsElement.innerHTML = '';

        if (keyword.length >= 2) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var suggestions = JSON.parse(this.responseText);
                    var limitedSuggestions = suggestions.slice(0, 6); // Limit the suggestions to 6 items
                    limitedSuggestions.forEach(function(suggestion) {
                        var li = document.createElement('li');
                        li.textContent = suggestion.n_nomenclature;
                        li.addEventListener('click', function() {
                            selectOrderMateriel(suggestion, formId);
                        });
                        orderSuggestionsElement.appendChild(li);
                    });
                }
            };
            xhttp.open('GET', 'search.php?keyword=' + keyword, true);
            xhttp.send();
        }
    }

    function selectMateriel(suggestion) {
        document.getElementById('n_nomenclature').value = suggestion.n_nomenclature;
        document.getElementById('designation').value = suggestion.designation || '';
        document.getElementById('prix_unitaire').value = suggestion.prix_unitaire || '';
        document.getElementById('suggestions').innerHTML = '';

        document.getElementById('designation').readOnly = true;
        document.getElementById('prix_unitaire').readOnly = true;
    }


    function selectOrderMateriel(suggestion, formId) {
        document.getElementById('order-search-' + formId).value = suggestion.n_nomenclature;
        document.getElementById('order-designation-' + formId).value = suggestion.designation || '';
        document.getElementById('order-prix_unitaire-' + formId).value = suggestion.prix_unitaire || '';
        document.getElementById('order-suggestions-' + formId).innerHTML = '';

        document.getElementById('order-designation-' + formId).readOnly = true;
        document.getElementById('order-prix_unitaire-' + formId).readOnly = true;
    }


    function addOrderForm() {
        var nomenclature = document.getElementById('n_nomenclature').value;
        var designation = document.getElementById('designation').value;
        var prixUnitaire = document.getElementById('prix_unitaire').value;
        var quantite = document.getElementById('quantite').value;
        var project = document.getElementById('project').value;

        if (nomenclature && designation && prixUnitaire && quantite && project) {
            var newRow = document.createElement('tr');
            newRow.innerHTML = `
            <td>${nomenclature}</td>
            <td>${designation}</td>
            <td>${prixUnitaire}</td>
            <td>${quantite}</td>
            <td>${project}</td>
            <td><button class="delete-button" onclick="deleteOrderForm(this)">Supprimer</button></td>
        `;

            document.getElementById('order-table-body').appendChild(newRow);

            // Update the Prix Total
            var total = (parseFloat(prixUnitaire) * parseInt(quantite)) || 0;
            prixTotal += total;
            document.getElementById('prix-total').textContent = prixTotal.toFixed(2);
        }

        // Reset the form fields
        document.getElementById('n_nomenclature').value = '';
        document.getElementById('designation').value = '';
        document.getElementById('prix_unitaire').value = '';
        document.getElementById('quantite').value = '';
        document.getElementById('project').value = '';
    }


    function deleteOrderForm(button) {
        var row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);

        calculatePrixTotal();
    }

    function calculatePrixTotal() {
        var rows = document.querySelectorAll('#order-table-body tr');
        var total = 0;

        rows.forEach(function(row) {
            var prixUnitaire = parseFloat(row.querySelector('td:nth-child(3)').textContent);
            var quantite = parseInt(row.querySelector('td:nth-child(4)').textContent);

            if (!isNaN(prixUnitaire) && !isNaN(quantite)) {
                total += prixUnitaire * quantite;
            }
        });

        prixTotal = total;
        document.getElementById('prix-total').textContent = prixTotal.toFixed(2);
    }

    function envoyerDemandes() {
        // Create an array to store all the orders data
        var orders = [];

        // Get all the rows in the order table body
        var rows = document.querySelectorAll('#order-table-body tr');

        // Loop through each row and extract the data for each order
        rows.forEach(function (row) {
            var nomenclature = row.querySelector('td:nth-child(1)').textContent;
            var designation = row.querySelector('td:nth-child(2)').textContent;
            var prixUnitaire = row.querySelector('td:nth-child(3)').textContent;
            var quantite = row.querySelector('td:nth-child(4)').textContent;
            var project = row.querySelector('td:nth-child(5)').textContent;

            // Create an object to represent the order
            var order = {
                nomenclature: nomenclature,
                designation: designation,
                prixUnitaire: prixUnitaire,
                quantite: quantite,
                project: project
            };

            // Add the order object to the orders array
            orders.push(order);
        });

        // Now you have all the orders data in the "orders" array
        // You can send this array to the server using XMLHttpRequest or fetch API

        // Example using XMLHttpRequest:
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                // Handle the server's response here (if needed)
                console.log(this.responseText);
            }
        };

        // Replace 'send_orders.php' with the URL of your server-side script
        xhttp.open('POST', 'send_order.php', true);
        xhttp.setRequestHeader('Content-Type', 'application/json');
        xhttp.send(JSON.stringify({ orders: orders }));
    }


    // Call calculatePrixTotal initially to display the initial Prix Total value
    calculatePrixTotal();
</script>
</body>
</html>
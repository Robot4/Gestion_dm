var orderFormCounter = 1;
var prixTotal = 0;
var ordersArray = []; // Array to store added orders

function updateEnvoyerButtonVisibility() {
    var rows = document.querySelectorAll('#order-table-body tr');
    var envoyerButton = document.querySelector('.envoyer-button');

    if (rows.length > 0) {
        // If there are rows (orders), show the "Envoyer la demande" button
        envoyerButton.style.display = 'block';
    } else {
        // If no rows (orders), hide the "Envoyer la demande" button
        envoyerButton.style.display = 'none';
    }
}

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

    // Validate if any of the fields are empty
    if (!nomenclature || !designation || !prixUnitaire || !quantite || !project) {
        alert('il faut remplire tous les champ');
        return; // Exit the function if any field is empty
    }

    // Validate quantite: Ensure it's a positive integer (1 and above)
    if (isNaN(quantite) || quantite < 1) {
        alert('La quantite doit être 1 et plus');
        return; // Exit the function if the quantite is invalid
    }

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
        document.getElementById('prix-total').textContent = prixTotal.toFixed(2) + ' dhs';
    }


    // Reset the form fields
    document.getElementById('n_nomenclature').value = '';
    document.getElementById('designation').value = '';
    document.getElementById('prix_unitaire').value = '';
    document.getElementById('quantite').value = '';
    document.getElementById('project').value = '';
    updateEnvoyerButtonVisibility();

}


function deleteOrderForm(button) {
    var row = button.parentNode.parentNode;
    row.parentNode.removeChild(row);

    calculatePrixTotal();
    updateEnvoyerButtonVisibility();

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
    document.getElementById('prix-total').textContent = prixTotal.toFixed(2) + ' dhs';
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

            // Clear the orders from the table and reset Prix Total
            document.getElementById('order-table-body').innerHTML = '';
            prixTotal = 0;
            document.getElementById('prix-total').textContent = prixTotal.toFixed(2) + ' dhs';
            // Hide the "Envoyer la demande" button again
            var envoyerButton = document.querySelector('.envoyer-button');
            envoyerButton.style.display = 'none';
            // Display the success message by showing the paragraph
            var successMessage = document.getElementById('success-message');
            successMessage.style.display = 'block';
        }
    };

    // Replace 'send_orders.php' with the URL of your server-side script
    xhttp.open('POST', 'send_order.php', true);
    xhttp.setRequestHeader('Content-Type', 'application/json');
    xhttp.send(JSON.stringify({ orders: orders }));
}

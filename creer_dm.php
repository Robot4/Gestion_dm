<!DOCTYPE html>
<html>
<head>
    <script src="assets/js/creer_dm.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


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
            font-family: 'Helvetica', 'Arial', sans-serif;
            display: inline-block;
            font-size: 1em;
            padding: 1em 3em;
            margin-top: 10px;
            margin-bottom: 11px;
            -webkit-appearance: none;
            appearance: none;
            background-color: #dd1b07;
            border-radius: 53px;
            border: none;
            cursor: pointer;
            position: relative;
            /* transition: transform cubic-bezier(0, 0, 0, 0.79) 0.1s, box-shadow ease-in 0.25s; */
            box-shadow: 0 11px 7px rgb(30 26 28 / 50%);
        }

        .prix-total {
            font-weight: bold;
        }
        input 				{
            font-size:18px;
            padding:10px 10px 10px 5px;
            display:block;
            width:300px;
            border:none;
            border-bottom:1px solid #757575;
        }
        input:focus 		{ outline:none; }

        select{
            font-size:18px;
            padding:10px 10px 10px 5px;
            display:block;
            width:300px;
            border:none;
            border-bottom:1px solid #757575;

        }
        .bubbly-button {
            font-family: 'Helvetica', 'Arial', sans-serif;
            display: inline-block;
            font-size: 1em;
            padding: 1em 4em;
            margin-top: 68px;
            margin-bottom: 74px;
            -webkit-appearance: none;
            appearance: none;
            background-color: #f1811b;

            border-radius: 4px;
            border: none;
            cursor: pointer;
            position: relative;
            transition: transform cubic-bezier(0, 0, 0, 0.79) 0.1s, box-shadow ease-in 0.25s;
            box-shadow: 0 2px 25px rgb(30 26 28 / 50%);
        }
        li{
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #0b2037;
            padding-top: 15px;
            cursor: pointer;

        }

        .envoyer-button {
            font-family: 'Helvetica', 'Arial', sans-serif;
            display: inline-block;
            font-size: 1em;
            padding: 1em 3em;
            margin-top: 10px;
            margin-bottom: 11px;
            -webkit-appearance: none;
            appearance: none;
            background-color: #569b2b;
            border-radius: 53px;
            border: none;
            cursor: pointer;
            position: relative;
            /* transition: transform cubic-bezier(0, 0, 0, 0.79) 0.1s, box-shadow ease-in 0.25s; */
            box-shadow: 0 11px 7px rgb(30 26 28 / 50%);
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
            <button class="envoyer-button"  onclick="envoyerDemandes()">Envoyer la demande</button>
        </th>
    </tr>
    </tfoot>
</table>

<!-- Search Form -->
<table id="search-form-table">
    <tr>
        <td>

            <input type="text" placeholder="N nom en clature" id="n_nomenclature" onkeyup="fetchSuggestions(this.value)" class="search-form-input">
            <ul id="suggestions" class="search-form-suggestions"></ul>
        </td>
        <td>
            <input type="text" id="designation" placeholder="Designation" readonly>
        </td>
        <td>
            <input type="text" id="prix_unitaire" placeholder="Prix Unitaire" readonly>
        </td>
        <td>
            <input type="number" id="quantite" placeholder="Quantite">
        </td>
        <td>
            <select id="project">
                <option value="" disabled selected hidden>Select Project</option>
                <option value="projet">Projet</option>
                <option value="cp 2024">CP-2024</option>
            </select>
        </td>
        <td>
            <button id="add-order-button" class="bubbly-button" onclick="addOrderForm()">Ajouter la demande</button>
        </td>
    </tr>

</table>

<script>

    updateEnvoyerButtonVisibility();
    calculatePrixTotal();


</script>
</body>
</html>
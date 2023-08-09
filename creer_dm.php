<!DOCTYPE html>
<html>
<head>
    <script src="assets/js/creer_dm.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

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


        select{
            font-size:18px;
            padding:10px 10px 10px 5px;
            display:block;
            width:300px;
            border:none;
            border-bottom:1px solid #757575;

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
<table id="order-table" >
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
            <label>N nom en clature</label>
            <input type="text"  id="n_nomenclature" onkeyup="fetchSuggestions(this.value)" class="form-control">
            <ul id="suggestions" class="search-form-suggestions"></ul>

        </td>

        <td>
            <label>Designation</label>
            <input  class="form-control" type="text" id="designation"  readonly>
        </td>
        <td>
            <label>Prix Unitaire</label>
            <input class="form-control" type="text" id="prix_unitaire"  readonly>
        </td>
        <td>
            <label>Quantite</label>
            <input class="form-control" type="number" id="quantite" >
        </td>
        <td>
            <label  hidden >Quantite</label><br>

            <br>
            <select id="project" class="form-select form-select-lg mb-3" >
                <option value="" disabled selected hidden>Select Project</option>
                <option value="projet">Projet</option>
                <option value="cp 2024">CP-2024</option>
            </select>
        </td>
        <td>
            <button id="add-order-button" class="btn btn-success" onclick="addOrderForm()">Ajouter la demande</button>
        </td>
    </tr>

</table>

<script>

    updateEnvoyerButtonVisibility();
    calculatePrixTotal();


</script>
</body>
</html>
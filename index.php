<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Office reservations</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.4.1/minty/bootstrap.min.css">
        <link rel="stylesheet" href="./main.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script src='js/app.js'></script>
    </head>
    <body>
        <h1 class="mb-5 text-center">Welcome to resevation system</h1>
        <div id="actions" class="ml-5 text-center">
            <label for="reservations-date">Date: </label>
            <input id="reservations-date" type="date" value="<?php echo date('Y-m-d'); ?>"> 
            <button id="show-reservations" class="btn btn-primary m-3 main-menu-button" data-div="reservations">Reservations</button>
            <button id="show-places" class="btn btn-info m-3 main-menu-button" data-div="places">Places</button>
            <button id="show-equipment" class="btn btn-secondary m-3 main-menu-button" data-div="equipment">Equipment</button>
            <button id="show-persons" class="btn btn-warning m-3 main-menu-button" data-div="persons">Persons</button>
        </div>
        <h1 id="menu-title" class="mb-5 text-center">Reservations</h1>
        <div class="main-menu-item" id="reservations">
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th>Person</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Place</th>
                        <th>Equipment</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr id="new-reservation-data">
                        <td><select id="new-reservation-person" name="person_id" class="form-control" required></select></td>
                        <td><input type="time" name="start" class="form-control" required></td>
                        <td><input type="time" name="end" class="form-control" required></td>
                        <td><select id="new-reservation-place" name="place_id" class="form-control" required></select></td>
                        <td id="new-reservation-equipment"></td>
                        <td><button id="add-reservation" class="btn btn-primary">Add reservation</button></td>
                    </tr>
                </tbody>
                <tbody id="reservations-list">

                </tbody>
            </table>        
        </div>
        <div class="main-menu-item d-none" id="persons">
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th>First name</th>
                        <th>Last</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Description</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr id="new-person-data">
                        <td><input type="text" name="first_name" placeholder="First name" required></td>
                        <td><input type="text" name="last_name" placeholder="Last name" required></td>
                        <td><input type="tel" name="phone" placeholder="Phone"></td>
                        <td><input type="email" name="email" placeholder="Email"></td>
                        <td><input type="text" name="description" placeholder="Description"></td>
                        <td><button id="add-person" class="btn btn-warning">Add person</button></td>
                    </tr>
                </tbody>
                <tbody id="persons-list">

                </tbody>
            </table> 
        </div>
        <div class="main-menu-item d-none" id="places">
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th>Mark</th>
                        <th>Description</th>
                        <th>Equipment</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr id="new-place-data">
                        <td><input type="text" name="name" required></td>
                        <td><input type="text" name="description" required></td>
                        <td>Equipment can be<br>added in "Equipment" fold</td>
                        <td><button id="add-place" class="btn btn-info">Add place</button></td>
                    </tr>
                </tbody>
                <tbody id="places-list">

                </tbody>
            </table> 
        </div>
        <div class="main-menu-item d-none" id="equipment">
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Model</th>
                        <th>Mark</th>
                        <th>Purchase year</th>
                        <th>Value</th>
                        <th>Description</th>
                        <th>Place</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr id="new-equipment-data">
                        <td><input type="text" name="type" placeholder="Type" required></td>
                        <td><input type="text" name="model" placeholder="Model" required></td>
                        <td><input type="text" name="mark" placeholder="Mark" required></td>
                        <td><input type="number" name="purchase_year"  placeholder="Purchase year" required></td>
                        <td><input type="number" name="value" placeholder="Value" required></td>
                        <td><input type="text" name="description"  placeholder="Description"></td>
                        <td><select id="new-equipment-place" class="form-control" name="place_id"></select></td>
                        <td><button id="add-equipment" class="btn btn-secondary">Add equipment</button></td>
                    </tr>
                </tbody>
                <tbody id="equipment-list">

                </tbody>
            </table> 
        </div>
        <div class="main-menu-item d-none mb-5 form-group" id="change-equipment-place">
            <table class="w-100 text-center mt-5">
                <tbody>
                    <tr>
                        <td>
                            <label for="equipment-to-change-place">Equipment mark:</label>
                            <h3 id="equipment-to-change-place"></h3>
                        </td>
                        <td id="change-place-inputs">
                            <label for="places-to-change">Place:</label>
                            <select name="place_id" id="change_place_place_id" class="form-control" ></select>
                            <input id="change_place_equipment_id" type="hidden" name="equipment_id">
                        </td>
                        <td><button id="save-equipment-place" class="btn btn-secondary">Save</button></td>
                    </tr>
                </tbody>
            </table>
        </div> 

    </body>
</html>
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
<h1 class="mb-5 text-center">Witamy w systemie rezerwacji miejsc</h1>
<div id="actions" class="ml-5 text-center">
    <label for="reservations-date">Data: </label>
    <input id="reservations-date" type="date" value="<?php echo date('Y-m-d'); ?>"> 
    <button class="btn btn-primary m-3 main-menu-button" data-div="reservations">Pokaż rezerwacje</button>
    <button class="btn btn-info m-3 main-menu-button" data-div="places">Zarządzaj miejscami</button>
    <button class="btn btn-secondary m-3 main-menu-button" data-div="equipment">Zarządzaj wyposażeniem</button>
    <button class="btn btn-warning m-3 main-menu-button" data-div="users">Zarządzaj użytkownikami</button>
</div>
    <div class="main-menu-item" id="reservations">
        <table class="table table-striped text-center">
            <thead>
                <tr>
                    <th>Rezerwujący/a</th>
                    <th>Początek</th>
                    <th>Koniec</th>
                    <th>Miejsce</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><select id="new-reservation-user" class="form-control"></select></td>
                    <td><input id="new-reservation-start" type="time" class="form-control" required></td>
                    <td><input id="new-reservation-end" type="time" class="form-control" required></td>
                    <td><select id="new-reservation-place" class="form-control"></select></td>
                    <td><button id="add-reservation" class="btn btn-primary">Dodaj rezerwację</button></td>
                </tr>
            </tbody>
            <tbody id="reservations-list">

            </tbody>
        </table>        
    </div>
    <div class="main-menu-item d-none" id="users">
        <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th>Imię</th>
                        <th>Nazwisko</th>
                        <th>Telefon</th>
                        <th>Email</th>
                        <th>Opis</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                        <td><input type="text" name="first_name"></td>
                        <td><input type="text" name="last_name"></td>
                        <td><input type="tel" name="phone"></td>
                        <td><input type="email" name="email"></td>
                        <td><input type="text" name="description"></td>
                        <td><button id="add-user" class="btn btn-warning">Dodaj użytkownika</button></td>
                    </tr>
                </tbody>
                <tbody id="users-list">

                </tbody>
            </table> 
    </div>
    <div class="main-menu-item d-none" id="places">
        <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th>Oznaczenie</th>
                        <th>Opis</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" name="name"></td>
                        <td><input type="text" name="description"></td>
                        <td><button id="add-place" class="btn btn-info">Dodaj miejsce</button></td>
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
                        <th>Typ</th>
                        <th>Model</th>
                        <th>Oznaczenie</th>
                        <th>Rok zakupu</th>
                        <th>Wartość</th>
                        <th>Opis</th>
                        <th>Miejsce użytkowania</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr id="new-equipment-inputs">
                        <td><input type="text" name="type"></td>
                        <td><input type="text" name="model"></td>
                        <td><input type="text" name="mark"></td>
                        <td><input type="number" name="purchase_year"></td>
                        <td><input type="number" name="value"></td>
                        <td><input type="text" name="description"></td>
                        <td><select id="new-reservation-place" class="form-control" name="place_id"></select></td>
                        <td><button id="add-equipmet" class="btn btn-secondary">Dodaj wyposażenie</button></td>
                    </tr>
                </tbody>
                <tbody id="equipment-list">

                </tbody>
            </table> 
    </div>
    
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Office reservations</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.4.1/minty/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src='js/app.js'></script>
</head>
<body>
<h1 class="mb-5">Witamy w syetmie rezerwacji miejsc</h1>
<div id="actions" class="ml-5">
    <label for="reservations-date">Data: </label>
    <input id="reservations-date" type="date" value="<?php echo date('Y-m-d'); ?>"> 
    <button id="add-reservation" class="btn btn-primary m-3">Dodaj rezerwację</button>
    <button id="add-reservation" class="btn btn-info m-3">Zarządzaj miejscami</button>
    <button id="add-reservation" class="btn btn-secondary m-3">Zarządzaj wyposażeniem</button>
    <button id="add-reservation" class="btn btn-warning m-3">Zarządzaj użytkownikami</button>
</div>
    <div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Rezerwujący/a</th>
                    <th>Początek</th>
                    <th>Koniec</th>
                    <th>Miejsce</th>
                </tr>
            </thead>
            <tbody id="reservations-list">

            </tbody>
        </table>        
    </div>
    
</body>
</html>
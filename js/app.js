var apiUrl = "http://localhost/reservations/api/api.php";

var locked = false;

function addReservation(){
    locked = true;
    let date = $('#reservations-date').val();
    let reservation = {
        'person_id': $('#new-reservation-user').val(), 
        'start': date +' '+ $('#new-reservation-start').val(),
        'end': date +' '+ $('#new-reservation-end').val(),
        'place_id': $('#new-reservation-place').val(),
    };
    // console.log({'action': 'addReservation', 'reservation': reservation});
    let resp = getApi({'action': 'addReservation', 'reservation': reservation});
    resp
    .then(function(){
        console.log('succ');
        locked = false;
        showReservations();
    })
    .fail(function(){
        console.log('fail');
        locked = false;
    });
}

function getApi(data){
    return $.ajax({
        url: apiUrl,
        method: "POST",
        data: data
    });
}

function makeButton(className, id, name){
    return `<button class="${className}" data-id="${id}">${name}</button>`;
}

function makeOption(optionName, id){
    return `<option value='${id}'>${optionName}</option>`;
}

function makeTd(content, className){
    let classPart = '';
    if(className!== ''){
        classPart= ' class = "'+ className +'" ';
    }
    return `<td ${classPart}>${content}</td>`;
}

function makeTr(content, className){
    let classPart = '';
    if(className!== ''){
        classPart= ' class = "'+ className +'" ';
    }
    return '<tr'+ classPart +'>'+content+'</tr>';
}

function showEquipment(){
    console.log('equi');
    locked = true;
    let response = getApi({'action':'getEquipment'});
    response
    .then(function(encoded){
        let equipmentList = JSON.parse(encoded);
        console.log(equipmentList);
        if(equipmentList.length>0){
            let equipmentHtml ='';
            equipmentList.forEach(function(equipment){
                console.log(equipment);
                equipmentHtml += makeTr(
                    makeTd(equipment['type'])
                    + makeTd(equipment['model'])
                    + makeTd(equipment['mark'])
                    + makeTd(equipment['purchase_year'])
                    + makeTd(equipment['value'])
                    + makeTd(equipment['description'])
                    + makeTd(equipment['name'])
                    + makeTd(makeButton('btn btn-danger remove-place m-1', equipment['equipment_id'], 'Usuń')
                         + makeButton('btn btn-success update-place m-1', equipment['equipment_id'], 'Zmień miejsce'))
                    );
            });
            $('#equipment-list').html(equipmentHtml);
        }
    });
    locked = false;
}

function showPersons() {
    locked = true;
    let response = getApi({'action':'getPersons'});
    response
    .then(function(encoded){
        let persons = JSON.parse(encoded);
        console.log(persons);
        if(persons.length>0){
            let usersHtml ='';
            persons.forEach(function(person){
                console.log(person);
                usersHtml += makeTr(
                    makeTd(person['first_name'])
                    + makeTd(person['last_name'])
                    + makeTd(person['phone'])
                    + makeTd(person['email'])
                    + makeTd(person['description'])
                    + makeTd(makeButton('btn btn-danger remove-place', person['person_id'], 'Usuń osobę'))
                    );
            });
            $('#persons-list').html(usersHtml);
        }
    });
    locked = false;
}

function showPlaces(){
    let response = getApi({'action':'getPlaces'});
    response
    .then(function(encoded){
        let places = JSON.parse(encoded);
        if(places.length>0){
            let placesHtml ='';
            places.forEach(function(place){
                placesHtml += makeTr(
                    makeTd(place['name'])
                    + makeTd(place['description'])
                    + makeTd(place['equipment'])
                    + makeTd(makeButton('btn btn-danger remove-place', place['place_id'], 'Usuń miejsce'))
                    );
            });
            $('#places-list').html(placesHtml);
        }
    });
}

function showReservations(){
    locked = true;
    let response = getApi({'action':'getReservations','date':$('#reservations-date').val()});
    response.then(function(encoded){
        console.log(encoded);
        let data = JSON.parse(encoded);
        let reservationsList = data['reservations'];
        let usersList = data['users'];
        let placesList = data['places'];

        let reservationsHtml='';
        if(reservationsList.length>0){
            reservationsList.forEach(function(reservations) {
                var tr = '';
                for(key in reservations){
                    if(key !== 'reservation_id'){
                        tr += makeTd(reservations[key],'');
                    }else{
                        tr += makeTd(makeButton("remove-reservation btn btn-danger", reservations[key], "Usuń"));
                    }
                }
                reservationsHtml += makeTr(tr,'');
            });
        }
        $('#reservations-list').html(reservationsHtml);
        let usersOptions = '';
        usersList.forEach(function(user){
            usersOptions += makeOption(user['fullName'], user['person_id']);
        });
        $('#new-reservation-user').html(usersOptions);
        let placesOptions = '';
        placesList.forEach(function(place){
            placesOptions += makeOption(place['name'], place['place_id']);
        });
        $('#new-reservation-place').html(placesOptions);
        locked = false;
    });
}

$(function(){
    showReservations();
    $('#add-reservation').click(function(){
        if(!locked){
            addReservation();
        }
    });
    $('#show-reservations').click(function(){
        if(!locked){
            showReservations();
        }
    });
    $('.main-menu-button').click(function(){
        $('.main-menu-item').addClass('d-none');
        let divName = $(this).data('div');
        $('#'+divName).removeClass('d-none');
    });
    
    $('#show-places').click(function(){
        showPlaces();
    });

    $('#show-persons').click(function(){
        if(!locked){
            showPersons();
        }
    });

    $('#show-equipment').click(function(){
        if(!locked){
            showEquipment();
        }
    });

})
var apiUrl = "http://localhost/reservations/api/api.php";

var locked = false;

function getApi(data){
    return $.ajax({
        url: apiUrl,
        method: "POST",
        data: data
    });
}

function makeTr(content, className){
    let classPart = '';
    if(className!== ''){
        classPart= ' class = "'+ className +'" ';
    }
    return '<tr'+ classPart +'>'+content+'</tr>';
}

function makeTd(content, className){
    let classPart = '';
    if(className!== ''){
        classPart= ' class = "'+ className +'" ';
    }
    return `<td ${classPart}>${content}</td>`;
}

function makeOption(optionName, id){
    return `<option value='${id}'>${optionName}</option>`;
}

function makeButton(className, id, name){
    return `<button class="${className}" data-id="${id}">${name}</button>`;
}

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

function showReservations(){
    locked = true;
    $response = getApi({'action':'getReservations','date':$('#reservations-date').val()});
    $response.then(function(encoded){
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
        console.log(divName);
        $('#'+divName).removeClass('d-none');
    });
})
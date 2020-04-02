var apiUrl = "http://localhost/reservations/api/api.php";

var locked = false;

function addReservation() {
    locked = true;
    let date = $('#reservations-date').val();
    let reservation = getInputsData('#new-reservation-data');
    if (reservation['error'] !== 1) {
        delete reservation['error'];
        reservation['start'] = date + ' ' + reservation['start'];
        reservation['end'] = date + ' ' + reservation['end'];
        let resp = getApi({
            'action': 'addReservation',
            'reservation': reservation
        });
        resp
            .then(function () {
                clearInputs('#new-reservation-data');
                showReservations();
            })
            .fail(function () {

            });
    }
    locked = false;
}

function addPerson() {
    let person = getInputsData('#new-person-data');
    if (person['error'] !== 1) {
        let response = getApi({
            'action': 'addPerson',
            'person': person
        });
        response.then(function () {
            locked = false;
            $('#show-persons').click().trigger();
            clearInputs('#new-person-data');
        });
    }
    locked = false;
}

function addPlace() {
    let place = getInputsData('#new-place-data');
    if (place['error'] !== 1) {
        delete place['error'];
        let response = getApi({
            'action': 'addPlace',
            'place': place
        });
        response.then(function () {
            clearInputs('#new-place-data');
            $('#show-places').click();

        }).fail(function () {
            alert('Błąd zapisu');
        });
    }
    locked = false;
}

function addEquipment() {
    let equipment = getInputsData('#new-equipment-data');
    if (equipment['error'] !== 1) {
        delete equipment['error'];
        let response = getApi({
            'action': 'addEquipment',
            'equipment': equipment
        });
        response.then(function () {
            clearInputs('#new-equipment-data');
            $('#show-equipment').click();
        });
    }
    locked = false;
}

function changeEquipmentPlace(id) {
    $('#equipment').addClass('d-none');
    $('#change-equipment-place').removeClass('d-none');
    let response = getApi({
        'action': 'getEquipmentPlaces',
        'equipmentId': id
    });
    response
        .then(function (encoded) {
            let response = JSON.parse(encoded);
            let places = response['places'];
            let equipment = response['equipment'];
            $('#equipment-to-change-place').text(equipment[0]['mark']);
            let options = '<option value="">--</option>';
            places.forEach(function (place) {
                options += makeOption(place['name'], place['place_id']);
            })
            $('#change_place_equipment_id').val(equipment[0]['equipment_id']);
            $('#change_place_place_id').html(options);
            $('#change_place_place_id option[value=' + equipment[0]['place_id'] + ']').prop('selected', 'selected')
        });
}

function clearInputs(elementName) {
    $(elementName + ' input').each(function (input) {
        $(this).val('');
    });
    $(elementName + ' option[value=""]').each(function (option) {
        $(this).prop('selected', true);
    });
}

function getApi(data) {
    return $.ajax({
        url: apiUrl,
        method: "POST",
        data: data
    });
}

function getInputsData(formName) {
    $('.missing-input').remove();
    let output = {};
    let value;
    output['error'] = 0;
    $(formName + ' input').each(
        function () {
            value = $(this).val();
            if ($(this).prop('required') && value === '') {
                $(this).after('<div class="missing-input">Proszę podać wartość</div>');
                output['error'] = 1;
            }
            output[$(this).attr('name')] = value;
        }
    );
    $(formName + ' select').each(
        function () {
            value = $(this).val();
            if (value === '') {
                $(this).after('<div class="missing-input">Proszę podać wartość</div>');
                output['error'] = 1;
            }
            output[$(this).attr('name')] = value;
        }
    );
    return output;
}

function makeButton(className, id, name) {
    return `<button class="${className}" data-id="${id}">${name}</button>`;
}

function makeOption(optionName, value) {
    return `<option value='${value}'>${optionName}</option>`;
}

function makeTd(content, className) {
    let classPart = '';
    if (className !== '') {
        classPart = ' class = "' + className + '" ';
    }
    return `<td ${classPart}>${content}</td>`;
}

function makeTr(content, className) {
    let classPart = '';
    if (className !== '') {
        classPart = ' class = "' + className + '" ';
    }
    return '<tr' + classPart + '>' + content + '</tr>';
}

function saveEquipmentPlace() {
    let new_place = getInputsData('#change-place-inputs');
    if (new_place['error'] !== 1) {
        delete new_place['error'];
        let response = getApi({
            'action': 'saveEquipmentNewPlace',
            'new_place': new_place
        });
        response
            .then(function () {
                locked = false;
                $('#show-equipment').click();
            });
    }
}

function showEquipment() {
    $('#menu-title').text('Lista wyposażenia');
    locked = true;
    let response = getApi({
        'action': 'getEquipment'
    });
    response
        .then(function (encoded) {
            let data = JSON.parse(encoded);
            if (data['equipment'].length > 0) {
                let equipmentHtml = '';
                data['equipment'].forEach(function (equipment) {
                    equipmentHtml += makeTr(
                        makeTd(equipment['type']) +
                        makeTd(equipment['model']) +
                        makeTd(equipment['mark']) +
                        makeTd(equipment['purchase_year']) +
                        makeTd(equipment['value']) +
                        makeTd(equipment['description']) +
                        makeTd(equipment['name']) +
                        makeTd(makeButton('btn btn-danger remove-place m-1', equipment['equipment_id'], 'Usuń') +
                            makeButton('btn btn-success update-place m-1 change-equipment-place', equipment['equipment_id'], 'Zmień miejsce'))
                    );
                });
                $('#equipment-list').html(equipmentHtml);
            }
            let placesOptions = '<option value="">--</option>';
            data['places'].forEach(function (place) {
                placesOptions += makeOption(place['name'], place['place_id']);
            });
            $('#new-equipment-place').html(placesOptions);
        });
    locked = false;
}

function showPersons() {
    $('#menu-title').text('Lista osób');
    locked = true;
    let response = getApi({
        'action': 'getPersons'
    });
    response
        .then(function (encoded) {
            let persons = JSON.parse(encoded);
            if (persons.length > 0) {
                let personsHtml = '';
                persons.forEach(function (person) {
                    personsHtml += makeTr(
                        makeTd(person['first_name']) +
                        makeTd(person['last_name']) +
                        makeTd(person['phone']) +
                        makeTd(person['email']) +
                        makeTd(person['description']) +
                        makeTd(makeButton('btn btn-danger remove-place', person['person_id'], 'Usuń osobę'))
                    );
                });
                $('#persons-list').html(personsHtml);
            }
        });
    locked = false;
}

function showPlaces() {
    $('#menu-title').text('Lista miejsc pracy');
    let response = getApi({
        'action': 'getPlaces'
    });
    response
        .then(function (encoded) {
            let places = JSON.parse(encoded);
            if (places.length > 0) {
                let placesHtml = '';
                places.forEach(function (place) {
                    placesHtml += makeTr(
                        makeTd(place['name']) +
                        makeTd(place['description']) +
                        makeTd(place['equipment']) +
                        makeTd(makeButton('btn btn-danger remove-place', place['place_id'], 'Usuń miejsce'))
                    );
                });
                $('#places-list').html(placesHtml);
            }
        });
}

function showReservations() {
    $('#menu-title').text('Lista rezerwacji');
    locked = true;
    let response = getApi({
        'action': 'getReservations',
        'date': $('#reservations-date').val()
    });
    response.then(function (encoded) {
        let data = JSON.parse(encoded);
        let reservationsList = data['reservations'];
        let personsList = data['persons'];
        let placesList = data['places'];

        let reservationsHtml = '';
        if (reservationsList.length > 0) {
            reservationsList.forEach(function (reservations) {
                var tr = '';
                for (key in reservations) {
                    if (key !== 'reservation_id') {
                        tr += makeTd(reservations[key], '');
                    } else {
                        tr += makeTd(makeButton("remove-reservation btn btn-danger", reservations[key], "Usuń"));
                    }
                }
                reservationsHtml += makeTr(tr, '');
            });
        }
        $('#reservations-list').html(reservationsHtml);
        let personsOptions = '<option value="">--</option>';
        personsList.forEach(function (person) {
            personsOptions += makeOption(person['fullName'], person['person_id']);
        });
        $('#new-reservation-person').html(personsOptions);
        let placesOptions = '<option value="">--</option>';
        placesList.forEach(function (place) {
            placesOptions += makeOption(place['name'], place['place_id']);
        });
        $('#new-reservation-place').html(placesOptions);
        locked = false;
    });
}

$(function () {
    showReservations();
    $('#add-reservation').click(function () {
        if (!locked) {
            addReservation();
        }
    });
    $('#show-reservations').click(function () {
        if (!locked) {
            showReservations();
        }
    });
    $('.main-menu-button').click(function () {
        $('.main-menu-item').addClass('d-none');
        let divName = $(this).data('div');
        $('#' + divName).removeClass('d-none');
    });

    $('#show-places').click(function () {
        showPlaces();
    });

    $('#show-persons').click(function () {
        if (!locked) {
            showPersons();
        }
    });

    $('#show-equipment').click(function () {
        if (!locked) {
            showEquipment();
        }
    });

    $(document).on('click', '.change-equipment-place', function () {
        if (!locked) {
            changeEquipmentPlace($(this).data('id'));
        }
    })
    $('#add-person').click(function () {
        if (!locked) {
            addPerson();
        }
    });

    $('#add-place').click(function () {
        if (!locked) {
            addPlace();
        }
    });

    $('#add-equipment').click(function () {
        if (!locked) {
            addEquipment();
        }
    });

    $('#save-equipment-place').click(function () {
        saveEquipmentPlace();
    });

})
var apiUrl = "http://localhost/reservations/api/api.php";

function getApi( data){
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
    return '<td'+ classPart +'>'+content+'</td>';
}

$(function(){
    $response = getApi({'action':'getReservations','date':$('#reservations-date').val()});
    $response.then(function(encoded){
        let data = JSON.parse(encoded);
        let html='';
        data.forEach(function(rawData) {
            var tr = '';
            for(key in rawData){
                tr +=makeTd(rawData[key],'');
            }
            html += makeTr(tr,'');
        });
        $('#reservations-list').html(html);
    });
})
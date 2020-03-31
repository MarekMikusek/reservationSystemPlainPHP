function getApi(data){

    console.log('getApi');
    $.ajax({
        url: "./api/api.php",
        method: "POST",
        data: data
        success: function(data){
            console.log(data);
        }  
    });
}

$(function(){
    getApi('hello');
    console.log('ready');
})
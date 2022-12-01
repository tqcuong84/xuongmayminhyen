function selectCity(city){
    $.ajax({
        url: get_districts_url,
        type: "GET",
        data: {
            city
        },
        timeout: 10000,
        beforeSend: function() {
        },
        success: function(response) {
            if(response.districts !== undefined && response.districts.length > 0){

            }
        },
        error: function(t) {
        }
    });
}
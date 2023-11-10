
function userbanning(userid, route){
    var time = $("#ban").val();

    $.ajax({
        url: route,
        method: "GET",
        data: {
            userid: userid,
            banTime: time,
        },
        dataType: 'json',

        success: function(response){
            alert('Usuário suspenso com sucesso');
        },

        error: function(response){
            alert('não deu');
        },
    });
}
function deleteconversation(otherid, route, event, element){

    event.stopPropagation();
    var target = $(element);
    var userdiv = target.parent().parent().parent();
    var div = $('#showmessages');

    $.ajax({
        url: route,
        type: "GET",
        data: {
            otheruserid: otherid
        },
        dataType: "json",

        success: function(){
            userdiv.remove();
            div.empty();
            
            div.append('<img class="h-full w-full" src="img/placeholder.svg"></img>');
            
        },

        error: function(){
            alert('Ocorreu um erro, verifique sua conexão.');
        },

    });
}

function sendmessage(event, route)
{
    event.preventDefault();
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    
    var ids = $('#ids');
    
    
    var friendid = ids.data('friend-id');
    var message = $('#message').val();

    var div = $('#showmessages');

    $.ajax({
        url: route,
        method: "POST",
        data: {
            _token: csrfToken,
            message: message,
            receiver: friendid,
        },
        dataType: 'json',

        success: function(response){
            var userimage = response.userimage;
            html = 
                '<div class="flex items-end justify-end p-3 m-2">' +
                '<p class="p-2 bg-green-200 rounded-md border border-black">' + message + '</p>' +
                '<img class="h-10 w-10 rounded-md ml-1" src="'+userimage+'">' +
                '</div>';
            div.append(html)
            
            div.scrollTop(div.prop("scrollHeight"));
            
            $('#message').val('');
        },
        error: function(response){
            alert('deu mal');
        }
    })

}
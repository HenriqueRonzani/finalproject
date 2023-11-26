
function sendmessage(event, route)
{
    event.preventDefault();
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    
    var ids = $('#ids');
    
    var things = $('#things')
    
    var deleteroute = "'"+ things.data('route-delete') +"'";
    
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
            
            var createdconversation = response.createdconversation;

            var date = new Date().toLocaleString('pt-BR', {day: '2-digit', month: '2-digit'});
            var hour = new Date().toLocaleString('pt-BR', {hour: '2-digit', minute: '2-digit'})
            formattedDate = hour + ', ' + date;

            var userimage = response.userimage;

            html = 
                '<div class="showmessages  p-3 m-2">'+
                    '<div class="flex items-end justify-end">' +
                        '<p style="max-width: 60%; word-wrap: break-word;" class="p-2 text-lg bg-blue-200 rounded-md">' + message + '</p>' +
                        '<img class="h-10 w-10 rounded-md ml-1 my-auto" src="'+ userimage +'">' +
                    '</div>'+
                    '<div class="flex items-end justify-end">'+
                        '<p class="text-sm text-gray-500 ">' + formattedDate + '</p>' +
                    '</div>'+
                '</div>';
            div.append(html)
            
            div.scrollTop(div.prop("scrollHeight"));
            
            $('#message').val('');


            if (createdconversation) {

                var receiver = response.receiveruser;
                var showusers = $('#showusers');
                
                var otheruserimage = receiver.pfp ? 'storage/profilepicture/' + receiver.id + '.' + receiver.pfp : 'img/no-image.svg';
                
                $('.user').css('background-color','rgb(249, 250, 251)');

                
                var html = 
                '<div data-user-id="'+receiver.id+'" class="group p-4 mr-auto flex flex-1 space-x-2 border-b border-black bg-gray-300 hover:bg-gray-50 user" onclick="message(this, '+msgroute+')">'+
                    '<img class="my-auto h-10 w-10 rounded-md" src=" '+otheruserimage+' ">'+
                        '<div class="flex-1">'+
                            '<div class="flex justify-between items-center">'+
                                '<div id="content">'+
                                    '<span class="text-black">'+receiver.name+'</span>'+
                                '</div>'+
                                '<button class="hidden group-hover:inline-block transition" onclick="deleteconversation('+ receiver.id +','+ deleteroute +', event, this)">' +
                                    '<svg class="h-4 w-4 text-gray-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">'+
                                        '<path d="M32 32H480c17.7 0 32 14.3 32 32V96c0 17.7-14.3 32-32 32H32C14.3 128 0 113.7 0 96V64C0 46.3 14.3 32 32 32zm0 128H480V416c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V160zm128 80c0 8.8 7.2 16 16 16H336c8.8 0 16-7.2 16-16s-7.2-16-16-16H176c-8.8 0-16 7.2-16 16z"/>'+
                                    '</svg>'+
                                '</button>'+
                            '</div>'+
                        '</div>'+
                '</div>';
                showusers.prepend(html);

                if ($('#lastConversation').length){
                    $('#addConversation').remove();

                    var sidebar = $('#showusers');
                    sidebar.css('height','calc(100vh - 4.1rem)');
                }

                // showusers.css('background-color', 'rgb(209, 213 219)')
            }

        },
        error: function(response){
            alert('Ocorreu um erro, verifique sua conexão');
        }
    })

}
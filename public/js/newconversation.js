
function newconversation(route){
    var div = $('#showmessages');
    msgroute = "'"+ $('#things').data('route-start') +"'";
    $.ajax({
        url: route,
        method: "GET",
        dataType: 'json',

        success: function(response){

            var users = response.users;
            
            div.empty();

            if(users.length === 1){
                var html =
                '<div hidden id="lastConversation"></div>';
                $('#showusers').prepend(html);
            }
        
            var form = $('#sendmessage');

            if(form.css('display') === 'flex'){
                form.css('display','none');
            }

            var panel = $('#panel');
            if(panel.css('display') === 'flex'){
                panel.css('display','none');
            }

            $.each(users, function(index, user) {

                var userimage = user.pfp ? 'storage/profilepicture/' + user.id + '.' + user.pfp : 'img/no-image.svg';

                html = 
                '<div data-user-id="'+user.id+'" class="p-4 mr-auto flex flex-1 space-x-2 border-b border-black hover:bg-gray-50 user" onclick="message(this, '+msgroute+')">'+
                    '<img class="my-auto h-10 w-10 rounded-md" src=" '+userimage+' ">'+
                        '<div class="flex-1">'+
                            '<div class="flex justify-between items-center">'+
                                '<div id="content">'+
                                    '<span class="text-black">'+user.name+'</span>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                '</div>';
                div.append(html);
            });
        },

        error: function(response) {
            alert('Ocorreu um erro, verifique sua conexão.')
        }
    });
}
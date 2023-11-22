$(function() {
    var urlParam = new URLSearchParams(window.location.search);
    userid = urlParam.get('user');

    if (userid !== null)[
        showchat(userid)
    ]
})

function showchat(userid){

    var div = $('#showmessages');

    $.ajax({
        url: 'directmessage/show',
        method: "GET",
        data: {
            selecteduser: userid
        },
        dataType: 'json',
        
        success: function(response) {

            var messages = response.messages;
            var user = response.user;
            var otheruser = response.otheruser;


            var userimage = user.pfp ? 'storage/profilepicture/' + user.id + '.' + user.pfp : 'img/no-image.svg';
            var otheruserimage = otheruser.pfp ? 'storage/profilepicture/' + otheruser.id + '.' + otheruser.pfp : 'img/no-image.svg';


            div.empty();

            div.append('<div id="ids" data-friend-id="'+ otheruser.id +'" hidden></div>');
            
            $.each(messages, function(index, message) {

                var html;

                var responsedate = new Date(message.created_at);

                var date = responsedate.toLocaleString('pt-BR', {day: '2-digit', month: '2-digit'});
                
                var hour = responsedate.toLocaleString('pt-BR', {hour: '2-digit', minute: '2-digit'})
                
                formattedDate = hour + ', ' + date;
                
                
                if (message.sender_id == user.id) {
                    html = 
                        '<div class="showmessages  p-3 m-2">'+
                            '<div class="flex items-end justify-end">' +
                                '<p style="max-width: 60%; word-wrap: break-word;" class="p-2 text-lg bg-blue-200 rounded-md">' + message.message + '</p>' +
                                '<img class="h-10 w-10 rounded-md ml-1 my-auto" src=" '+ userimage +'">' +
                            '</div>'+
                            '<div class="flex items-end justify-end">'+
                                '<p class="text-sm text-gray-500 ">' + formattedDate + '</p>' +
                            '</div>'+
                        '</div>';
                } else {
                    html = 
                        '<div class="showmessages p-3 m-2">'+
                            '<div class="flex items-end justify-start">' +                        
                                '<img class="h-10 w-10 rounded-md mr-1 my-auto" src=" '+ otheruserimage +'">' +
                                '<p style="max-width: 60%; word-wrap: break-word;" class="p-2 text-lg bg-white rounded-md">' + message.message + '</p>' +
                            '</div>'+
                            '<div class="flex items-end justify-start">'+
                                '<p class="text-sm text-gray-500 ml-10">' + formattedDate + '</p>' +
                            '</div>'+
                        '</div>';
                }
                div.append(html);
            });

            var form = $('#sendmessage');

            if(form.is(':hidden')){
                form.css('display','flex');
            }
                
            $('#message').val('');

            div.scrollTop(div.prop("scrollHeight"));

            $('.user').css('background-color','rgb(249, 250, 251)');

            $('#panel-user-image').attr('src',otheruserimage);
            $('#panel-user-name').text(otheruser.name);

            var panel = $('#panel');
            if(panel.is(':hidden')){
                panel.css('display','flex');
            }

            $('#panel-redirect').attr('href', '/user/'+otheruser.id);
        },

        error: function(response){
            alert("deu merdassss");
        }
    });
}
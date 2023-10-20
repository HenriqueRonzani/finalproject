
function message(element, route){
    var target = $(element);
    var selecteduser =  target.data("user-id");
    var div = $('#showmessages');

    $.ajax({
        url: route,
        method: "GET",
        data: {
            selecteduser: selecteduser
        },
        dataType: 'json',
        
        success: function(response) {

            var messages = response.messages;
            var user = response.user;
            var userimage = response.userimage;
            var otheruserimage = response.otheruserimage;
            var otheruser = response.otheruser;

            div.empty();

            div.append('<div id="ids" data-friend-id="'+ otheruser +'" hidden></div>');
            
            $.each(messages, function(index, message) {
                var html;
                if (message.sender_id == user) {
                    html = 
                        '<div class="flex items-end justify-end p-3 m-2">' +
                        '<p class="p-2 bg-green-200 rounded-md border border-black">' + message.message + '</p>' +
                        '<img class="h-10 w-10 rounded-md ml-1" src="'+ userimage +'">' +
                        '</div>';
                } else {
                    html = 
                        '<div class="flex items-end justify-start p-3 m-2">' +
                        '<img class="h-10 w-10 rounded-md mr-1" src="'+ otheruserimage+'">' +
                        '<p class="p-2 bg-white rounded-md border border-black">' + message.message + '</p>' +
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

            target.css('background-color','rgb(209 213 219)');            
        },
        error: function (response) {
        alert(route);
        }
    });
}
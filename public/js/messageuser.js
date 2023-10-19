
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
            

            div.empty();

            $.each(messages, function(index, message) {
                var html;
                if (message.sender_id == user) {
                    html = 
                        '<div class="flex items-end justify-end p-3 m-2">' +
                        '<p class="p-2 bg-green-200 rounded-md border border-black">' + message.message + '</p>' +
                        '<img class="h-10 w-10 rounded-md ml-1" src="'+userimage+'">' +
                        '</div>';
                } else {
                    html = 
                        '<div class="flex items-end justify-start p-3 m-2">' +
                        '<img class="h-10 w-10 rounded-md mr-1" src="'+otheruserimage+'">' +
                        '<p class="p-2 bg-white rounded-md border border-black">' + message.message + '</p>' +
                        '</div>';
                }
                div.append(html);
            });

        },
        error: function (response) {
        alert(route);
        }
    });
}
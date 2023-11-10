$(function(){
    var input = $('#name');
    var route = input.data('search-route');
    var searchtimeout;

    input.on('input', function(){
        clearTimeout(searchtimeout);

        searchtimeout = setTimeout(function(){

            var search = input.val();

            $.ajax({
                url: route,
                method: 'GET',
                data: {
                    search: search,
                },
                dataType: 'json',
                
                success: function(response){
                    var users = response.userResults;
                    div = $('#users');

                    div.empty();

                    $.each(users, function(index, user) {

                        var userRoute = '/user/' + user.id;

                        var userimage = user.pfp ? '/storage/profilepicture/' + user.id + '.' + user.pfp : '/img/no-image.svg';


                        var html = 
                            '<a href="'+userRoute+'">'+
                                '<div data-user-id="'+user.id+'" class="group p-4 mr-auto flex flex-1 space-x-2 border-b border-black hover:bg-gray-50 user">'+
                                    '<img class="my-auto h-10 w-10 rounded-md" src="'+userimage+' ">'+
                                        '<div class="flex-1">'+
                                            '<div class="flex justify-between items-center">'+
                                                '<div id="content">'+
                                                    '<span class="text-black">'+user.name+'</span>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                '</div>'+
                            '</a>';
                            
                        div.append(html);
                    })
                },

                error: function(){
                    alert('Ocorreu um erro, verifique sua conexão.');
                }
            })
        }, 200);

    })
});
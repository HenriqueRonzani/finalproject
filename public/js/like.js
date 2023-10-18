
function toggle(event, route){
    event.preventDefault();

    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    var form = $(event.target);
    
    var image = form.find('.likeimage');
    var likedinput = form.find('input[name="liked"]');
    var liked = likedinput.val();

    var postId = form.data('post-id');

    $.ajax({
        url: route,
        type: "POST",
        data: {
            _token: csrfToken,
            liked: liked, 
            postId: postId
        },
        dataType: 'json',
        
        success: function(response){
            
            likedinput.val(liked === "true" ? "false" : "true");

            var count = response.count;
            var imageSrc = response.asset;

            form.find('.likecounter').html(count);
            image.attr('src', imageSrc);
        },
        error: function(response){
            alert('Error');
        }
    });
}
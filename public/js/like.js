

function toggle(event, route1, route2){
    event.preventDefault();

    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    var form = $(event.target);
    
    var image = form.find('.likeimage');
    var likedinput = form.find('input[name="liked"]');
    var liked = likedinput.val();

    var likable = form.data('likable');

    var route = liked !== "true" ? route2 : route1;

    likedinput.val(liked === "true" ? "false" : "true");
    
    $.ajax({
        url: route,
        type: "POST",
        data: {
            _token: csrfToken,
            likable: likable
        },
        dataType: 'json',
        
        success: function(response){

            var count = response.count;
            var imageSrc = response.asset;

            form.find('.likecounter').html(count);
            image.attr('src', imageSrc);


            if (likable == "comment" && $('#mostlikedform').data('comment-id') == response.commentId)
            {
                otherform = form.attr('id') == 'mostlikedform' ? $('#mostliked') : $('#mostlikedform');
            
                otherform.find('.likecounter').html(count);
                otherform.find('.likeimage').attr('src', imageSrc);
                otherform.find('input[name="liked"]').val(liked === "true" ? "false" : "true");
            }
        },
        error: function(response){
            likedinput.val(liked === "true" ? "false" : "true");
            alert('Error');
            
        }
    });
}


function togglecomment(event, route, isMostLiked){
    event.preventDefault();
 
    

    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    var form = $(event.target);
    
    var image = form.find('.likeimage');
    var likedinput = form.find('input[name="liked"]');
    var liked = likedinput.val();

    var commentId = form.data('comment-id');

    $.ajax({
        url: route,
        type: "POST",
        data: {
            _token: csrfToken,
            liked: liked, 
            commentId: commentId
        },
        dataType: 'json',
        
        success: function(response){
            
            likedinput.val(liked === "true" ? "false" : "true");

            var count = response.count;
            var imageSrc = response.asset;

            form.find('.likecounter').html(count);
            image.attr('src', imageSrc);

            

            if ($('#mostlikedform').data('comment-id') == commentId){
                otherform = isMostLiked ? $('#mostliked') : $('#mostlikedform');
            
                otherform.find('.likecounter').html(count);
                otherform.find('.likeimage').attr('src', imageSrc);
                otherform.find('input[name="liked"]').val(liked === "true" ? "false" : "true");
            }
        },
        error: function(response){
            alert('Error');
        }
    });
}


function toggle(event, route){
    event.preventDefault();
    
    var form = $(event.target);
    
    var button = form.find('.likebutton');

    button.prop('disabled', true);

    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    var image = form.find('.likeimage');

    var likedinput = form.find('input[name="liked"]');
    var liked = likedinput.val();

    var likable = form.data('likable');
    
    $.ajax({
        url: route,
        type: "POST",
        data: {
            _token: csrfToken,
            likable: likable,
            liked: liked
        },
        dataType: 'json',
        
        success: function(response){

            likedinput.val(liked === "true" ? "false" : "true");

            var imageSrc = response.asset;
            var count = response.count;

            form.find('.likecounter').html(count);
            image.attr('src', imageSrc);


            if (likable == "comment" && $('#mostlikedvalue').data('most-liked') == response.commentId)
            {
                otherform = form.attr('id') == 'mostlikedform' ? $('#mostliked') : $('#mostlikedform');
            
                otherform.find('.likecounter').html(count);
                otherform.find('.likeimage').attr('src', imageSrc);
                otherform.find('input[name="liked"]').val(liked === "true" ? "false" : "true");
            }
        },
        error: function(response){
            alert('Error');
        },

        complete: function(){
            $(button).prop('disabled', false);
        }
    });
}
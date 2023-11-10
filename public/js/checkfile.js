
$(function(){
    $('#arquivo').on('change', function(){
        var inputValue = $(this).val();
        var allowedExts = ["png","jpg","jpeg"];

        if(inputValue){
            var extension = inputValue.split('.').pop().toLowerCase();
            if($.inArray(extension, allowedExts) === -1){
                alert('Invalid file extension. Please upload a file with a valid extension.');

                $(this).val('');
            }
        }
    })

})
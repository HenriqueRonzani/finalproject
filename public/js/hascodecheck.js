$(function(){
    checkbox = $('#hascode');

    checkbox.change(function () {
        if (checkbox.is(':checked')){
            $('#codecomment').show();
            checkbox.val(true);
        }
        else {
            $('#codecomment').hide();
            checkbox.val(false);
        }
    })
});
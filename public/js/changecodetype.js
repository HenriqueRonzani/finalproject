$(function (){
    var textarea = $('#code');
    $('#types').on('change', function(){
        var selectedoption = $(this).val();

        console.log(selectedoption);
        if ( selectedoption == 1 )
        {
            textarea.css('background', 'rgb(229, 231, 235)')
            textarea.css('color', 'rgb(31, 41, 55)' )
        }
        
        else
        {
            textarea.css('background', 'rgb(3, 7, 18)');
            textarea.css('color', 'rgb(209, 213, 219)');
        }
    })
})
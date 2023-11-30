$(function (){
    var textarea = $('#code');
    $('#types').on('change', function(){
        var selectedoption = $(this).val();

        console.log(selectedoption);
        if ( selectedoption == 1 )
        {
            textarea.css({
                'background': 'rgb(229, 231, 235)',
                'color':'rgb(31, 41, 55)',
                'transition': 'background 0.3s, color 0.3s'
            });
        }
        
        else
        {
            textarea.css({
                'background': 'rgb(3, 7, 18)',
                'color':'rgb(209, 213, 219)',
                'transition': 'background 0.3s, color 0.3s'
            });
        }
    })
})
$(document).ready(function() {
    $('#loginForm').on('click', 'input[name=register]', function(e){
        e.preventDefault();
       
        $.post(
            '/authorize/register',
            { 
                email:      $('input[name=email]').val(), 
                password:   $('input[name=password]').val(),
                save:       $('#save_checkbox').is(':checked')
            },
            function(data){
                
                if(data.error !== undefined) {
                    $('#error').html(data.error);
                }
                else {
                    $('#userEmail').html('Вы зашли как: ' + '<a href="/user/profile/id/'+ data.id + '">' + data.email + '</a>');
                    $('#userId').html('<a id="logout" href="#">Exit</a>');
                    $('#loginFormDiv').hide();
                    $('#error').empty();
                }
            },
           'json'
        );
    });
});
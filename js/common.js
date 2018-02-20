function registerCall() {
    var msg   = $('#formx').serialize();
        $.ajax({
        type: 'POST',
        url: 'register.php',
        data: msg,
        success: function(data) {
            $('#result-register').html(data);
            
        },
        error:  function(xhr, str){
            alert('Возникла ошибка: ' + xhr.responseCode);
        }
        });
    
}

function loginCall(){
    var msg2   = $('#form2').serialize();
        $.ajax({
        type: 'POST',
        url: 'login.php',
        data: msg2,
        success: function(data2) {
            $('#result-login').html(data2);
            if(~data2.indexOf("Hello")){
                $(".log").fadeOut(500);
            }
        },
        error:  function(xhr, str){
            alert('Возникла ошибка: ' + xhr.responseCode);
        }
        });
}

$(function(){
    $('.register').click(function(){
       $('.log').fadeOut(500);
       $('.reg').fadeIn(500);
       $('.register').fadeOut(100);
       $('.login').fadeIn(500);
    });
    $('.login').click(function(){
       $('.log').fadeIn(500);
       $('.reg').fadeOut(500);
       $('.register').fadeIn(100);
       $('.login').fadeOut(500);
    });
})
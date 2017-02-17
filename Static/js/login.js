$(document).ready(function(){

	$('#login-ingresar').on('click', function(){

		$(".error").fadeOut().remove();
		if (true) {
			$('.login_section').prepend('<span class="error-validate">Osea</span>');
		}
		if ($("#usuario").val() == "") {
            $("#usuario").focus().after('<span class="error">Ingrese su usuario</span>');  
            return false;
        }
        if ($("#usuario").val().length < 3) {
            $("#usuario").focus().after('<span class="error">Ingrese un usuario correcto</span>');  
            return false;
        }
		if ($("#contrasena").val() == "") {
            $("#contrasena").focus().after('<span class="error">Ingrese su contraseña</span>');  
            return false;
        }

		var cont = 0;
        $(".error").each(function(index, element){ cont++; });

        if(cont <= 0){
        	var usuario = $('#usuario').val(), 
        	contrasena = $('#contrasena').val();

			$.ajax({
				async: true,
				url: 'iniciarSession/'+usuario+'/'+contrasena+'/',
				cache: false,
				data: { },
				type: 'POST',
				beforeSend : function(){

				},
				success : function(data){
					
					console.log(data);
					if (data==1) {
						location.href = '../';
					}
				},
				error : function(xhr, status){

				},
				complete: function(xhr, status){

				}
			});        	
        }

		return false;
	});
	
	
	$('#recovery-enviar').on('click', function(){

		$(".error").fadeOut().remove();
		if ($("#usuario_recovery").val() == "") {
            $("#usuario_recovery").focus().after('<span class="error">Ingrese su usuario</span>');  
            return false;
        }
        if ($("#usuario_recovery").val().length < 3) {
            $("#usuario_recovery").focus().after('<span class="error">Ingrese un usuario correcto</span>');  
            return false;
        }

		var cont = 0;
        $(".recovery_section .error").each(function(index, element){ cont++; });

        if(cont <= 0){
        	var usuario = $('#usuario').val();

			$.ajax({
				async: true,
				url: 'iniciarSession/'+usuario,
				cache: false,
				data: { },
				type: 'POST',
				beforeSend : function(){

				},
				success : function(data){
					
					console.log(data);
					if (data==1) {
						location.href = '../';
					}
				},
				error : function(xhr, status){

				},
				complete: function(xhr, status){

				}
			});        	
        }

		return false;
	});


    $("#usuario").bind('blur keyup', function(){
        if ($(this).val() != "") {              
            $('.error').fadeOut();
            return false;  
        }
    });


    $("#contrasena").bind('blur keyup', function(){
        if ($(this).val() != "") {              
            $('.error').fadeOut();
            return false;  
        }
    });


    $(document).keypress(function(e) {
	    if(e.which == 13) {
	    	if(!$('.login_section').hasClass('hide'))
	        	$('#login-ingresar').trigger( "click" );
	        else
	        	$('#recovery-enviar').trigger( "click" );
	    }
	});


    $('.flex-container').height( 
    	$(window).height() 
    );


    $('.reset_pass').click(function(){
    	$('.recovery_section').removeClass('hide');
    	$('.login_section').addClass('hide');
    });


    $('.login_enter').click(function(){
    	$('.login_section').removeClass('hide');
    	$('.recovery_section').addClass('hide');
    });


    $('.showpassword').click(function(){
    	var contrasena = $('#contrasena');
    	if(contrasena.attr('type') == 'text')
    		contrasena.attr('type','password');
    	else
    		contrasena.attr('type','text');
    });

    $('.form-control')
    .focus(function(){
    	$(this).parent().addClass('focus');
    })
    .focusout(function() {
    	$(this).parent().removeClass('focus');
 	});

});

$(window).resize(function(){

	$('.flex-container').height( 
    	$(window).height() 
    );

});
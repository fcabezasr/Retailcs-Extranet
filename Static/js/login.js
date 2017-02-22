$(document).ready(function(){

	$('#login-ingresar').on('click', function(){

		$(".error").fadeOut().remove();
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
					$('.error-validate').remove();
					switch(data){
						case '0':
							$('.login_section')
							.prepend('<span class="error-validate">Usuario y contraseña incorrectos.</span>');
							console.log('Usuario y contraseña incorrectos.');
							break;
						case '1':
							$('.login_section')
							.prepend('<span class="error-validate">Usuario y contraseña incorrectos.</span>');
							console.log('Usuario y contraseña correctos.');
							// location.href = '../';
							break;
						case '2':
							$('.login_section')
							.prepend('<span class="error-validate">El usuario no existe.</span>');
							console.log('El usuario no existe.');
							break;
						case '3':
							$('.login_section')
							.prepend('<span class="error-validate">La contraseña es incorrecta.</span>');
							console.log('La contraseña es incorrecta.');
							break;
						default:
							$('.login_section')
							.prepend('<span class="error-validate">Error desconocido.</span>');
							console.log('Error desconocido.');
							console.log(data);
							break;
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
    	$('#usuario_recovery').focus();

    	$('.login_section').addClass('hide');
    });


    $('.login_enter').click(function(){
    	$('.login_section').removeClass('hide');
    	$('.login_form').removeClass( 'animate' );
    	
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


$(window).load(function(){

	$('.login_form').addClass( 'animate' );
	$('#usuario').focus();

});


$(window).resize(function(){

	$('.flex-container').height( 
    	$(window).height() 
    );

});
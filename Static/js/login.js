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


});
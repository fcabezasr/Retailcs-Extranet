$(document).ready(function(){

	$("#menu_toggle").on("click",function(){
		var img = $('#logo-retailcs');
		if (img.hasClass('logo-small')) {
			img.removeClass('logo-small').attr('src', './Static/images/logo-retailcs.png').css('width', '50px');
		} else {
			img.addClass('logo-small').attr('src', './Static/images/logo-small-name.png').css('width', '100%');
		}
		
	});


	$('.sub_menu').on('click', function(){

		$('.menu-sup li').removeClass('active');
		$('.menu-inf').hide();
		$(this).parent().addClass('active');
		$(this).parent().find('.menu-inf').show();
	});


	$('.net-servicio').on('click', function(){

		/*$('.menu-inf.child_menu li').removeClass('active');
		$(this).parent().addClass('active');*/

		var version = $(this).attr('ver'),
			pagina = $(this).parents('.menu-inf').attr('page'),
			servicio = $(this).parents('.menu-sup').attr('ser');

		$.ajax({
			async: true,
			url: './page/service/'+pagina+'/'+servicio+'/'+version+'/',
			cache: false,
			data: {},
			type: 'GET',
			beforeSend: function(){
				fcnLoading(); //Inicializa el div Loading
			},
			success: function(data){
				$('#principal').html(data);
			},
			error: function(xhr, status){
				alert('Ha ocurrido un error...');
				console.log(status);
				console.log(xhr);
			},
			complete: function(xhr, status){
				fcnFinishLoading(); //Finaliza el div Loading
			}
		});
		
		return false;
	});


	/*
	$('.net-servicio').on('click', function(){

		$('.child_menu li').removeClass('active');
		$(this).parent().addClass('active');

		var pagina = $(this).attr('page'), servicio = $(this).attr('ser');

		$.ajax({
			async: true,
			url: './page/service/'+pagina+'/'+servicio+'/',
			cache: false,
			data: {},
			type: 'GET',
			beforeSend: function(){
				fcnLoading(); //Inicializa el div Loading
			},
			success: function(data){
				$('#principal').html(data);
			},
			error: function(xhr, status){
				alert('Ha ocurrido un error...');
				console.log(status);
				console.log(xhr);
			},
			complete: function(xhr, status){
				fcnFinishLoading(); //Finaliza el div Loading
			}
		});

		return false;
	});
	*/
	
	$('.gestion-admin').on('click', function(){

		$('.child_menu li').removeClass('active');
		$(this).parent().addClass('active');

		var pagina = $(this).attr('page'), seccion = $(this).attr('section');

		$.ajax({
			async: true,
			url: './page/management/'+pagina+'/'+seccion+'/',
			cache: false,
			data: {},
			type: 'GET',
			beforeSend: function(){
				fcnLoading(); //Inicializa el div Loading
			},
			success: function(data){
				$('#principal').html(data);
			},
			error: function(xhr, status){
				alert('Ha ocurrido un error...');
			},
			complete: function(xhr, status){
				fcnFinishLoading(); //Finaliza el div Loading
			}
		});

		return false;
	});


	$('.redes-sociales').on('click', function(){

		$('.child_menu li').removeClass('active');
		$(this).parent().addClass('active');
	});


	$(document).find('click', '.close-link', function(){

		var a=$(this).closest(".x_panel");
		a.remove();
	});


	$(document).on('click', '.collapse-link', function(){

		var a=$(this).closest(".x_panel"), b=$(this).find("i"), c=a.find(".x_content");
		a.attr("style")?c.slideToggle(200,function(){a.removeAttr("style")}):(c.slideToggle(200),a.css("height","auto")),b.toggleClass("fa-chevron-up fa-chevron-down");
	});


	$(document).on('click', '.collapse-list', function(){

		$(this).css('background', '#F5F7FA');
		$('.collapse-grilla').css('background', '#FFF');
		var a = $('.col-md-55');
		a.css('width', '100%');
		a.find('.view-list').css('display', 'none');
		a.find('.caption').css('text-align', 'left');
		a.find('.caption-left').css({'display': 'block', 'float' : 'left'});
		a.find('.caption-right').css({'display': 'block', 'float' : 'right'});
		a.find('.br-list').css('display','none');
		a.css('background', '#F5F7FA;')
	});


	$(document).on('click', '.collapse-grilla', function(){

		$(this).css('background', '#F5F7FA');
		$('.collapse-list').css('background', '#FFF');
		var a = $('.col-md-55');
		a.css('width', '20%');
		a.find('.view-list').css('display', 'block');
		a.find('.caption').css('text-align', 'center');
		a.find('.caption-left').css({'display': 'block', 'float' : 'none'});
		a.find('.caption-right').css({'display': 'block', 'float' : 'none'});
		a.find('.br-list').css('display','block');
	});


	$(document).on('click', '.view-video', function(){

		var url = $(this).parent().parent().parent().find('.iframe-video').attr('src');
		var cadena = url.split('?');
		url = cadena[0]+'?autoplay=1';
		$('#modal-video').find('#modal-iframe').attr('src',url);
		$('#modal-video').modal('show');
	});


	$(document).on('click', '#modal-video', function(){
		
		var url = $('#modal-iframe').attr('src');
		var cadena = url.split('?');
		url = cadena[0]+'?autoplay=0';
		$('#modal-iframe').attr('src',url);
		$('#modal-video').modal('hide');
	});


	$(document).on('click', '.download-content', function(){

		var idcontent = $(this).attr('idcontent');

		$.ajax({
			async: true,
			url: './ajax/contentPdf/'+idcontent+'/',
			cache: false,
			data: {},
			type: 'GET',
			beforeSend: function(){
				fcnLoading(); //Inicializa el div Loading
			},
			success: function(data){
				$('#principal').html(data);
			},
			error: function(xhr, status){
				alert('Ha ocurrido un error...');
			},
			complete: function(xhr, status){
				fcnFinishLoading(); //Finaliza el div Loading
			}
		});
	});

	
	/*** INICIO - FJ - COMPONENTE QUE VALIDAD FORMULARIOS ***/

	$(document).on('click', '#btn-guardar-user', function(){

		var a = '#'+$(this).parents('.form-horizontal').prop('id'), cont = 0;

		$(a).find('.form-control').each(function(index, value){
			var id = '#'+$(this).prop('id'), val = $(id).attr('required');
			$(id).attr('data-parsley-id',index);

			if (!(typeof val == "undefined")) {
				$('#parsley-id-'+index).remove();
				if ($(id).val().length > 0) {
					$(id).removeClass('parsley-error');
				} else {
					$(id).addClass('parsley-error').parent().append('<ul class="parsley-errors-list filled" id="parsley-id-'+index+'"><li class="parsley-required">Este campo es necesario.</li></ul>');
				}
			}
		});

		$(a).find('.parsley-errors-list').each(function(index, value){
			cont++;
		});

		if (cont <= 0) {
			var user_name = $('#user-name').val(),
				password = $('#password').val(),
				repeat_password = $('#repeat-password').val(),
				business_name = $('#business-name').val(),
				type_user = $('#type-user').val();
			
			if (password!=repeat_password) {
				var id_rp = $('#repeat-password').attr('data-parsley-id');
				$('#repeat-password').addClass('parsley-error').parent().append('<ul class="parsley-errors-list filled" id="parsley-id-'+id_rp+'"><li class="parsley-required">La contraseña no coincide.</li></ul>');
			} else {
				$.ajax({
					async: true,
					url: './user/insertUser/'+user_name+'/'+password+'/'+business_name+'/'+type_user+'/',
					cache: false,
					data: { },
					type: 'POST',
					dataType: 'json',
					beforeSend: function(){
						fcnLoading(); //Inicializa el div Loading
					},
					success: function(data){
						console.log(data);
						$('.text-message').html(data.result.message);
						$('#div-message').removeClass('alert-info alert-danger');
						if (data.result.success == 1) {
							$('#div-message').addClass('alert-info');
						} else {
							$('#div-message').addClass('alert-danger');
						}
						$('#div-alert').css('display', 'block');
						$('#form-user')[0].reset();
					},
					error: function(xhr, status){
						alert('Ha ocurrido un error...');
					},
					complete: function(xhr, status){
						fcnFinishLoading(); //Finaliza el div Loading
						setTimeout(function(){ $('#div-alert').css('display', 'none'); }, 5000); //Finaliza el mensaje de alerta
					}
				});
			}
		}

		return false;
	});


	$(document).on('keypress keyup change', '.form-horizontal .form-control', function(){
		
		var id = '#'+$(this).prop('id'), parsley = $(this).attr('data-parsley-id');

		$('#parsley-id-'+parsley).remove();
		if ($(id).val().length > 0) {
			$(id).removeClass('parsley-error');
		} else {
			$(id).addClass('parsley-error').parent().append('<ul class="parsley-errors-list filled" id="parsley-id-'+parsley+'"><li class="parsley-required">Este campo es necesario.</li></ul>');
		}
	});

	/*** FIN - FJ - COMPONENTE QUE VALIDA FORMULARIOS ***/


	$(document).on('click', '#btn-guardar-type-user', function(){

		var a = '#'+$(this).parents('.form-horizontal').prop('id'), cont = 0;

		$(a).find('.form-control').each(function(index, value){
			var id = '#'+$(this).prop('id'), val = $(id).attr('required');
			$(id).attr('data-parsley-id',index);

			if (!(typeof val == "undefined")) {
				$('#parsley-id-'+index).remove();
				if ($(id).val().length > 0) {
					$(id).removeClass('parsley-error');
				} else {
					$(id).addClass('parsley-error').parent().append('<ul class="parsley-errors-list filled" id="parsley-id-'+index+'"><li class="parsley-required">Este campo es necesario.</li></ul>');
				}
			}
		});

		$(a).find('.parsley-errors-list').each(function(index, value){
			cont++;
		});

		if (cont <= 0) {
			var description_type = $('#description-type').val();
			
			$.ajax({
				async: true,
				url: './user/insertTypeUser/'+description_type+'/',
				cache: false,
				data: { },
				type: 'POST',
				dataType: 'json',
				beforeSend: function(){
					fcnLoading(); //Inicializa el div Loading
				},
				success: function(data){
					console.log(data);
					$('.text-message').html(data.result.message);
					$('#div-message').removeClass('alert-info alert-danger');
					if (data.result.success == 1) {
						$('#div-message').addClass('alert-info');
					} else {
						$('#div-message').addClass('alert-danger');
					}
					$('#div-alert').css('display', 'block');
					$('#form-type-user')[0].reset();
				},
				error: function(xhr, status){
					alert('Ha ocurrido un error...');
				},
				complete: function(xhr, status){
					fcnFinishLoading(); //Finaliza el div Loading
					setTimeout(function(){ $('#div-alert').css('display', 'none'); }, 5000); //Finaliza el mensaje de alerta
				}
			});
		}

		return false;
	});


	$(document).on('click', '#btn-guardar-product', function(){

		var a = '#'+$(this).parents('.form-horizontal').prop('id'), cont = 0;

		$(a).find('.form-control').each(function(index, value){
			var id = '#'+$(this).prop('id'), val = $(id).attr('required');
			$(id).attr('data-parsley-id',index);

			if (!(typeof val == "undefined")) {
				$('#parsley-id-'+index).remove();
				if ($(id).val().length > 0) {
					$(id).removeClass('parsley-error');
				} else {
					$(id).addClass('parsley-error').parent().append('<ul class="parsley-errors-list filled" id="parsley-id-'+index+'"><li class="parsley-required">Este campo es necesario.</li></ul>');
				}
			}
		});

		$(a).find('.parsley-errors-list').each(function(index, value){
			cont++;
		});

		if (cont <= 0) {
			var product_name = $('#product-name').val();
			
			$.ajax({
				async: true,
				url: './ajax/insertProduct/'+product_name+'/',
				cache: false,
				data: { },
				type: 'POST',
				dataType: 'json',
				beforeSend: function(){
					fcnLoading(); //Inicializa el div Loading
				},
				success: function(data){
					console.log(data);
					$('.text-message').html(data.result.message);
					$('#div-message').removeClass('alert-info alert-danger');
					if (data.result.success == 1) {
						$('#div-message').addClass('alert-info');
					} else {
						$('#div-message').addClass('alert-danger');
					}
					$('#div-alert').css('display', 'block');
					$('#form-product')[0].reset();
				},
				error: function(xhr, status){
					alert('Ha ocurrido un error...');
				},
				complete: function(xhr, status){
					fcnFinishLoading(); //Finaliza el div Loading
					setTimeout(function(){ $('#div-alert').css('display', 'none'); }, 5000); //Finaliza el mensaje de alerta
				}
			});
		}

		return false;
	});


	$(document).on('click', '#btn-guardar-version', function(){

		var a = '#'+$(this).parents('.form-horizontal').prop('id'), cont = 0;

		$(a).find('.form-control').each(function(index, value){
			var id = '#'+$(this).prop('id'), val = $(id).attr('required');
			$(id).attr('data-parsley-id',index);

			if (!(typeof val == "undefined")) {
				$('#parsley-id-'+index).remove();
				if ($(id).val().length > 0) {
					$(id).removeClass('parsley-error');
				} else {
					$(id).addClass('parsley-error').parent().append('<ul class="parsley-errors-list filled" id="parsley-id-'+index+'"><li class="parsley-required">Este campo es necesario.</li></ul>');
				}
			}
		});

		$(a).find('.parsley-errors-list').each(function(index, value){
			cont++;
		});

		if (cont <= 0) {
			var idproduct = $('#idproduct').val(),
				version_description = $('#version-description').val(),
				registry_description = $('#registry-description').val();
			
			$.ajax({
				async: true,
				url: './ajax/insertVersion/'+idproduct+'/'+version_description+'/'+registry_description+'/',
				cache: false,
				data: { },
				type: 'POST',
				dataType: 'json',
				beforeSend: function(){
					fcnLoading(); //Inicializa el div Loading
				},
				success: function(data){
					console.log(data);
					$('.text-message').html(data.result.message+' '+data.result.message2);
					$('#div-message').removeClass('alert-info alert-danger');
					if (data.result.success == 1) {
						$('#div-message').addClass('alert-info');
					} else {
						$('#div-message').addClass('alert-danger');
					}
					$('#div-alert').css('display', 'block');
					$('#form-version')[0].reset();
				},
				error: function(xhr, status){
					alert('Ha ocurrido un error...');
				},
				complete: function(xhr, status){
					fcnFinishLoading(); //Finaliza el div Loading
					setTimeout(function(){ $('#div-alert').css('display', 'none'); }, 5000); //Finaliza el mensaje de alerta
				}
			});
		}

		return false;
	});


	$(document).on('click', '#btn-guardar-content', function(){

		var a = '#'+$(this).parents('.form-horizontal').prop('id'), cont = 0;

		$(a).find('.form-control').each(function(index, value){
			var id = '#'+$(this).prop('id'), val = $(id).attr('required');
			$(id).attr('data-parsley-id',index);

			if (!(typeof val == "undefined")) {
				$('#parsley-id-'+index).remove();
				if ($(id).val().length > 0) {
					$(id).removeClass('parsley-error');
				} else {
					$(id).addClass('parsley-error').parent().append('<ul class="parsley-errors-list filled" id="parsley-id-'+index+'"><li class="parsley-required">Este campo es necesario.</li></ul>');
				}
			}
		});

		$(a).find('.parsley-errors-list').each(function(index, value){
			cont++;
		});
		
		if (cont <= 0) {
			var data = {};
			data['idcontent_type'] = $('#idcontent-type').val();
			data['idproduct'] = $('#idproduct').val();
			data['idversion_product'] = $('#idversion-product').val();
			data['detail_description'] = $('#detail-description').val();
			data['registry_date'] = $('#registry-date').val();

			var data_json = JSON.stringify(data);
	
			$.ajax({
				async: true,
				url: './content/insertContent/'+data_json+'/',
				cache: false,
				data: { },
				type: 'POST',
				dataType: 'json',
				beforeSend: function(){
					fcnLoading(); //Inicializa el div Loading
				},
				success: function(data){
					console.log(data);
					$('.text-message').html(data.result.message);
					$('#div-message').removeClass('alert-info alert-danger');
					if (data.result.success == 1) {
						$('#div-message').addClass('alert-info');
					} else {
						$('#div-message').addClass('alert-danger');
					}
					$('#div-alert').css('display', 'block');
					$('#form-content')[0].reset();
				},
				error: function(xhr, status){
					alert('Ha ocurrido un error...');
				},
				complete: function(xhr, status){
					fcnFinishLoading(); //Finaliza el div Loading
					setTimeout(function(){ $('#div-alert').css('display', 'none'); }, 5000); //Finaliza el mensaje de alerta
				}
			});
		}
		
		return false;
	});


	$(document).on('click', '#btn-guardar-file', function(){

		var a = '#'+$(this).parents('.form-horizontal').prop('id'), cont = 0;

		$(a).find('.form-control').each(function(index, value){
			var id = '#'+$(this).prop('id'), val = $(id).attr('required');
			$(id).attr('data-parsley-id',index);

			if (!(typeof val == "undefined")) {
				$('#parsley-id-'+index).remove();
				if ($(id).val().length > 0) {
					$(id).removeClass('parsley-error');
				} else {
					$(id).addClass('parsley-error').parent().append('<ul class="parsley-errors-list filled" id="parsley-id-'+index+'"><li class="parsley-required">Este campo es necesario.</li></ul>');
				}
			}
		});

		$(".upload-file").each(function(){
			if ($(this).is(':checked')) {	
				switch ($(this).val()) {
					case 'file':
						$('#parsley-id-4').remove();
						$('#file-url').removeClass('parsley-error');
						break;
					case 'url':
						$('#parsley-id-3').remove();
						$('#file-upload').removeClass('parsley-error');
						break;
					default:
						break;
				}
			}
		});

		$(a).find('.parsley-errors-list').each(function(index, value){
			cont++;
		});
		
		if (cont <= 0) {
			var formData = new FormData($("#form-file")[0]);

			$.ajax({
			    url: './file/insertFile/',
			    cache: false, //necesario para subir archivos via ajax
			    data: formData, // Form data: datos del formulario
			    type: 'POST',
			    contentType: false,
			    processData: false,
			    dataType: 'json',
			    beforeSend: function(){
			    	fcnLoading(); //Inicializa el div Loading
			    },
			    success: function(data){
			    	console.log(data);
					$('.text-message').html(data.result.message+' '+data.result.file);
					$('#div-message').removeClass('alert-info alert-danger');
					if (data.result.success == 1) {
						$('#div-message').addClass('alert-info');
					} else {
						$('#div-message').addClass('alert-danger');
					}
					$('#div-alert').css('display', 'block');
					$('#form-file')[0].reset();
			    },
			    error: function(xhr, status){
			    	alert('Ha ocurrido un error...');
			    },
				complete: function(xhr, status){
					fcnFinishLoading(); //Finaliza el div Loading
					setTimeout(function(){ $('#div-alert').css('display', 'none'); }, 5000); //Finaliza el mensaje de alerta
				}
			});
		}
		
		return false;
	});


	$(document).on('click', '.upload-file', function(){

		var temp = $(this).val();
		switch(temp){
			case 'file':
				$('#file-upload').attr('required', true).parent().parent().css('display','block');
				$('#file-url').attr('required', false).parent().parent().css('display','none');
				break;
			case 'url':			
				$('#file-upload').attr('required', false).parent().parent().css('display','none');
				$('#file-url').attr('required', true).parent().parent().css('display','block');
				break;
			default:
				break;
		}

	});


	$(document).on('change', '#idproduct', function(){
		var idproduct = $(this).val();

		$.ajax({
			async: true,
			url: './ajax/listVersion/'+idproduct+'/',
			cache: false,
			data: { },
			type: 'POST',
			//dataType: 'json',
			beforeSend: function(){
				fcnLoading(); //Inicializa el div Loading
			},
			success: function(data){
				console.log(data);
				$('#idversion-product').html('<pre>'+data+'</pre>');
			},
			error: function(xhr, status){
				alert('Ha ocurrido un error...');
			},
			complete: function(xhr, status){
				fcnFinishLoading(); //Finaliza el div Loading
			}
		});

	});


/*

//Se utiliza para que el campo de texto solo acepte letras
function soloLetras(e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toString();
    letras = " áéíóúabcdefghijklmnñopqrstuvwxyzÁÉÍÓÚABCDEFGHIJKLMNÑOPQRSTUVWXYZ";//Se define todo el abecedario que se quiere que se muestre.
    especiales = [8, 37, 39, 46, 6]; //Es la validación del KeyCodes, que teclas recibe el campo de texto.

    tecla_especial = false
    for(var i in especiales) {
        if(key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }

    if(letras.indexOf(tecla) == -1 && !tecla_especial){
alert('Tecla no aceptada');
        return false;
      }
}
*/

	function fcnLoading(){
		
		$('.nav-md').append('<div class="div-loading"><img class="img-loading" src="./Static/images/loading.gif" alt="Loading"></div>');
	}

	function fcnFinishLoading(){

		$('.div-loading').remove();
	}

});
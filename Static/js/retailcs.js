$(document).ready(function(){

	/*** INICIO - FJ - EXPRESIÓNES REGULARES ***/
		
	// Para números, útil para filtrar los famosos ids.
	var exp_numeros = /^[0-9]+$/,
		// Para números, útil para filtrar los famosos ids.
		exp_decimal = /^[0-9.]+$/,
		// Sólo letras, pero esto no incluye los acentos, así que si introduces á no es correcto.
		exp_letras = /^[a-zA-Z]+$/,
		// Para caracteres latinos(acentos), espacios y guiones bajos. el espacio se indica con \s.
		exp_letras_latinas = /^[0-9a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ_.\s]+$/,
		// Para emails, válidos pueden ser: miemail@gmail.com, mi.email@gmail.es, ...
		exp_email = /^[a-zA-Z0-9\._-]+@[a-zA-Z0-9-]{2,}[.][a-zA-Z]{2,4}$/,
		// Para passwords que tienen que contener tanto números como letras
		exp_password = /^[0-9a-zA-Z_.@]+$/,
		// Para urls
		//exp_url = /^(ht|f)tps?:\/\/\w+([\.\-\w]+)?\.([a-z]{2,6})?([\.\-\w\/_]+)$/i,
		exp_url = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/,
		// Para alphanumeric
		exp_alphanumeric = /^[0-9a-zA-Z_.\s]+$/;

	var url_file = 'http://www.retailcs.com/apps/extranet/Files/';


	/*** INICIO - FJ - LOGIN - LOGOUT ***/

	$(document).on('click', '#logout', function(){

		$.ajax({
			async: true,
			url: './login/cerrarSession/',
			cache: false,
			data: {},
			type: 'POST',
			dataType: 'json',
			beforeSend: function(){
				fcnLoading(); //Inicializa el div Loading
			},
			success: function(data){				
				if (data.result.success) {
					window.location.href = './';
				} else {
					$('#principal').html(data);
				}
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


	$(document).on('click', '#menu_toggle', function(){

		var img = $('#logo-retailcs');
		if (img.hasClass('logo-small')) {
			img.removeClass('logo-small').attr('src', './Static/images/logo-retailcs.png').css('width', '50px');
		} else {
			img.addClass('logo-small').attr('src', './Static/images/logo-small-name.png').css('width', '100%');
		}
	});


	$(document).on('click', '.sub_menu', function(){

		$('.menu-sup li').removeClass('active');
		$('.menu-inf').hide();
		$(this).parent().addClass('active');
		$(this).parent().find('.menu-inf').show();
	});


	$(document).on('click', '.net-servicio', function(){

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
				// Cambia de Idioma
				fncChangeLanguage();
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

	
	$(document).on('click', '.gestion-admin', function(){

		$('.child_menu li').removeClass('active');
		$(this).parent().addClass('active');

		var pagina = $(this).attr('page'), 
			seccion = $(this).attr('section');

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
				// Cambia de Idioma
				fncChangeLanguage();
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


	$(document).on('click', '.redes-sociales', function(){

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

		var idcontent = $(this).attr('idcontent'),
			description = $(this).attr('description'),
			product = $(this).attr('product'),
			version = $(this).attr('version'),
			language = $(this).attr('language');

		$.ajax({
			async: true,
			url: './ajax/contentPdf/'+idcontent+'/'+description+'/'+product+'/'+version+'/'+language+'/',
			cache: false,
			data: { },
			type: 'POST',
			dataType: 'JSON',
			beforeSend: function(){
				fcnLoading(); //Inicializa el div Loading
			},
			success: function(data){
				console.log(data);

				if (data.result.success) {
					window.location.href = './Files/fpdf/Pdf.php?idcontent='+data.result.idcontent+'&description='+data.result.description+'&product='+data.result.product+'&version='+data.result.version+'&language='+data.result.language;
				} else {
					$('#principal').html(fcnReturnLanguage('pdf',''));
				}
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
					$(id).addClass('parsley-error').parent().append('<ul class="parsley-errors-list filled" id="parsley-id-'+index+'"><li class="parsley-required">'+fcnReturnLanguage('campo','')+'</li></ul>');
				}
			}
		});

		$(a).find('.parsley-errors-list').each(function(index, value){
			cont++;
		});

		if (cont <= 0) {
			var iduser = $('#user-id').val(),
				user_name = $('#user-name').val(),
				password = $('#password').val(),
				repeat_password = $('#repeat-password').val(),
				business_name = $('#business-name-sel').val(),
				type_user = $('#type-user').val();
			
			if (password!=repeat_password) {
				var id_rp = $('#repeat-password').attr('data-parsley-id');
				$('#repeat-password').addClass('parsley-error').parent().append('<ul class="parsley-errors-list filled" id="parsley-id-'+id_rp+'"><li class="parsley-required">'+fcnReturnLanguage('pass','')+'</li></ul>');
			} else {
				$.ajax({
					async: true,
					url: './page/insertUser/'+iduser+'/'+user_name+'/'+password+'/'+business_name+'/'+type_user+'/',
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
							
							//Actualizar TableUser
							$('#content-table-user').html(data.result.datatable);
						} else {
							$('#div-message').addClass('alert-danger');
						}
						$('#div-alert').css('display', 'block');
						$('#btn-guardar-user').html(data.result.nameboton);
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

		// Asigna una posición a cada input
		$(this).parents('form').find('.form-control').each(function(index, value){
			$(this).attr('data-parsley-id', index);
		});

		if ($(this).attr('required') != undefined) {
			var id = '#'+$(this).prop('id'), 
				parsley = $(this).attr('data-parsley-id');

			$('#parsley-id-'+parsley).remove();
			if ($(id).val().length > 0) {
				$(id).removeClass('parsley-error');
			} else {
				$(id).addClass('parsley-error').parent().append('<ul class="parsley-errors-list filled" id="parsley-id-'+parsley+'"><li class="parsley-required">'+fcnReturnLanguage('campo','')+'</li></ul>');
			}
		}
	});

	/*** FIN - FJ - COMPONENTE QUE VALIDA FORMULARIOS ***/


	$(document).on('click', '#btn-guardar-business', function(){

		var a = '#'+$(this).parents('.form-horizontal').prop('id'), cont = 0;

		$(a).find('.form-control').each(function(index, value){
			var id = '#'+$(this).prop('id'), val = $(id).attr('required');
			$(id).attr('data-parsley-id',index);

			if (!(typeof val == "undefined")) {
				$('#parsley-id-'+index).remove();
				if ($(id).val().length > 0) {
					$(id).removeClass('parsley-error');
				} else {
					$(id).addClass('parsley-error').parent().append('<ul class="parsley-errors-list filled" id="parsley-id-'+index+'"><li class="parsley-required">'+fcnReturnLanguage('campo','')+'</li></ul>');
				}
			}
		});

		$(a).find('.parsley-errors-list').each(function(index, value){
			cont++;
		});

		if (cont <= 0) {

			var formData = new FormData($("#form-business")[0]);

			$.ajax({
			    url: './page/insertBusiness/',
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
					$('.text-message').html(data.result.message);
					$('#div-message').removeClass('alert-info alert-danger');
					if (data.result.success == 1) {
						$('#div-message').addClass('alert-info');
						
						//Actualizar TableBusiness
						$('#content-table-business').html(data.result.datatable);
					} else {
						$('#div-message').addClass('alert-danger');
					}
					$('#div-alert').css('display', 'block');
					$('#btn-guardar-business').html(data.result.nameboton);
					$('#form-business')[0].reset();
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
					$(id).addClass('parsley-error').parent().append('<ul class="parsley-errors-list filled" id="parsley-id-'+index+'"><li class="parsley-required">'+fcnReturnLanguage('campo','')+'</li></ul>');
				}
			}
		});

		$(a).find('.parsley-errors-list').each(function(index, value){
			cont++;
		});

		if (cont <= 0) {
			var idtype_user = $('#user-idtype').val(),
				description_type = $('#description-type').val();
			
			$.ajax({
				async: true,
				url: './page/insertTypeUser/'+idtype_user+'/'+description_type+'/',
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

						//Actualizar TableUser
						$('#content-table-type-user').html(data.result.datatable);
					} else {
						$('#div-message').addClass('alert-danger');
					}
					$('#div-alert').css('display', 'block');
					$('#btn-guardar-type-user').html(data.result.nameboton);
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
					$(id).addClass('parsley-error').parent().append('<ul class="parsley-errors-list filled" id="parsley-id-'+index+'"><li class="parsley-required">'+fcnReturnLanguage('campo','')+'</li></ul>');
				}
			}
		});

		$(a).find('.parsley-errors-list').each(function(index, value){
			cont++;
		});

		if (cont <= 0) {
			var product_id = $('#product-id').val(),
				product_name = $('#product-name').val(),
				product_icono = $('input:radio[name=radio-product]:checked').val();

			$.ajax({
				async: true,
				url: './inicio/insertProduct/'+product_id+'/'+product_name+'/'+product_icono+'/',
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

						// Actualizar TableProduct
						$('#content-table-product').html(data.result.datatable);
						// Actualiza el MENU PRODUCT
						$('#menu-product').html(data.result.menuproduct);
						$('#menu-admin').html(data.result.menuadmin);
					} else {
						$('#div-message').addClass('alert-danger');
					}
					$('#div-alert').css('display', 'block');
					$('#btn-guardar-product').html(data.result.nameboton);
					$('#form-product')[0].reset();

					// Refresca el JS del MENU
					init_sidebar();
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
					$(id).addClass('parsley-error').parent().append('<ul class="parsley-errors-list filled" id="parsley-id-'+index+'"><li class="parsley-required">'+fcnReturnLanguage('campo','')+'</li></ul>');
				}
			}
		});

		$(a).find('.parsley-errors-list').each(function(index, value){
			cont++;
		});

		if (cont <= 0) {
			var idversion = $('#version-id').val(),
				version_description = $('#version-description').val();
			
			$.ajax({
				async: true,
				url: './page/insertVersion/'+idversion+'/'+version_description+'/',
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

						//Actualizar TableVersion
						$('#content-table-version').html(data.result.datatable);
					} else {
						$('#div-message').addClass('alert-danger');
					}
					$('#div-alert').css('display', 'block');
					$('#btn-guardar-version').html(data.result.nameboton);
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
					$(id).addClass('parsley-error').parent().append('<ul class="parsley-errors-list filled" id="parsley-id-'+index+'"><li class="parsley-required">'+fcnReturnLanguage('campo','')+'</li></ul>');
				}
			}
		});

		$(a).find('.parsley-errors-list').each(function(index, value){
			cont++;
		});
		
		if (cont <= 0) {
			var formData = new FormData($("#form-content")[0]);

			$.ajax({
			    url: './content/insertContent/',
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

					if ($(id).hasClass('url')) {
						if ($(id).val().match(exp_url)) {
							$(id).removeClass('parsley-error');
						} else {
							$(id).addClass('parsley-error').parent().append('<ul class="parsley-errors-list filled" id="parsley-id-'+index+'"><li class="parsley-required">'+fcnReturnLanguage('url','')+'</li></ul>');
						}
					}

					if ($(id).hasClass('file-loading')) {
						var file_upload = this.files[0],
							sizeByte = file_upload.size,
							siezekiloByte = parseInt(sizeByte / 1024),
							size_file_validate = 5120;

						if(siezekiloByte <= size_file_validate){
							$(id).removeClass('parsley-error');
						} else {
							$(id).addClass('parsley-error').parent().append('<ul class="parsley-errors-list filled" id="parsley-id-'+index+'"><li class="parsley-required">'+fcnReturnLanguage('file',(size_file_validate/1024))+'</li></ul>');
						}

						if(!existeUrl(url_file+file_upload.name)){
							$(id).removeClass('parsley-error');
						} else {
							$(id).addClass('parsley-error').parent().append('<ul class="parsley-errors-list filled" id="parsley-id-'+index+'"><li class="parsley-required">'+fcnReturnLanguage('upload',file_upload.name)+'</li></ul>');
						}
					}
				} else {
					$(id).addClass('parsley-error').parent().append('<ul class="parsley-errors-list filled" id="parsley-id-'+index+'"><li class="parsley-required">'+fcnReturnLanguage('campo','')+'</li></ul>');
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


	$(document).on('click', '#btn-guardar-version-product', function(){

		var a = '#'+$(this).parents('.form-horizontal').prop('id'), cont = 0;

		$(a).find('.form-control').each(function(index, value){
			var id = '#'+$(this).prop('id'), val = $(id).attr('required');
			$(id).attr('data-parsley-id',index);

			if (!(typeof val == "undefined")) {
				$('#parsley-id-'+index).remove();
				if ($(id).val().length > 0) {
					$(id).removeClass('parsley-error');
				} else {
					$(id).addClass('parsley-error').parent().append('<ul class="parsley-errors-list filled" id="parsley-id-'+index+'"><li class="parsley-required">'+fcnReturnLanguage('campo','')+'</li></ul>');
				}
			}
		});

		$(a).find('.parsley-errors-list').each(function(index, value){
			cont++;
		});
		
		if (cont <= 0) {
			var formData = new FormData($("#form-version-product")[0]);

			$.ajax({
			    url: './page/insertVersionProduct/',
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
					$('.text-message').html(data.result.message);
					$('#div-message').removeClass('alert-info alert-danger');
					if (data.result.success == 1) {
						$('#div-message').addClass('alert-info');

						//Actualizar TableVersionProduct
						$('#content-table-version-product').html(data.result.datatable);
					} else {
						$('#div-message').addClass('alert-danger');
					}
					$('#div-alert').css('display', 'block');
					$('#btn-guardar-version-product').html(data.result.nameboton);
					$('#form-version-product')[0].reset();
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


	/********************      EDIT     ********************/

	$(document).on('click', '.btn-business-edit', function(){

		var idbusiness = $(this).attr('idbusiness');

		$.ajax({
			async: true,
			url: './page/updateBusiness/'+idbusiness+'/',
			cache: false,
			data: { },
			type: 'POST',
			dataType: 'json',
			beforeSend: function(){
				fcnLoading(); //Inicializa el div Loading
			},
			success: function(data){
				// Función que Limpia los campos
				fcnClearInput('#form-business');

				console.log(data);
				$('.text-message').html(data.result.message);
				$('#div-message').removeClass('alert-info alert-danger');
				if (data.result.success == 1) {
					$('#div-message').addClass('alert-info');
					$('#business-id').val(data.result.objBusiness.idbusiness);
					$('#business-name-bck').val(data.result.objBusiness.business_name);
					$('#business-name').val(data.result.objBusiness.business_name);
					$('#ruc').val(data.result.objBusiness.ruc);
					$('#address').val(data.result.objBusiness.address);
					$('#language').val(data.result.objBusiness.language);
					$('#btn-guardar-business').html(data.result.nameboton);

					//Actualizar TableBusiness
					$('#content-table-business').html(data.result.datatable);
				} else {
					$('#div-message').addClass('alert-danger');
				}
				$('#div-alert').css('display', 'block');
			},
			error: function(xhr, status){
				alert('Ha ocurrido un error...');
			},
			complete: function(xhr, status){
				fcnFinishLoading(); //Finaliza el div Loading
				setTimeout(function(){ $('#div-alert').css('display', 'none'); }, 5000); //Finaliza el mensaje de alerta
			}
		});
	});


	$(document).on('click', '.btn-user-edit', function(){

		var iduser = $(this).attr('iduser');

		$.ajax({
			async: true,
			url: './page/updateUser/'+iduser+'/',
			cache: false,
			data: { },
			type: 'POST',
			dataType: 'json',
			beforeSend: function(){
				fcnLoading(); //Inicializa el div Loading
			},
			success: function(data){
				// Función que Limpia los campos
				fcnClearInput('#form-user');

				console.log(data);
				$('.text-message').html(data.result.message);
				$('#div-message').removeClass('alert-info alert-danger');
				if (data.result.success == 1) {
					$('#div-message').addClass('alert-info');
					$('#user-id').val(data.result.objUser.iduser);
					$('#user-name-bck').val(data.result.objUser.user_name);
					$('#user-name').val(data.result.objUser.user_name);
					$('#password').val(data.result.objUser.user_pass);
					$('#repeat-password').val(data.result.objUser.user_pass);
					$('#business-name-sel').val(data.result.objUser.idbusiness);
					$('#type-user').val(data.result.objUser.idtype_user);
					$('#btn-guardar-user').html(data.result.nameboton);

					//Actualizar TableUser
					$('#content-table-user').html(data.result.datatable);
				} else {
					$('#div-message').addClass('alert-danger');
				}
				$('#div-alert').css('display', 'block');
			},
			error: function(xhr, status){
				alert('Ha ocurrido un error...');
			},
			complete: function(xhr, status){
				fcnFinishLoading(); //Finaliza el div Loading
				setTimeout(function(){ $('#div-alert').css('display', 'none'); }, 5000); //Finaliza el mensaje de alerta
			}
		});
	});


	$(document).on('click', '.btn-user-type-edit', function(){

		var idtype_user = $(this).attr('idtypeuser');

		$.ajax({
			async: true,
			url: './page/updateTypeUser/'+idtype_user+'/',
			cache: false,
			data: { },
			type: 'POST',
			dataType: 'json',
			beforeSend: function(){
				fcnLoading(); //Inicializa el div Loading
			},
			success: function(data){
				// Función que Limpia los campos
				fcnClearInput('#form-type-user');

				console.log(data);
				$('.text-message').html(data.result.message);
				$('#div-message').removeClass('alert-info alert-danger');
				if (data.result.success == 1) {
					$('#div-message').addClass('alert-info');
					$('#user-idtype').val(data.result.objTypeUser.idtype_user);
					$('#description-type-bck').val(data.result.objTypeUser.description);
					$('#description-type').val(data.result.objTypeUser.description);
					$('#btn-guardar-type-user').html(data.result.nameboton);

					//Actualizar TableUserType
					$('#content-table-type-user').html(data.result.datatable);
				} else {
					$('#div-message').addClass('alert-danger');
				}
				$('#div-alert').css('display', 'block');
			},
			error: function(xhr, status){
				alert('Ha ocurrido un error...');
			},
			complete: function(xhr, status){
				fcnFinishLoading(); //Finaliza el div Loading
				setTimeout(function(){ $('#div-alert').css('display', 'none'); }, 5000); //Finaliza el mensaje de alerta
			}
		});
	});


	$(document).on('click', '.btn-product-edit', function(){

		var idproduct = $(this).attr('idproduct');

		$.ajax({
			async: true,
			url: './inicio/updateProduct/'+idproduct+'/',
			cache: false,
			data: { },
			type: 'POST',
			dataType: 'json',
			beforeSend: function(){
				fcnLoading(); //Inicializa el div Loading
			},
			success: function(data){
				// Función que Limpia los campos
				fcnClearInput('#form-product');

				console.log(data);
				$('.text-message').html(data.result.message);
				$('#div-message').removeClass('alert-info alert-danger');
				if (data.result.success == 1) {
					$('#div-message').addClass('alert-info');
					$('#product-id').val(data.result.objProduct.idproduct);
					$('#product-name-bck').val(data.result.objProduct.product_name);
					$('#product-name').val(data.result.objProduct.product_name);
					$('input:radio[name=radio-product]').each(function(index, value){
						if ($(this).val() == data.result.objProduct.product_icono) {
							$(this).prop('checked', true);
						} else {
							$(this).prop('checked', false);
						}
					});
					$('#btn-guardar-product').html(data.result.nameboton);

					// Actualizar TableProduct
					$('#content-table-product').html(data.result.datatable);
					// Actualiza el MENU PRODUCT
					//$('#menu-product').html(data.result.menuproduct);
					//$('#menu-admin').html(data.result.menuadmin);
				} else {
					$('#div-message').addClass('alert-danger');
				}
				$('#div-alert').css('display', 'block');

				// Refresca el JS del MENU
				//init_sidebar();
			},
			error: function(xhr, status){
				alert('Ha ocurrido un error...');
			},
			complete: function(xhr, status){
				fcnFinishLoading(); //Finaliza el div Loading
				setTimeout(function(){ $('#div-alert').css('display', 'none'); }, 5000); //Finaliza el mensaje de alerta
			}
		});
	});


	$(document).on('click', '.btn-version-edit', function(){

		var idversion = $(this).attr('idversion');

		$.ajax({
			async: true,
			url: './page/updateVersion/'+idversion+'/',
			cache: false,
			data: { },
			type: 'POST',
			dataType: 'json',
			beforeSend: function(){
				fcnLoading(); //Inicializa el div Loading
			},
			success: function(data){
				// Función que Limpia los campos
				fcnClearInput('#form-version');

				console.log(data);
				$('.text-message').html(data.result.message);
				$('#div-message').removeClass('alert-info alert-danger');
				if (data.result.success == 1) {
					$('#div-message').addClass('alert-info');
					$('#version-id').val(data.result.objVersion.idversion);
					$('#version-description-bck').val(data.result.objVersion.version_description);
					$('#version-description').val(data.result.objVersion.version_description);
					$('#btn-guardar-version').html(data.result.nameboton);

					//Actualizar TableProduct
					$('#content-table-version').html(data.result.datatable);
				} else {
					$('#div-message').addClass('alert-danger');
				}
				$('#div-alert').css('display', 'block');
			},
			error: function(xhr, status){
				alert('Ha ocurrido un error...');
			},
			complete: function(xhr, status){
				fcnFinishLoading(); //Finaliza el div Loading
				setTimeout(function(){ $('#div-alert').css('display', 'none'); }, 5000); //Finaliza el mensaje de alerta
			}
		});
	});


	$(document).on('click', '.btn-version-product-edit', function(){

		var idproduct = $(this).attr('idproduct'),
			idversion = $(this).attr('idversion');

		$.ajax({
			async: true,
			url: './page/updateVersionProduct/'+idproduct+'/'+idversion+'/',
			cache: false,
			data: { },
			type: 'POST',
			dataType: 'json',
			beforeSend: function(){
				fcnLoading(); //Inicializa el div Loading
			},
			success: function(data){
				// Función que Limpia los campos
				fcnClearInput('#form-version-product');

				console.log(data);
				$('.text-message').html(data.result.message);
				$('#div-message').removeClass('alert-info alert-danger');
				if (data.result.success == 1) {
					$('#div-message').addClass('alert-info');
					$('#idproduct_bck').val(data.result.objVersionProduct.idproduct);
					$('#idversion_bck').val(data.result.objVersionProduct.idversion);
					$('#idproduct_pv').val(data.result.objVersionProduct.idproduct);
					$('#idversion_pv').val(data.result.objVersionProduct.idversion);
					$('#registry-description').val(data.result.objVersionProduct.registry_description);
					$('#btn-guardar-version-product').html(data.result.nameboton);

					//Actualizar TableVersionProduct
					//$('#content-table-version-product').html(data.result.datatable);
				} else {
					$('#div-message').addClass('alert-danger');
				}
				$('#div-alert').css('display', 'block');
			},
			error: function(xhr, status){
				alert('Ha ocurrido un error...');
			},
			complete: function(xhr, status){
				fcnFinishLoading(); //Finaliza el div Loading
				setTimeout(function(){ $('#div-alert').css('display', 'none'); }, 5000); //Finaliza el mensaje de alerta
			}
		});
	});
	


	/********************     REMOVE    ********************/

	$(document).on('click', '.btn-business-remove', function(){

		var idbusiness = $(this).attr('idbusiness');

		$.ajax({
			async: true,
			url: './page/deleteBusiness/'+idbusiness+'/',
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
					
					//Actualizar TableBusiness
					$('#content-table-business').html(data.result.datatable);
				} else {
					$('#div-message').addClass('alert-danger');
				}
				$('#div-alert').css('display', 'block');
				$('#form-business')[0].reset();
			},
			error: function(xhr, status){
				alert('Ha ocurrido un error...');
			},
			complete: function(xhr, status){
				fcnFinishLoading(); //Finaliza el div Loading
				setTimeout(function(){ $('#div-alert').css('display', 'none'); }, 5000); //Finaliza el mensaje de alerta
			}
		});
	});

	$(document).on('click', '.btn-user-remove', function(){

		var iduser = $(this).attr('iduser');

		$.ajax({
			async: true,
			url: './page/deleteUser/'+iduser+'/',
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
					
					//Actualizar TableUser
					$('#content-table-user').html(data.result.datatable);
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
	});


	$(document).on('click', '.btn-user-type-remove', function(){

		var idtype_user = $(this).attr('idtypeuser');

		$.ajax({
			async: true,
			url: './page/deleteTypeUser/'+idtype_user+'/',
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

					//Actualizar TableUser
					$('#content-table-type-user').html(data.result.datatable);
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
	});


	$(document).on('click', '.btn-product-remove', function(){

		var idproduct = $(this).attr('idproduct');

		$.ajax({
			async: true,
			url: './inicio/deleteProduct/'+idproduct+'/',
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

					// Actualizar TableProduct
					$('#content-table-product').html(data.result.datatable);
					// Actualiza el MENU PRODUCT
					$('#menu-product').html(data.result.menuproduct);
					$('#menu-admin').html(data.result.menuadmin);
				} else {
					$('#div-message').addClass('alert-danger');
				}
				$('#div-alert').css('display', 'block');
				$('#form-product')[0].reset();

				// Refresca el JS del MENU
				init_sidebar();
			},
			error: function(xhr, status){
				alert('Ha ocurrido un error...');
			},
			complete: function(xhr, status){
				fcnFinishLoading(); //Finaliza el div Loading
				setTimeout(function(){ $('#div-alert').css('display', 'none'); }, 5000); //Finaliza el mensaje de alerta
			}
		});
	});


	$(document).on('click', '.btn-version-remove', function(){

		var idversion = $(this).attr('idversion');

		$.ajax({
			async: true,
			url: './page/deleteVersion/'+idversion+'/',
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
					
					//Actualizar TableVersion
					$('#content-table-version').html(data.result.datatable);
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
	});


	$(document).on('click', '.btn-version-product-remove', function(){

		var idproduct = $(this).attr('idproduct'),
			idversion = $(this).attr('idversion');

		$.ajax({
			async: true,
			url: './page/deleteVersionProduct/'+idproduct+'/'+idversion+'/',
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
					
					//Actualizar TableVersionProduct
					$('#content-table-version-product').html(data.result.datatable);
				} else {
					$('#div-message').addClass('alert-danger');
				}
				$('#div-alert').css('display', 'block');
				$('#form-version-product')[0].reset();
			},
			error: function(xhr, status){
				alert('Ha ocurrido un error...');
			},
			complete: function(xhr, status){
				fcnFinishLoading(); //Finaliza el div Loading
				setTimeout(function(){ $('#div-alert').css('display', 'none'); }, 5000); //Finaliza el mensaje de alerta
			}
		});
	});


	/********************    OTROS    ********************/

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
			beforeSend: function(){
				fcnLoading(); //Inicializa el div Loading
			},
			success: function(data){
				console.log(data);
				$('#idversion-product').html(data);
			},
			error: function(xhr, status){
				alert('Ha ocurrido un error...');
			},
			complete: function(xhr, status){
				fcnFinishLoading(); //Finaliza el div Loading
			}
		});

	});


	$(document).on('change', '#idproduct_pv', function(){

		var idproduct_pv = $(this).val(),
			idversion_pv = $('#idversion_pv').val(),
			text_product = '',
			text_version = '';
		
		if (idproduct_pv != 0) text_product = $(this).find('option:selected').html();
		if (idversion_pv != 0) text_version = $('#idversion_pv').find('option:selected').html();

		$('#registry-description').val(text_product+' '+text_version);
	});


	$(document).on('change', '#idversion_pv', function(){

		var idproduct_pv = $('#idproduct_pv').val(),
			idversion_pv = $(this).val(),
			text_product = '',
			text_version = '';
		
		if (idproduct_pv != 0) text_product = $('#idproduct_pv').find('option:selected').html();
		if (idversion_pv != 0) text_version = $(this).find('option:selected').html();

		$('#registry-description').val(text_product+' '+text_version);
	});


	$(document).on('input', '#business-name', function(){

		var business_name = fcnValidateExpReg($(this).val(), exp_alphanumeric);
    	$(this).val(business_name);

		$.ajax({
			async: true,
			url: './ajax/validateBusiness/'+business_name+'/',
			cache: false,
			data: { },
			type: 'POST',
			dataType: 'json',
			beforeSend: function(){
			},
			success: function(data){
				if (data.result.success) {
					$('#business-name').addClass('parsley-error').attr('data-parsley-id', 2).parent().append('<ul class="parsley-errors-list filled" id="parsley-id-2"><li class="parsley-required">'+data.result.message+'</li></ul>');

					var business_name = $('#business-name').val().toLowerCase(),
						business_name_bck = $('#business-name-bck').val().toLowerCase();

					if (business_name == business_name_bck && business_name != '') {
						$('#business-name').removeClass('parsley-error');
						$("#parsley-id-2").remove();
					}
				} else {
					$('#business-name').removeClass('parsley-error');
					$("#parsley-id-2").remove();

					if ($('#business-name').val().length == 0) {
						$('#business-name').addClass('parsley-error').attr('data-parsley-id', 2).parent().append('<ul class="parsley-errors-list filled" id="parsley-id-2"><li class="parsley-required">'+fcnReturnLanguage('campo','')+'</li></ul>');
					}
				}
			},
			error: function(xhr, status){
				alert('Ha ocurrido un error...');
			},
			complete: function(xhr, status){
			}
		});
	});
	

	$(document).on('input', '#user-name', function(){

		var user_name = fcnValidateExpReg($(this).val(), exp_letras);
    	$(this).val(user_name);

		$.ajax({
			async: true,
			url: './user/validateUser/'+user_name+'/',
			cache: false,
			data: { },
			type: 'POST',
			dataType: 'json',
			beforeSend: function(){
			},
			success: function(data){
				if (data.result.success) {
					$('#user-name').addClass('parsley-error').attr('data-parsley-id', 2).parent().append('<ul class="parsley-errors-list filled" id="parsley-id-2"><li class="parsley-required">'+data.result.message+'</li></ul>');

					var user_name = $('#user-name').val().toLowerCase(),
						user_name_bck = $('#user-name-bck').val().toLowerCase();

					if (user_name == user_name_bck && user_name != '') {
						$('#user-name').removeClass('parsley-error');
						$("#parsley-id-2").remove();
					}
				} else {
					$('#user-name').removeClass('parsley-error');
					$("#parsley-id-2").remove();

					if ($('#user-name').val().length == 0) {
						$('#user-name').addClass('parsley-error').attr('data-parsley-id', 2).parent().append('<ul class="parsley-errors-list filled" id="parsley-id-2"><li class="parsley-required">'+fcnReturnLanguage('campo','')+'</li></ul>');
					}
				}
			},
			error: function(xhr, status){
				alert('Ha ocurrido un error...');
			},
			complete: function(xhr, status){
			}
		});
	});


	$(document).on('input', '#product-name', function(){

		var product_name = fcnValidateExpReg($(this).val(), exp_alphanumeric);
    	$(this).val(product_name);

		$.ajax({
			async: true,
			url: './ajax/validateProduct/'+product_name+'/',
			cache: false,
			data: { },
			type: 'POST',
			dataType: 'json',
			beforeSend: function(){
			},
			success: function(data){
				if (data.result.success) {
					$('#product-name').addClass('parsley-error').attr('data-parsley-id', 2).parent().append('<ul class="parsley-errors-list filled" id="parsley-id-2"><li class="parsley-required">'+data.result.message+'</li></ul>');

					var product_name = $('#product-name').val().toLowerCase(),
						product_name_bck = $('#product-name-bck').val().toLowerCase();

					if (product_name == product_name_bck && product_name != '') {
						$('#product-name').removeClass('parsley-error');
						$("#parsley-id-2").remove();
					}
				} else {
					$('#product-name').removeClass('parsley-error');
					$("#parsley-id-2").remove();

					if ($('#product-name').val().length == 0) {
						$('#product-name').addClass('parsley-error').attr('data-parsley-id', 2).parent().append('<ul class="parsley-errors-list filled" id="parsley-id-2"><li class="parsley-required">'+fcnReturnLanguage('campo','')+'</li></ul>');
					}
				}
			},
			error: function(xhr, status){
				alert('Ha ocurrido un error...');
			},
			complete: function(xhr, status){
			}
		});
	});


	$(document).on('input', '#version-description', function(){

		var version_description = fcnValidateExpReg($(this).val(), exp_decimal);
    	$(this).val(version_description);

		$.ajax({
			async: true,
			url: './ajax/validateVersion/'+version_description+'/',
			cache: false,
			data: { },
			type: 'POST',
			dataType: 'json',
			beforeSend: function(){
			},
			success: function(data){
				if (data.result.success) {
					$('#version-description').addClass('parsley-error').attr('data-parsley-id', 2).parent().append('<ul class="parsley-errors-list filled" id="parsley-id-2"><li class="parsley-required">'+data.result.message+'</li></ul>');

					var version_description = $('#version-description').val().toLowerCase(),
						version_description_bck = $('#version-description-bck').val().toLowerCase();

					if (version_description == version_description_bck && version_description != '') {
						$('#version-description').removeClass('parsley-error');
						$("#parsley-id-2").remove();
					}
				} else {
					$('#version-description').removeClass('parsley-error');
					$("#parsley-id-2").remove();

					if ($('#version-description').val().length == 0) {
						$('#version-description').addClass('parsley-error').attr('data-parsley-id', 2).parent().append('<ul class="parsley-errors-list filled" id="parsley-id-2"><li class="parsley-required">'+fcnReturnLanguage('campo','')+'</li></ul>');
					}
				}
			},
			error: function(xhr, status){
				alert('Ha ocurrido un error...');
			},
			complete: function(xhr, status){
			}
		});
	});


	$(document).on('input', '#description-type', function(){

		var description = fcnValidateExpReg($(this).val(), exp_letras);
    	$(this).val(description);

		$.ajax({
			async: true,
			url: './user/validateTypeUser/'+description+'/',
			cache: false,
			data: { },
			type: 'POST',
			dataType: 'json',
			beforeSend: function(){
			},
			success: function(data){
				if (data.result.success) {
					$('#description-type').addClass('parsley-error').attr('data-parsley-id', 2).parent().append('<ul class="parsley-errors-list filled" id="parsley-id-2"><li class="parsley-required">'+data.result.message+'</li></ul>');

					var description_type_bck = $('#description-type-bck').val().toLowerCase(),
						description_type = $('#description-type').val().toLowerCase();

					if (description_type == description_type_bck && description_type != '') {
						$('#description-type').removeClass('parsley-error');
						$("#parsley-id-2").remove();
					}
				} else {
					$('#description-type').removeClass('parsley-error');
					$("#parsley-id-2").remove();

					if ($('#description-type').val().length == 0) {
						$('#description-type').addClass('parsley-error').attr('data-parsley-id', 2).parent().append('<ul class="parsley-errors-list filled" id="parsley-id-2"><li class="parsley-required">'+fcnReturnLanguage('campo','')+'</li></ul>');
					}
				}
			},
			error: function(xhr, status){
				alert('Ha ocurrido un error...');
			},
			complete: function(xhr, status){
			}
		});
	});

	
	$(document).on('input', '#ruc', function(){
		
		var numeros = fcnValidateExpReg($(this).val(), exp_numeros);
    	$(this).val(numeros);
    });


	$(document).on('input', 'input[type=password]', function(){
		
		var password = fcnValidateExpReg($(this).val(), exp_password);
    	$(this).val(password);
    });


	$(document).on('click', '#btn-reset', function(){

		var idform = $(this).parents('form').attr('id');
		$(this).parent().find('.btn-success').html('Guardar');
		$('#'+idform)[0].reset();
		fcnClearInput('#'+idform);
	});


	$(document).on('click', '.info-recent', function(){

		var version = $(this).attr('ver'),
			pagina = $(this).parents('.widget_tally_box').attr('page'),
			servicio = $(this).parents('.widget_tally_box').attr('ser');

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
				// Cambia de Idioma
				fncChangeLanguage();
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


	$(document).on('click', '.lang-main', function(){

		var lang = 'en',
			idbusiness = $(this).attr('idbusiness');

		if($(this).find('.lang-child').hasClass('en')){
			$(this).find('.lang-child').removeClass('en').addClass('es').animate({left: '20px'}, "slow");
			lang = 'es';
			fcnLanguage(idbusiness, lang);
		} else {
			$(this).find('.lang-child').removeClass('es').addClass('en').animate({left: '0px'}, "slow");
			lang = 'en';
			fcnLanguage(idbusiness, lang);
		}
	});


	/*************** OTRAS FUNCIONES ***************/

	function fcnLoading(){
		
		$('.nav-md').append('<div class="div-loading"><img class="img-loading" src="./Static/images/loading.gif" alt="Loading"></div>');
	}


	function fcnFinishLoading(){

		$('.div-loading').remove();
	}


	function fcnClearInput(form){

		$(form).find('.form-control').removeClass('parsley-error');
		$('.parsley-errors-list').remove();
	}


	function fcnValidateExpReg(text, exp_reg){

		var text_macth = '';
	    for (var i = 0; i < text.length; i++) {
	        if (text[i].match(exp_reg)) {
	            text_macth+=text[i];
	        }
	    }

	    return text_macth;
	}


	function escapeJSON(string) {

	    return string.replace(/\\/g, '\\\\').
	        replace(/\u0008/g, '\\b').
	        replace(/\t/g, '\\t').
	        replace(/\n/g, '\\n').
	        replace(/\f/g, '\\f').
	        replace(/\r/g, '\\r').
	        replace(/'/g, '\\\'').
	        replace(/"/g, '\\"');
	}


	function existeUrl(url) {
		var http = new XMLHttpRequest();
		http.open('HEAD', url, false);
		http.send();
		return http.status!=404;
	}


	function fcnLanguage(idbusiness, lang){

		console.log(idbusiness, lang);
		
		$.ajax({
			async: true,
			url: './ajax/changeLanguage/'+idbusiness+'/'+lang+'/',
			cache: false,
			data: { },
			type: 'POST',
			dataType: 'json',
			beforeSend: function(){
				fcnLoading(); //Inicializa el div Loading
			},
			success: function(data){
				console.log(data);
				window.location.href = './';
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

	function fcnReturnLanguage(indice, texto){

		var msgSpanish = new Object();
			msgSpanish.pdf = 'Ocurrió un error al generar el PDF, intentelo de nuevo.';
			msgSpanish.campo = 'Este campo es necesario.';
			msgSpanish.pass = 'La contraseña no coincide.';
			msgSpanish.url = 'URL inválido, no cumple el formato: Ej. <strong>"http://www.youtube.com/xxx"</strong>.';
			msgSpanish.file = 'El tamaño del archivo no debe ser mayor a <strong>"'+texto+'MB"</strong>.';
			msgSpanish.upload = 'El archivo <strong>"'+texto+'"</strong> ya existe.';

		var msgEnglish = new Object();
			msgEnglish.pdf = 'There was an error generating the PDF, please try again.';
			msgEnglish.campo = 'This field is required.';
			msgEnglish.pass = 'Password does not match.';
			msgEnglish.url = 'Invalid URL, does not meet the format: Eg. <strong>"http://www.youtube.com/xxx"</strong>.';
			msgEnglish.file = 'File size should not exceed <strong>"'+texto+'MB"</strong>.';
			msgEnglish.upload = 'The <strong>"'+texto+'"</strong> file already exists.';
			
		var msg = '';
		if ($('.lang-child').hasClass('en')) {
			msg = msgEnglish[indice];
		} else {
			msg = msgSpanish[indice];
		}

		return msg;
	}

});
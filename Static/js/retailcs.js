$(document).ready(function(){

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
			var iduser = $('#user-id').val(),
				user_name = $('#user-name').val(),
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
				$(id).addClass('parsley-error').parent().append('<ul class="parsley-errors-list filled" id="parsley-id-'+parsley+'"><li class="parsley-required">Este campo es necesario.</li></ul>');
			}
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
					$(id).addClass('parsley-error').parent().append('<ul class="parsley-errors-list filled" id="parsley-id-'+index+'"><li class="parsley-required">Este campo es necesario.</li></ul>');
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
				//url: './page/insertProduct/'+product_id+'/'+product_name+'/'+product_icono+'/',
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
					$(id).addClass('parsley-error').parent().append('<ul class="parsley-errors-list filled" id="parsley-id-'+index+'"><li class="parsley-required">Este campo es necesario.</li></ul>');
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
					$(id).addClass('parsley-error').parent().append('<ul class="parsley-errors-list filled" id="parsley-id-'+index+'"><li class="parsley-required">Este campo es necesario.</li></ul>');
				}
			}
		});

		$(a).find('.parsley-errors-list').each(function(index, value){
			cont++;
		});
		
		if (cont <= 0) {
			var data = {};
			data['idproduct_pv'] = $('#idproduct_pv').val();
			data['idversion_pv'] = $('#idversion_pv').val();
			data['registry_description'] = $('#registry-description').val();

			var data_json = JSON.stringify(data);
	
			$.ajax({
				async: true,
				url: './page/insertVersionProduct/'+data_json+'/',
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
					$('#user-name').val(data.result.objUser.user_name);
					$('#password').val(data.result.objUser.user_pass);
					$('#repeat-password').val(data.result.objUser.user_pass);
					$('#business-name').val(data.result.objUser.idbusiness);
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
			//url: './page/updateProduct/'+idproduct+'/',
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


	/*
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
					$('#idproduct_pv').val(data.result.objVersionProduct.idproduct);
					$('#idversion_pv').val(data.result.objVersionProduct.idversion);
					$('#registry-description').val(data.result.objVersionProduct.registry_description);
					$('#btn-guardar-version').html(data.result.nameboton);

					//Actualizar TableVersionProduct
					$('#content-table-version-product').html(data.result.datatable);
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
	*/


	/********************     REMOVE    ********************/

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
			//url: './page/deleteProduct/'+idproduct+'/',
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


	$(document).on('keyup', '#user-name', function(){

		var user_name = $(this).val();

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
					$('#user-name').addClass('parsley-error').attr('data-parsley-id', 1).parent().append('<ul class="parsley-errors-list filled" id="parsley-id-1"><li class="parsley-required">'+data.result.message+'</li></ul>');

					var user_id = $('#user-id').val();
					if (user_id.length > 0) {
						$('#user-name').removeClass('parsley-error');
						$("#parsley-id-1").remove();
					}
				} else {
					$('#user-name').removeClass('parsley-error');
					$("#parsley-id-1").remove();

					if ($('#user-name').val().length == 0) {
						$('#user-name').addClass('parsley-error').attr('data-parsley-id', 1).parent().append('<ul class="parsley-errors-list filled" id="parsley-id-1"><li class="parsley-required">Este campo es necesario.</li></ul>');
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


	$(document).on('keyup', '#product-name', function(){

		var product_name = $(this).val();

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
					$('#product-name').addClass('parsley-error').attr('data-parsley-id', 1).parent().append('<ul class="parsley-errors-list filled" id="parsley-id-1"><li class="parsley-required">'+data.result.message+'</li></ul>');

					var product_id = $('#product-id').val();
					if (product_id.length > 0) {
						$('#product-name').removeClass('parsley-error');
						$("#parsley-id-1").remove();
					}
				} else {
					$('#product-name').removeClass('parsley-error');
					$("#parsley-id-1").remove();

					if ($('#product-name').val().length == 0) {
						$('#product-name').addClass('parsley-error').attr('data-parsley-id', 1).parent().append('<ul class="parsley-errors-list filled" id="parsley-id-1"><li class="parsley-required">Este campo es necesario.</li></ul>');
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


	$(document).on('keyup', '#version-description', function(){

		var version_description = $(this).val();

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
					$('#version-description').addClass('parsley-error').attr('data-parsley-id', 1).parent().append('<ul class="parsley-errors-list filled" id="parsley-id-1"><li class="parsley-required">'+data.result.message+'</li></ul>');

					var version_id = $('#version-id').val();
					if (version_id.length > 0) {
						$('#version-description').removeClass('parsley-error');
						$("#parsley-id-1").remove();
					}
				} else {
					$('#version-description').removeClass('parsley-error');
					$("#parsley-id-1").remove();

					if ($('#version-description').val().length == 0) {
						$('#version-description').addClass('parsley-error').attr('data-parsley-id', 1).parent().append('<ul class="parsley-errors-list filled" id="parsley-id-1"><li class="parsley-required">Este campo es necesario.</li></ul>');
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


	$(document).on('keyup', '#description-type', function(){

		var description = $(this).val();

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
					$('#description-type').addClass('parsley-error').attr('data-parsley-id', 1).parent().append('<ul class="parsley-errors-list filled" id="parsley-id-1"><li class="parsley-required">'+data.result.message+'</li></ul>');

					var user_idtype = $('#user-idtype').val();
					if (user_idtype.length > 0) {
						$('#description-type').removeClass('parsley-error');
						$("#parsley-id-1").remove();
					}
				} else {
					$('#description-type').removeClass('parsley-error');
					$("#parsley-id-1").remove();

					if ($('#description-type').val().length == 0) {
						$('#description-type').addClass('parsley-error').attr('data-parsley-id', 1).parent().append('<ul class="parsley-errors-list filled" id="parsley-id-1"><li class="parsley-required">Este campo es necesario.</li></ul>');
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

});
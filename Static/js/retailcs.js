$(document).ready(function(){

	$('.net-servicio').on('click', function(){

		$('.child_menu li').removeClass('active');
		$(this).parent().addClass('active');

		var pagina = $(this).attr('page');
		var servicio = $(this).attr('ser');

		//$('#principal').html(page+' '+ser);
		//$('#principal').css('background', 'blue');

		$.ajax({
			async: true,
			url: 'extranet/page/service/'+pagina+'/'+servicio+'/',
			cache: false,
			data: {},
			type: 'GET',
			beforeSend: function(){

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

			}
		});

		return false;
	});

	$(document).on('click', '.close-link', function(){
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

});
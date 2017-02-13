$(document).ready(function(){

	$('.net-servicio').on('click', function(){

		$('.child_menu li').removeClass('active');
		$(this).parent().addClass('active');

		var page = $(this).attr('page');
		var ser = $(this).attr('ser');

		$('#principal').html(page+' '+ser);

		return false;
	});



});
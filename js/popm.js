$(document).ready(function(){
	$('#tab-switcher a').click(function(e){
		$('#tab-switcher li.active').removeClass('active');
		$(this).parent().addClass('active');
		var sel = "#" + ($(this).attr('title')) + "";
		$(".tab-content").addClass('bh');
		$(sel).removeClass('bh');
	});
	$('.vt-edit, .vt-insert').click(function(e){
		$(this).parents().filter('.view-table').addClass('column').addClass('left')
			.siblings().filter('.right').removeClass('bh');
		$(this).parents().filter('.view-table').find('tr').removeClass('highlight');
		$(this).parents().filter('tr').addClass('highlight');
		$(this).parents().filter('form').find('#tm-first_name').attr('value',
			$(this).parents().filter('tr').children().eq(2).text());
		$(this).parents().filter('form').find('#tm-last_name').attr('value',
			$(this).parents().filter('tr').children().eq(3).text());
		$(this).parents().filter('form').find('#tm-email').attr('value',
			$(this).parents().filter('tr').children().eq(4).text());
		$(this).parents().filter('form').find('#tm-role').val(
			$(this).parents().filter('tr').children().eq(1).text());
	});
});
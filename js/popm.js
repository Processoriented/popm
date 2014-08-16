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
	$('#sb_nav a').click(function(e){
		e.preventDefault();
		$('#sb_nav li.highlight').removeClass('highlight');
		$(this).parent().addClass('highlight');
	});
	$('#action-switcher a').click(function(e){
		$('#sel_rec').addClass('bh');
		$('.speTab').addClass('bh');
		$('.genTab').removeClass('bh');
		$('#tab-switcher li.active').removeClass('active');
		$('#gtdft').addClass('active');
		$(".tab-content").addClass('bh');
		$('#dashboard').removeClass('bh');
	});
	$('#uLstPr a').click(function(e){
		$('#sel_rec').removeClass('bh');
		$('#sel_rec_title').text($(this).text());
		$('#sel_rec .bd p').text($(this).siblings().filter('span').text());
		$('.speTab').removeClass('bh');
		$('.genTab').addClass('bh');
		$('#tab-switcher li.active').removeClass('active');
		$('#spdft').addClass('active');
		$(".tab-content").addClass('bh');
		$('#overview').removeClass('bh');
	});
});
function check_jqv(elem)
{
	$(".alert-dismissible", elem).hide();
	var ok = true;
	$(".req input, .req textarea, .req select", elem).each(function() {
		if(!$(this).val() || ($(this).val()==0 && $(this).attr("type")!= "select-one") || ($(this).attr("type")=="checkbox" && !$(this).is(':checked')) || $(this).attr("title") == $(this).val()) {
			$(this).parent().addClass("has-error"); 
			ok =  false;
		} else $(this).parent().removeClass("has-error"); 
	});
	if(!ok)	{
		$(".erori", elem).html('<div class="alert alert-danger text_center" style="margin-top:10px;margin-bottom:0px;" role="alert">Completeaza toate campurile obligatorii</div>');
	} else {
		$("input[type=submit], input[type=image]", elem).hide();
	}
	return ok;
}

$(document).ready(function() {

	$(document.body).on('submit','form.jqv', function() {
		return check_jqv(this);
	})
});
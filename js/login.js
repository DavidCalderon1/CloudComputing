// JavaScript Document
$(document).ready(function () {
$('.active-links').click(function () {
        if ($('#signin-dropdown').is(":visible")) {
            $('#signin-dropdown').hide()
			$('#session').removeClass('active');
        } else {
            $('#signin-dropdown').show()
			$('#session').addClass('active');
        }
		return false;
    });
	$('#signin-dropdown').click(function(e) {
        e.stopPropagation();
    });
    $(document).click(function() {
        $('#signin-dropdown').hide();
		$('#session').removeClass('active');
    });
});     

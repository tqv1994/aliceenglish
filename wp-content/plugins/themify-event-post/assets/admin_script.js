
jQuery( function( $ ){

	var check_ticket_link = function() {
	    var ticket_link = $(this).val();
    	if (ticket_link == '') {
    	    $('.themify-event-ticket').hide();
    	} else {
    	    $('.themify-event-ticket').fadeIn();
    	}
	};
	
	$('#buy_tickets').on('change', check_ticket_link).trigger('change');

} );

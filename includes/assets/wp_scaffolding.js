(function($) {

	"use strict";

	$(document).ready(function() {

		$('#expanded_options_toggle').on( 'click', function() {
			$(this + ' i').toggleClass("dashicons-arrow-right dashicons-arrow-down");
			$('#expanded_options .form-table').toggle();
		});

		$('#singular').on( 'keyup', function() {
			var singular_name = $('#singular').val();
			var last_char = singular_name.slice(-1);

			if( 's' != last_char && '' != singular_name ) {
				$('#plural').val( singular_name + 's' );
			} else if( '' != singular_name ) {
				$('#plural').val( singular_name );
			} else {
				$('#plural').val( '' );
			}
		});

	});

})(jQuery);
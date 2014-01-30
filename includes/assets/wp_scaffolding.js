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

			updatePreview( singular_name );

			if( 's' != last_char && '' != singular_name ) {
				$('#plural').val( singular_name + 's' );
			} else if( '' != singular_name ) {
				$('#plural').val( singular_name );
			} else {
				$('#plural').val( '' );
				hidePreview();
			}
		});

		$('#has_archive').on( 'change', function() {
			$('.archive-view').toggle();
			$('.archivecontroller').toggle();
		});

		function updatePreview( singular_name ) {

			var lowercase_name = singular_name.toLowerCase()
			var ucfirst_name = lowercase_name.charAt(0).toUpperCase() + lowercase_name.slice(1);
			var archive = $('.archive-view').is(":checked");

			$('#files_to_create').show();

			$('.taxonomy span').html( lowercase_name + '.php' );
			$('.posttype span').html( lowercase_name + '.php' );
			$('.controller span').html( 'Single' + ucfirst_name + '.php' );
			$('.archivecontroller span').html( 'Archive' + ucfirst_name + '.php' );
			$('.single-view span').html( 'single-' + lowercase_name + '.php' );
			$('.archive-view span').html( 'archive-' + lowercase_name + '.php' );
		}

		function hidePreview() {
			$('#files_to_create').hide();
		}

	});

})(jQuery);
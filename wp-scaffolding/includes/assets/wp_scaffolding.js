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

			var name = singular_name.toLowerCase()
			var archive = $('.archive-view').is(":checked");

			$('#files_to_create').show();

			$('.taxonomy span').html( name + '.php' );
			$('.posttype span').html( name + '.php' );
			$('.controller span').html( 'class-single-' + name + '.php' );
			$('.archivecontroller span').html( 'class-archive-' + name + '.php' );
			$('.single-view span').html( 'single-' + name + '.php' );
			$('.archive-view span').html( 'archive-' + name + '.php' );
		}

		function hidePreview() {
			$('#files_to_create').hide();
		}

	});

})(jQuery);
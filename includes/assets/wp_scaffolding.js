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

		$('#ctrlr_type').on( 'change', function() {
			var type = $(this).val();

			switch( type ) {
				case 'pt':
					$('#taxonomy').val('');
					$('#taxonomy_term').val('');
					$('.taxonomy_tr').hide();
					$('.taxonomy_term_tr').hide();

					$('.posttype_tr').show();
					$('.slug_tr').show();

					break;

				case 'tax':
					$('#posttype').val('');
					$('#slug').val('');
					$('.posttype_tr').hide();
					$('.slug_tr').hide();

					$('.taxonomy_tr').show();
					$('.taxonomy_term_tr').show();

					break;

				case 'slug':
					$('#taxonomy').val('');
					$('#taxonomy_term').val('');
					$('#posttype').val('');
					$('.taxonomy_tr').hide();
					$('.taxonomy_term_tr').hide();
					$('.posttype_tr').hide();

					$('.slug_tr').show();

					break;
			}
		});

		$(document).on( 'change', '#taxonomy', function() {

			var taxonomy = $(this).val();

			$.post(
				ajaxurl,
				{
					// wp ajax action
					action	: 'scaffolding_get_terms',

					tax		: taxonomy,

					nonce	: $('#_wpnonce').val()
				},
				function( response ) {
					$('#taxonomy_term').html('<option value=""></option>');

					var terms = JSON.parse(response);
					$.each(terms, function() {
						$('#taxonomy_term').append( '<option value="' + this.slug + '">' + this.name + '</option>' );
					});
				}
			);
		});

		function updatePreview( singular_name ) {

			var lowercase_name = singular_name.toLowerCase()
			var ucfirst_name = lowercase_name.charAt(0).toUpperCase() + lowercase_name.slice(1);

			$('#files_to_create').show();

			$('.taxonomy span').html( lowercase_name + '.php' );
			$('.posttype span').html( lowercase_name + '.php' );
			$('.controller span').html( ucfirst_name + 'Fabric.php' );
			$('.single-view span').html( 'single-' + lowercase_name + '.php' );
			$('.archive-view span').html( 'archive-' + lowercase_name + '.php' );
		}

		function hidePreview() {
			$('#files_to_create').hide();
		}

	});

})(jQuery);
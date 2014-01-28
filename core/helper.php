<?php

function WPSCAFF_check_requirements() {

	$viewing_errors = false;
	if( isset( $_GET['render'] ) && 'error' == $_GET['render'] )
		$viewing_errors = true;

	if ( !defined('FABRIC_VIEWS') || !defined('FABRIC_CPT_DIR') || !defined('FABRIC_TAX_DIR') || !defined('FABRIC_CONTROLLERS') ){
		wp_redirect( admin_url( '/tools.php?page=wp-scaffolding&render=error&fabric=1' ) ); exit;
	}

	$errors = array();
	$paths = array(
		'views' 		=> FABRIC_VIEWS,
		'posttypes'		=> FABRIC_CPT_DIR,
		'taxonomy'		=> FABRIC_TAX_DIR,
		'controllers' 	=> FABRIC_CONTROLLERS
	);

	foreach( $paths as $type => $path )
	{
		if( !is_dir( $path ) ) {
			$errors[$type] = 1;
			continue;
		}

		if( !is_writable( $path ) ) {
			$errors[$type] = 2;
		}
	}

	if( $viewing_errors ) {
		$errors_changed = WPSCAFF_errors_changed( $_GET, $errors );
	}

	if(
		( !empty( $errors ) && $viewing_errors && $errors_changed ) ||
		( !empty( $errors ) && !$viewing_errors )
	) {
		$errors_string = http_build_query( $errors );
		wp_redirect( admin_url( '/tools.php?page=wp-scaffolding&render=error&' . $errors_string ) ); exit;
	}

	if( $viewing_errors && empty( $errors ) ) {
		wp_redirect( admin_url( '/tools.php?page=wp-scaffolding' ) ); exit;
	}

}
add_action( 'load-tools_page_wp-scaffolding', 'WPSCAFF_check_requirements' );

function WPSCAFF_errors_changed( $base_errors, $new_errors ) {

	unset( $base_errors['page'] );
	unset( $base_errors['render'] );
	$changed = false;

	foreach( $new_errors as $error => $value )
	{
		if( !isset( $base_errors[ $error ] ) || $base_errors[ $error ] != $value )
			return true;

		if( isset( $base_errors[ $error ] ) && $base_errors[ $error ] == $value )
			unset( $base_errors[ $error ] );
	}

	if( !empty( $base_errors ) )
		return true;

	return $changed;
}

function WPSCAFF_sanatize_string( $string, $length_limit = 0 ) {

	$string = strtolower($string); // No Capitals
	$string = str_replace(' ', '-', $string); // No Spaces

	if( $length_limit > 0 ) {
		$string = substr($string, 0, $length_limit); // Max Chars
	}

	return $string;
}

function WPSCAFF_array_to_string( $array ) {

	if( !is_array( $array ) )
		return '';

	return "'" . implode( "', '", $array ) . "'";
}

function WPSCAFF_check_duplicates( $type, $name ) {

	if( 'cpt' == $type )
    	$duplicate_check = post_type_exists( $name );

    if( 'tax' == $type )
    	$duplicate_check = taxonomy_exists( $name );

	return $duplicate_check;
}

function WPSCAFF_make_string_translatable( $string, $domain = 'fabric' ) {

	// This is intentionally obfuscated to prevent translators from trying to translate this functions data
    $translate_start = "__" . "('";
    $translate_end = "', '$domain')";

	return $translate_start . $string . $translate_end;
}

function WPSCAFF_build_template( $template, $cpt_args = false, $tax_args = false ) {

	if( $cpt_args ) {
		$args = $cpt_args;
		$template_dir = 'cpt-templates';
	} elseif( $tax_args ) {
		$args = $tax_args;
		$template_dir = 'tax-templates';
	}

	if( !isset( $args ) )
		return;

	$template = file_get_contents(WPSCAFF_DIRECTORY . '/includes/'.$template_dir.'/'.$template.'.php');

	$formatted_template = vsprintf( $template, $args );

	return $formatted_template;
}

function WPSCAFF_write_files( $name, $files_to_write ) {

	foreach( $files_to_write as $type => $template )
	{
		if( !$template ) continue;

		switch($type)
		{
			case 'cpt':
				$written = file_put_contents(FABRIC_CPT_DIR . $name . '.php', $template);
				break;

			case 'cpt_controller':
				$written = file_put_contents(FABRIC_CONTROLLERS . ucfirst($name) . 'Fabric.php', $template);
				break;

			case 'cpt_single':
				$written = file_put_contents(FABRIC_VIEWS . 'single-' .$name . '.php', $template);
				break;

			case 'cpt_archive':
				$written = file_put_contents(FABRIC_VIEWS . 'archive-' .$name . '.php', $template);
				break;
			
			case 'tax':
				$written = file_put_contents(FABRIC_TAX_DIR . $name . '.php', $template);
				break;
		}
	}
}

function WPSCAFF_get_terms() {

	$taxonomy 	= $_POST['tax'];
	$nonce 		= $_POST['nonce'];

	wp_verify_nonce( $nonce, 'wpscaff_new-ctrlr' );

	$args = array(
		'hide_empty' => false
	);
	$taxonomy_terms = get_terms( $taxonomy, $args ); 

	$terms = array();
	$x=0;
	foreach( $taxonomy_terms as $term )
	{
		$terms[$x]['slug'] = $term->slug;
		$terms[$x]['name'] = $term->name;
		$x++;
	}

	echo json_encode( $terms );
	exit;
}
add_action('wp_ajax_scaffolding_get_terms', 'WPSCAFF_get_terms');


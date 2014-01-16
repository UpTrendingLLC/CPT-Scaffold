<?php

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
<?php
/*
Plugin Name: WP Scaffolding
Plugin URI: http://UpTrending.com
Description: Quick start for working with new CPT's and Taxonomies for the Fabric Theme Framework
Author: Matt Keys
Version: 1.1.1
Author URI: http://UpTrending.com
*/

/*  Copyright 2013  UpTrending  (email : matt@uptrending.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//Path to this file
if ( !defined('WPSCAFF_PLUGIN_FILE') ){
    define('WPSCAFF_PLUGIN_FILE', __FILE__);
}

//Path to the plugin's directory
if ( !defined('WPSCAFF_DIRECTORY') ){
    define('WPSCAFF_DIRECTORY', dirname(__FILE__));
}

//Publicly Accessible path
if ( !defined('WPSCAFF_PUBLIC_PATH') ){
    define('WPSCAFF_PUBLIC_PATH', plugin_dir_url(__FILE__));
}

//Load the actual plugin
require 'core/helper.php';
require 'core/core.php';
require 'core/admin.php';

if( is_admin() ) {
    require_once 'wp-scaffolding-update.php';
}
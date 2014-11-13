<?php
/*
 Plugin Name: BEA Customize Devices
 Version: 1.0.0
 Description: Add to the customizer the ability to change the iframe size for the responsive
 Author: Be Api
 Author URI: http://www.beapi.fr
 Domain Path: languages
 Text Domain: bea-customize-devices
 ----

 Copyright 2014 Beapi (technique@beapi.fr)

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

// don't load directly
if ( !defined('ABSPATH') )
	die('-1');

// Plugin constants
define( 'BEA_CUSTOM_DEVICES_VERSION', '1.0.0' );

// Plugin URL and PATH
define('BEA_CUSTOM_DEVICES_URL', plugin_dir_url ( __FILE__ ));
define('BEA_CUSTOM_DEVICES_DIR', plugin_dir_path( __FILE__ ));

// Function for easy load files
function _bea_custom_devices_load_files( $dir, $files, $prefix = '' ) {
	foreach ( $files as $file ) {
		if ( is_file( $dir . $prefix . $file . ".php" ) ) {
			require_once( $dir . $prefix . $file . ".php" );
		}
	}
}

// Plugin classes
if( is_admin() ) {
	_bea_custom_devices_load_files( BEA_CUSTOM_DEVICES_DIR . 'classes/', array( 'main' ) );
}

add_action('plugins_loaded', 'init_bea_custom_sizes_plugin');
function init_bea_custom_sizes_plugin() {
	if( !is_admin() ) {
		return false;
	}

	// Admin
	BEA_Customize_Devices_Main::get_instance();
}
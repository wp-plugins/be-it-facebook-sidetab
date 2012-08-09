<?php
/*
Plugin Name: Be-It Facebook SideTab
Plugin URI: http://wordpress.org/extend/plugins/be-it-facebook-sidetab/
Description: Be-It Facebook Like Box side tab is a sliding and floating tab on left or right screen that has multiply options for viewing.
Version: 2.0.0
Author: Be-It Consulting
Author URI: http://www.be-it.se/

*/

/*  Copyright 2011-2012  Be-It Consulting  (email: support@be-it.se)

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

define( 'BE_SIDETAB_VERSION', '2.0.0' );
define( 'BE_SIDETAB_OPTION', 'beit_sidetab' );
define( 'BE_SIDETAB_BASE' , plugin_dir_path(__FILE__));
define( 'BE_SIDETAB_URL' , plugin_dir_url(__FILE__));

	
	/* Add files */
	if ( !class_exists('WPlize') ) {
		require_once('class/class.options.php');
	}
	
	require_once('class/class.setup.php');
	require_once('class/class.init.php');
	require_once('class/class.functions.php');
	
	// Get option
	$WPlize = new WPlize(BE_SIDETAB_OPTION);
	
		/* Check if installed */
	if($WPlize->get_option('fb_data_href')==FALSE) {
		add_action('admin_notices', array('be_it_sidetab_functions','not_installed'));
	}
	
	/* Load language */
  add_action('plugins_loaded', array('be_it_sidetab_init','language'));

	/* Install / Uninstall */
	register_activation_hook(__FILE__, array('be_it_sidetab_setup', 'install') );
	register_deactivation_hook(__FILE__ , array('be_it_sidetab_setup', 'uninstall') );
	
  /* Add menu */
  add_action('admin_menu', array('be_it_sidetab_init','menu'));
  
  /* Add header */
  add_action('init', array('be_it_sidetab_init','css'));
  add_action('init', array('be_it_sidetab_init','js')); 

  /* Include adminpage */
	require_once('include/admin.php');

  /* Include frontend tab */
	require_once('include/frontend.php');
	
	// Add action to footer 
	if($WPlize->get_option('fb_data_href')==TRUE) {	
		add_action( 'wp_head', 'beit_sidetab_frontend_head');	
		add_action( 'wp_footer', 'beit_sidetab_frontend_footer', 20);
	}		
  

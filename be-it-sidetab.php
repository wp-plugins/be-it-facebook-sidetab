<?php
/*
Plugin Name: Be-It Facebook SideTab
Plugin URI: http://wordpress.org/extend/plugins/be-it-facebook-sidetab/
Description: Be-It Facebook Like Box side tab is a sliding and floating tab on left or right screen that has multiply options for viewing.
Version: 2.2.2
Author: Be-It Consulting
Author URI: http://www.be-it.se/

*/

/*  Copyright 2011-2015  Be-It Consulting  (email: support@be-it.se)

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

define( 'BE_SIDETAB_VERSION', '2.2.2' );
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
		
		$useragent=$_SERVER['HTTP_USER_AGENT'];
		if(preg_match('/android.+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|meego.+mobile|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) {

			// If show in mobile
			if($WPlize->get_option('show_on_mobile')=='true') {
				add_action( 'wp_head', 'beit_sidetab_frontend_head');	
				add_action( 'wp_footer', 'beit_sidetab_frontend_footer', 20);	
			}			
			
		} else {
			add_action( 'wp_head', 'beit_sidetab_frontend_head');	
			add_action( 'wp_footer', 'beit_sidetab_frontend_footer', 20);
		}
		
	}		
  

<?php
class be_it_sidetab_init
{
	/*
	** Initiation Language
	** @return void
	*/
	function language() {
  	load_plugin_textdomain('beit-sidetab-language', false, BE_SIDETAB_BASE . '/languages' );
  }



	/*
	** Initiation menu
	** @return void
	*/
	function menu(){
		
		add_options_page(__('Be-It FB Sidetab', 'beit-sidetab'),__('Be-It Sidetab', 'beit-sidetab'), 'edit_pages', 'beit_sidetab', 'display_sidetab_settings');     
	
  }

	/*
	** Initiation style
	** @return void
	*/
	function css()
	{
   if (is_admin()) {
    wp_enqueue_style( 'beit-sidetab-style', BE_SIDETAB_URL . '/css/admin-style.css', array(), '1.0', 'screen' );
   } else {
	  //wp_enqueue_style( 'beit-sidetab-style', BE_SIDETAB_URL . 'css/style.php', array(), '1.0', 'screen' ); 
	  // Get option
	  $WPlize = new WPlize(BE_SIDETAB_OPTION);
	  
	  if($WPlize->get_option('fb_color_scheme')=='dark'){
 	 		$fb_bg_color = '000';
 	 	} else {
	 	 	$fb_bg_color = 'FFF';
 	 	}
	  
	  $url = BE_SIDETAB_URL . 'css/style.php?bgcolor='. $WPlize->get_option('bgcolor') .'&width='. $WPlize->get_option('fb_width') .'&height='. $WPlize->get_option('fb_height') .'&fb_bgcolor='. $fb_bg_color;
	  
	  echo "<link type='text/css' rel='stylesheet' href='$url' media='screen' />";
   }
	}
	
	/*
	** Initiation JS
	** @return void
	*/
	function js()
	{
   	wp_enqueue_script('jquery');
   
   	if (is_admin()) {
    	wp_enqueue_script('beit-sidetab-switches', BE_SIDETAB_URL . '/js/checkbox.switches.js', array('jquery'), '1.8.1', true);
    } else {
	  	wp_enqueue_script('beit-sidetab-slide', BE_SIDETAB_URL . 'js/jquery.tabSlideOut.v1.3.js', array('jquery'), '1.8.1', true);
	  }    
	}
	
	
}

?>
<?php
class be_it_sidetab_init
{
	/*
	** Initiation Language
	** @return void
	*/
	public static function language() {
  	load_plugin_textdomain('beit-sidetab-language', false, BE_SIDETAB_BASE . '/languages' );
  }



	/*
	** Initiation menu
	** @return void
	*/
	public static function menu(){
		
		add_options_page(__('Be-It FB Sidetab', 'beit-sidetab'),__('Be-It Sidetab', 'beit-sidetab'), 'edit_pages', 'beit_sidetab', 'display_sidetab_settings');     
	
  }

	/*
	** Initiation style
	** @return void
	*/
	public static function css()
	{
   if (is_admin()) {
    wp_enqueue_style( 'beit-sidetab-style', BE_SIDETAB_URL . '/css/admin-style.css', array(), '1.0', 'screen' );
   } else {
    // NOTHING
   }
	}
	
	/*
	** Initiation JS
	** @return void
	*/
	public static function js()
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
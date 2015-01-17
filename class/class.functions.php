<?php
class be_it_sidetab_functions
{

	/*
	** Admin notice
	*/
	public function get_admin_notice($msg, $type = false){
		
		if ($type) {
			$notice = '<div id="message" class="error">';
		} else {
			$notice = '<div id="message" class="updated fade">';
		}
		
		$notice .= "<p><strong>$msg</strong></p></div>";
		
		return $notice;
	}  

	/*
	** Not installed
	*/
	public static function not_installed(){
    global $pagenow;
    if ( $pagenow == 'plugins.php' || $_SERVER['QUERY_STRING'] == 'page=beit_sidetab') {
      
      $c = new be_it_sidetab_functions(); 
    	echo $c->get_admin_notice(__("Be-It Sidetab settings must be set, please go to settings/be-it sidetab. You can click <a href='options-general.php?page=beit_sidetab'>here</a>", "beit-sidetab"), true);

    }
   }

	/*
	** Updated
	*/
	function updated($msg){

      $c = new be_it_sidetab_functions(); 
    	echo $c->get_admin_notice(__("Successfylly updated", "beit-sidetab"), false);

   }

}


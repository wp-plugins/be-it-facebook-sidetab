<?php
class be_it_sidetab_setup
{
	/*
	** Install
	*/
	function install(){

		$optionkeys = array(
										'versions' => BE_SIDETAB_VERSION,
										'img' => BE_SIDETAB_URL . 'images/facebook-left.png',
										'location' => 'left',
										'action' => 'click',
										'speed' => '500',
										'toppos' => '100',
										'sticked' => 'false',
										'fb_height' => '560',
										'fb_width' => '292',
										'fb_app_id' => '',
										'fb_data_href' => '',
										'fb_show_faces' => 'true',
										'fb_show_stream' => 'true',		
										'fb_show_header' => 'false',
										'fb_border_color' => '',
										'fb_color_scheme' => 'light',
										'bgcolor' => '3b62a7',
										'show_on_mobile' => 'false',
										'uninstall_all' => 'true'													
										);


		add_option(BE_SIDETAB_OPTION, $optionkeys);
		
	}

	/*
	** Uninstall
	*/
	function uninstall(){
		
		$option = get_option(BE_SIDETAB_OPTION);
		if($option['uninstall_all'] == 'true')
		{
    	delete_option(BE_SIDETAB_OPTION);   			
		}
	}


}

?>
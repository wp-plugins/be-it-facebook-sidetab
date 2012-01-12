<?php
/*
Plugin Name: Be-It Facebook SideTab
Plugin URI: http://wordpress.org/extend/plugins/be-it-facebook-sidetab/
Description: Be-It Facebook Like Box side tab is a sliding and floating tab on left or right screen that has multiply options for viewing.
Version: 1.1.0
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

define( 'BE_SIDETAB_VERSION', '1.1.0' );
define( 'BE_SIDETAB_OPTION', 'beit_sidetab' );
define( 'BE_SIDETAB_DEBUG', 'false' );


// Set settings in plugin page row
function beit_sidetab_settings_link($links, $file){ 
	//Static so we don't call plugin_basename on every plugin row.
	static $this_plugin;
	if (!$this_plugin) $this_plugin = plugin_basename(dirname(__FILE__).'/sidetab.php');
	
	if ($file == $this_plugin){
		$settings_link = '<a href="options-general.php?page=beit_sidetab">' . __('Settings','beit-sidetab') . '</a>';
		array_unshift( $links, $settings_link ); // before other links
	}
	return $links;
}
add_filter('plugin_action_links', 'beit_sidetab_settings_link', 10, 2);


// Install plugin
function install_sidetab_plugin() {

	$optionkeys = array(
										'versions' => BE_SIDETAB_VERSION,
										'img' => plugin_dir_url( __FILE__ ) . 'images/facebook-left.png',
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
										'bgcolor' => '3b62a7'														
										);

	$option = get_option(BE_SIDETAB_OPTION);
  add_option(BE_SIDETAB_OPTION, $optionkeys);
}
// hook the installation
register_activation_hook(__FILE__,'install_sidetab_plugin');


// uninstallation plugin
function uninstall_sidetab_plugin() {
	delete_option(BE_SIDETAB_OPTION);      
}
// hook the uninstallation
register_deactivation_hook(__FILE__ , 'uninstall_sidetab_plugin' );


// Init front end
if (!is_admin()) {
	function beit_sidetab_init_frontend() {
    global $wpdb;
    wp_enqueue_style( 'frontend-style', plugin_dir_url( __FILE__ ) . 'css/style.css', array(), '0.1', 'screen');
    wp_enqueue_script('jquery');
    wp_enqueue_script('sidetab-slide', plugins_url('/js/jquery.tabSlideOut.v1.3.js',__FILE__), array('jquery'), '1.0', true);   
		load_plugin_textdomain('beit-sidetab', false, basename( dirname( __FILE__ ) ) . '/languages' );
  }
  add_action('init', 'beit_sidetab_init_frontend');
}

// Init back end
if (is_admin()) {
	function beit_sidetab_init_backend() {
    global $wpdb;
    wp_enqueue_style( 'backend-style', plugin_dir_url( __FILE__ ) . 'css/admin-style.css', array(), '0.1', 'screen' );
    wp_enqueue_script('jquery');
    wp_enqueue_script('checkbox-switches', plugins_url('/js/checkbox.switches.js',__FILE__), array('jquery'), '1.0', true); 
 		load_plugin_textdomain('beit-sidetab', false, basename( dirname( __FILE__ ) ) . '/languages' );
	}
	add_action('init', 'beit_sidetab_init_backend');
}



// Admin menu
function beit_sidetab_admin_menu() {
	add_options_page(__('Be-It Sidetab', 'beit-sidetab'),__('Be-It Sidetab', 'beit-sidetab'), 'edit_pages', 'beit_sidetab', 'display_sidetab_settings');     
}
// add action to create menu
add_action('admin_menu', 'beit_sidetab_admin_menu');



// ********************************************************************
// Display admin page
function display_sidetab_settings() {

// If debug
if(BE_SIDETAB_DEBUG=='true'){
  	echo "<pre>";
 	 		print_r($_POST);
  	echo "</pre>";  
}

// If post
if(isset($_POST['fb_data_href']) && isset($_POST['img']) && isset($_POST['fb_app_id'])){

	// Check if left or right and change image 
	$option = get_option(BE_SIDETAB_OPTION);
  if(isset($option['location'])) {
 		if($option['location']=='left' && $_POST['location']=='right' && strstr($_POST['img'], "facebook-left.png")) {
 			$img = plugin_dir_url( __FILE__ ) . 'images/facebook-right.png';
 		} elseif($option['location']=='right' && $_POST['location']=='left' && strstr($_POST['img'], "facebook-right.png")) {
 			$img = plugin_dir_url( __FILE__ ) . 'images/facebook-left.png';
 		} else {
 			$img = esc_attr($_POST['img']);
 		}
  }; 	
  			
			
	$optionkeys = array(
										'versions' => BE_SIDETAB_VERSION,
										'img' => $img,
										'location' => esc_attr($_POST['location']),
										'action' => esc_attr($_POST['action']),
										'speed' => esc_attr($_POST['speed']),
										'toppos' => esc_attr($_POST['toppos']),
										'sticked' => esc_attr($_POST['sticked']),
										'fb_height' => esc_attr($_POST['fb_height']),
										'fb_width' => esc_attr($_POST['fb_width']),
										'fb_app_id' => esc_attr($_POST['fb_app_id']),
										'fb_data_href' => esc_attr($_POST['fb_data_href']),
										'fb_show_faces' => esc_attr($_POST['fb_show_faces']),
										'fb_show_stream' => esc_attr($_POST['fb_show_stream']),		
										'fb_show_header' => esc_attr($_POST['fb_show_header']),
										'fb_border_color' => '',
										'fb_color_scheme' => '',
										'bgcolor' => esc_attr($_POST['bgcolor'])													
										);
			
	$option = get_option(BE_SIDETAB_OPTION);
	if(isset($option['versions'])) {
  	update_option(BE_SIDETAB_OPTION, $optionkeys); 
  	showMessage(__("Post was saved successfully", "beit-sidetab"));
	} else {
  	add_option(BE_SIDETAB_OPTION, $optionkeys);  
	}; 
    	
}// End post
	
// Get option
$option = get_option(BE_SIDETAB_OPTION);
	
// If debug
if(BE_SIDETAB_DEBUG=='true'){
  	echo "<pre>";
 	 		print_r($option);
  	echo "</pre>";  
}

// Get all options
   if(isset($option['versions'])) $versions = $option['versions'];
   if(isset($option['img'])) $img = $option['img']; 
   if(isset($option['location'])) $location = $option['location'];      
   if(isset($option['action'])) $action = $option['action'];
   if(isset($option['speed'])) $speed = $option['speed'];  
   if(isset($option['toppos'])) $toppos = $option['toppos'];
   if(isset($option['sticked'])) $sticked = $option['sticked']; 
   if(isset($option['fb_height'])) $height = $option['fb_height']; 
   if(isset($option['fb_width'])) $width = $option['fb_width'];      
   if(isset($option['fb_data_href'])) $data_href = $option['fb_data_href'];
   if(isset($option['fb_show_faces'])) $show_faces = $option['fb_show_faces'];  
   if(isset($option['fb_show_stream'])) $show_stream = $option['fb_show_stream'];
   if(isset($option['fb_show_header'])) $show_header = $option['fb_show_header']; 
   if(isset($option['fb_app_id'])) $app_id = $option['fb_app_id']; 
   if(isset($option['bgcolor'])) $bgcolor = $option['bgcolor'];          
  
?> 
<div class=wrap>

	<?php screen_icon(); ?> <h2><?php _e('Sidetab Settings', 'beit-sidetab') ?></h2> 

	<form name="tab-form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	
	<input type="hidden" name="action" value="click" />
	
	<table class="form-table">
		
  	<tr valign="top">
      <td colspan="2">
      		<h3><?php _e('Facebook settings', 'beit-sidetab') ?></h3>
      </td>
    </tr>		
		
  	<tr valign="top">
    	<th scope="row">
      	<label for="url"><?php _e('FB Url', 'beit-sidetab') ?></label>
      </th>
      <td>
      	<input type="text" name="fb_data_href" id="fb_data_href" class="b-input" value="<?php echo $data_href; ?>" />
      </td>
    </tr>

  	<tr valign="top">
    	<th scope="row">
      	<label for="url"><?php _e('FB App Id', 'beit-sidetab') ?></label>
      </th>
      <td>
      	<input type="text" name="fb_app_id" id="fb_app_id" class="b-input" value="<?php echo $app_id; ?>" />
      </td>
    </tr>
 
  	<tr valign="top">
    	<th scope="row">
      	<label for="url"><?php _e('FB Width x Height', 'beit-sidetab') ?></label>
      </th>
      <td>
      	<input type="text" name="fb_width" id="fb_width" class="s-input" value="<?php echo $width; ?>" /> X <input type="text" name="fb_height" id="fb_height" class="s-input" value="<?php echo $height; ?>" />
      </td>
    </tr>
 
  	<tr valign="top">
    	<th scope="row">
      	<label for="url"><?php _e('FB Show header', 'beit-sidetab') ?></label>
      </th>
      <td>
      		<p class="field switch">
    				<input type="radio" id="radio1" name="fb_show_header" value="true" <?php if($show_header=='true') echo 'checked'; ?> />
    				<input type="radio" id="radio2" name="fb_show_header" value="false" <?php if($show_header=='false') echo 'checked'; ?> />
    				<label for="radio1" class="cb-enable <?php if($show_header=='true') echo 'selected'; ?>"><span><?php _e('Enable', 'beit-sidetab') ?></span></label>
    				<label for="radio2" class="cb-disable <?php if($show_header=='false') echo 'selected'; ?>"><span><?php _e('Disable', 'beit-sidetab') ?></span></label>
					</p>
      </td>
    </tr>  

  	<tr valign="top">
    	<th scope="row">
      	<label for="url"><?php _e('FB Show stream', 'beit-sidetab') ?></label>
      </th>
      <td>
      		<p class="field switch">
    				<input type="radio" id="radio3" name="fb_show_stream" value="true" <?php if($show_stream=='true') echo 'checked'; ?> />
    				<input type="radio" id="radio4" name="fb_show_stream" value="false" <?php if($show_stream=='false') echo 'checked'; ?> />
    				<label for="radio3" class="cb-enable <?php if($show_stream=='true') echo 'selected'; ?>"><span><?php _e('Enable', 'beit-sidetab') ?></span></label>
    				<label for="radio4" class="cb-disable <?php if($show_stream=='false') echo 'selected'; ?>"><span><?php _e('Disable', 'beit-sidetab') ?></span></label>
					</p>
      </td>
    </tr> 

  	<tr valign="top">
    	<th scope="row">
      	<label for="url"><?php _e('FB Show faces', 'beit-sidetab') ?></label>
      </th>
      <td>
      		<p class="field switch">
    				<input type="radio" id="radio5" name="fb_show_faces" value="true" <?php if($show_faces=='true') echo 'checked'; ?> />
    				<input type="radio" id="radio6" name="fb_show_faces" value="false" <?php if($show_faces=='false') echo 'checked'; ?> />
    				<label for="radio5" class="cb-enable <?php if($show_faces=='true') echo 'selected'; ?>"><span><?php _e('Enable', 'beit-sidetab') ?></span></label>
    				<label for="radio6" class="cb-disable <?php if($show_faces=='false') echo 'selected'; ?>"><span><?php _e('Disable', 'beit-sidetab') ?></span></label>
					</p>
      </td>
    </tr> 

  	<tr valign="top">
      <td colspan="2">
      		<h3><?php _e('Slide settings', 'beit-sidetab') ?></h3>
      </td>
    </tr>	

  	<tr valign="top">
    	<th scope="row">
      	<label for="url"><?php _e('Float Left or Right', 'beit-sidetab') ?></label>
      </th>
      <td>
      		<p class="field switch">
    				<input type="radio" id="radio7" name="location" value="left" <?php if($location=='left') echo 'checked'; ?> />
    				<input type="radio" id="radio8" name="location" value="right" <?php if($location=='right') echo 'checked'; ?> />
    				<label for="radio7" class="cb-enable <?php if($location=='left') echo 'selected'; ?>"><span><?php _e('Left', 'beit-sidetab') ?></span></label>
    				<label for="radio8" class="cb-disable <?php if($location=='right') echo 'selected'; ?>"><span><?php _e('Right', 'beit-sidetab') ?></span></label>
					</p>
      </td>
    </tr> 

  	<tr valign="top">
      <td colspan="2">
      		<span style="color: #666; font-style: italic;"><?php _e("When changing float left or right the image will adjust automatically after save if you haven't changed image below", 'beit-sidetab') ?></span>
      </td>
    </tr>     

  	<tr valign="top">
    	<th scope="row">
      	<label for="action"><?php _e('Slide on click or hover', 'beit-sidetab') ?></label>
      </th>
      <td>
      		<p class="field switch">
    				<input type="radio" id="radio9" name="action" value="click" <?php if($action=='click') echo 'checked'; ?> />
    				<input type="radio" id="radio10" name="action" value="hover" <?php if($action=='hover') echo 'checked'; ?> />
    				<label for="radio9" class="cb-enable <?php if($action=='click') echo 'selected'; ?>"><span><?php _e('Click', 'beit-sidetab') ?></span></label>
    				<label for="radio10" class="cb-disable <?php if($action=='hover') echo 'selected'; ?>"><span><?php _e('Hover', 'beit-sidetab') ?></span></label>
					</p>
      </td>
    </tr> 

  	<tr valign="top">
    	<th scope="row">
      	<label for="url"><?php _e('Tab Sticked or Floating', 'beit-sidetab') ?></label>
      </th>
      <td>
      		<p class="field switch">
    				<input type="radio" id="radio11" name="sticked" value="false" <?php if($sticked=='false') echo 'checked'; ?> />
    				<input type="radio" id="radio12" name="sticked" value="true" <?php if($sticked=='true') echo 'checked'; ?> />
    				<label for="radio11" class="cb-enable <?php if($sticked=='false') echo 'selected'; ?>"><span><?php _e('Sticked', 'beit-sidetab') ?></span></label>
    				<label for="radio12" class="cb-disable <?php if($sticked=='true') echo 'selected'; ?>"><span><?php _e('Floated', 'beit-sidetab') ?></span></label>
					</p>
      </td>
    </tr>
    
  	<tr valign="top">
    	<th scope="row">
      	<label for="url"><?php _e('Slide speed', 'beit-sidetab') ?></label>
      </th>
      <td>
      	<input type="text" name="speed" id="speed" class="s-input" value="<?php echo $speed; ?>" />
      </td>
    </tr>

  	<tr valign="top">
    	<th scope="row">
      	<label for="url"><?php _e('From top position', 'beit-sidetab') ?></label>
      </th>
      <td>
      	<input type="text" name="toppos" id="toppos" class="s-input" value="<?php echo $toppos; ?>" />
      </td>
    </tr>

  	<tr valign="top">
    	<th scope="row">
      	<label for="url"><?php _e('Background color', 'beit-sidetab') ?></label>
      </th>
      <td>
      	#<input type="text" name="bgcolor" id="bgcolor" class="s-input" value="<?php echo $bgcolor; ?>" />
      </td>
    </tr>

  	<tr valign="top">
    	<th scope="row">
      	<label for="url"><?php _e('Image', 'beit-sidetab') ?></label>
      </th>
      <td>
      	<input type="text" name="img" id="img" class="b-input" value="<?php echo $img; ?>" />
      </td>
    </tr>

  	<tr valign="top">
    	<th scope="row">
      </th>
      <td>
      	<img src="<?php echo $img; ?>" />
      </td>
    </tr>
 
	</table>
 
	<p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes', 'beit-sidetab') ?>" />
	</p>
 
</form>

</div>

<br />

<div class=wrap>

	<?php screen_icon(); ?> <h2><?php _e('Donate and Like', 'beit-sidetab') ?></h2>
	<div>
		<iframe src="http://www.be-it.se/donate.php" frameborder="0" width="100%" height="80" style="margin-top:20px;"></iframe>
	</div>
	
</div>

<?php  
} // End admin page


// Check if setup. Don't do frontend before setup
$optionss = get_option(BE_SIDETAB_OPTION);
if(!isset($optionss['fb_data_href']) || ($optionss['fb_data_href']=='')) {
	add_action('admin_notices', 'showAdminMessages');
} else {

// ********************************************************************
// Display frontend page

// Add in frontend head
function beit_sidetab_frontend_head() {
	
	// Get app id
	$option = get_option(BE_SIDETAB_OPTION);
  if(isset($option['appid'])) $appid = $option['appid'];	
?>

<div id="fb-root"></div>
<script>
	var appid = '<?php $appid; ?>';
	(function(d, s, id) {
  	var js, fjs = d.getElementsByTagName(s)[0];
  	if (d.getElementById(id)) return;
  	js = d.createElement(s); js.id = id;
  	js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=appid";
  	fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
</script>

<?php
}
// Add action to head
add_action( 'wp_head', 'beit_sidetab_frontend_head');



//This function is called in the wp_footer and welcomes every visitor
function beit_sidetab_frontend_footer() {
	
	$option = get_option(BE_SIDETAB_OPTION);
    if(isset($option['versions'])) $versions = $option['versions'];
    if(isset($option['img'])) $img = $option['img']; 
    if(isset($option['location'])) $location = $option['location'];      
    if(isset($option['action'])) $action = $option['action'];
    if(isset($option['speed'])) $speed = $option['speed'];  
    if(isset($option['toppos'])) $toppos = $option['toppos'];
    if(isset($option['sticked'])) $sticked = $option['sticked']; 
    if(isset($option['fb_height'])) $height = $option['fb_height']; 
    if(isset($option['fb_width'])) $width = $option['fb_width'];      
    if(isset($option['fb_data_href'])) $data_href = $option['fb_data_href'];
    if(isset($option['fb_show_faces'])) $show_faces = $option['fb_show_faces'];  
    if(isset($option['fb_show_stream'])) $show_stream = $option['fb_show_stream'];
    if(isset($option['fb_show_header'])) $show_header = $option['fb_show_header'];   
    if(isset($option['bgcolor'])) $bgcolor = $option['bgcolor'];  
        
    list($img_width, $img_height, $img_type, $img_attr) = getimagesize($img);
    
?>
<script type="text/javascript">
jQuery(function(){
  	jQuery('#be-it-sidetab').tabSlideOut({
       tabHandle: '.side-tab-clickme',           		//class of the element that will become your tab
       pathToTabImage: '<?php echo $img; ?>', 				//path to the image for the tab 
       imageHeight: '<?php echo $img_height; ?>px',  //height of tab image           
       imageWidth: '<?php echo $img_width; ?>px',   	//width of tab image     
       tabLocation: '<?php echo $location; ?>',  		//side of screen where tab lives, top, right, bottom, or left
       speed: <?php echo $speed; ?>,             		//speed of animation
       action: '<?php echo $action; ?>',         		//options: 'click' or 'hover', action to trigger animation
       topPos: '<?php echo $toppos; ?>px',       		//position from the top/ use if tabLocation is left or right
       leftPos: '20px',                          		//position from left/ use if tabLocation is bottom or top
       fixedPosition: <?php echo $sticked; ?>    		//options: true makes it stick(fixed position) on scroll
     });
});
</script>

<style>
#be-it-sidetab {
	background: #<?php echo $bgcolor; ?>;
}      

#be-it-sidetab .fb-like-box {
  	width: <?php echo $width; ?>px;
  	height: <?php echo $height; ?>px;		      
} 
</style>

<div id="be-it-sidetab">
			<div class="side-tab-bg-box"><div class="fb-like-box" data-href="<?php echo $data_href; ?>" data-width="<?php echo $width; ?>" data-height="<?php echo $height; ?>" data-show-faces="<?php echo $show_faces; ?>" data-stream="<?php echo $show_stream; ?>" data-header="<?php echo $show_header; ?>"></div></div>
  		<div class="side-tab-clickme"></div>
</div>
    
<?php
} // End frontend footer
// Add action to footer 
add_action( 'wp_footer', 'beit_sidetab_frontend_footer', 20);


}; // End if settings

function showAdminMessages(){
    // Shows as an error message. You could add a link to the right page if you wanted.
    showMessage(__("Be-It Sidetab settings must be set, please go to settings/be-it sidetab. You can click <a href='options-general.php?page=beit_sidetab'>here</a>", "beit-sidetab"), true);
}

function showMessage($message, $errormsg = false){
	if ($errormsg) {
		echo '<div id="message" class="error">';
	} else {
		echo '<div id="message" class="updated fade">';
	}
	echo "<p><strong>$message</strong></p></div>";
}    

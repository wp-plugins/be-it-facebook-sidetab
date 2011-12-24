<?php
/*
Plugin Name: Be-It Facebook SideTab
Plugin URI: http://wordpress.org/extend/plugins/be-it-facebook-sidetab/
Description: Be-It Facebook Like Box side tab is a sliding and floating tab on left or right screen that has multiply options for viewing. Enter your Facebook page info in settings and slide tab will appear on frontpage.
Version: 1.0.1
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

define( 'BE_SIDETAB_VERSION', '1.0' );
define( 'BE_SIDETAB_OPTION', 'beit_sidetab' );
define( 'BE_SIDETAB_DEBUG', 'false' );


// copied from Sociable Plugin
function qtrans_links($links, $file){ 
	//Static so we don't call plugin_basename on every plugin row.
	static $this_plugin;
	if (!$this_plugin) $this_plugin = plugin_basename(dirname(__FILE__).'/sidetab.php');
	
	if ($file == $this_plugin){
		$settings_link = '<a href="options-general.php?page=sidetab">' . __('Settings') . '</a>';
		array_unshift( $links, $settings_link ); // before other links
	}
	return $links;
}
add_filter('plugin_action_links', 'qtrans_links', 10, 2);


// function to the activation plugin
function plugin_install_sidetab() {
			
			$optionkeys = array(
										'versions' => BE_SIDETAB_VERSION,
										'img' => plugin_dir_url( __FILE__ ) . 'images/facebook-left.png',
										'location' => 'left',
										'action' => 'click',
										'speed' => '500',
										'toppos' => '100',
										'sticked' => 'absolute',
										'fb_height' => '560',
										'fb_width' => '292',
										'fb_app_id' => '174753175955601',
										'fb_data_href' => 'https://www.facebook.com/pages/Be-It-Consulting/264035930857',
										'fb_show_faces' => 'true',
										'fb_show_stream' => 'true',		
										'fb_show_header' => 'false',
										'fb_border_color' => '',
										'fb_color_scheme' => ''														
										);
			
			$option = get_option(BE_SIDETAB_OPTION);
    	add_option(BE_SIDETAB_OPTION, $optionkeys);
}

// hook the installation function to the activation plugin
register_activation_hook(__FILE__,'plugin_install_sidetab');


// function to the uninstallation plugin
function plugin_uninstall_sidetab() {
	delete_option(BE_SIDETAB_OPTION);      
}

// hook the uninstallation
register_deactivation_hook(__FILE__ , 'plugin_uninstall_sidetab' );


// Init if front end
if (!is_admin()) {
	add_action('init', 'frontend_sidetab_header');
	function frontend_sidetab_header() {
    global $wpdb;
    wp_enqueue_style( 'frontend-style', plugin_dir_url( __FILE__ ) . 'css/style.css', array(), '0.1', 'screen');
    wp_enqueue_script('jquery');
  }
}

// Init if back end
if (is_admin()) {
	add_action('init', 'backend_sidetab_header');
	function backend_sidetab_header() {
    global $wpdb;
    wp_enqueue_style( 'backend-style', plugin_dir_url( __FILE__ ) . 'css/admin-style.css', array(), '0.1', 'screen' );
    wp_enqueue_script('jquery');
    wp_enqueue_script('checkbox-switches', plugins_url('/js/checkbox.switches.js',__FILE__), array('jquery'), '1.0', true);    
	}
}


// function menu
function sidetab_admin_menu() {
	add_options_page(__('Sidetab', 'beit_sidetab'),__('Sidetab', 'beit_sidetab'), 'edit_pages', 'sidetab', 'display_sidetab_settings');     
}

// add action to create menu
add_action('admin_menu', 'sidetab_admin_menu');


// Display function for admin page
function display_sidetab_settings() {

	// Check if installed
	check_if_sidetab_setup();

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
										'fb_color_scheme' => ''														
										);
			
			$option = get_option(BE_SIDETAB_OPTION);
    	if(isset($option['versions'])) {
    		update_option(BE_SIDETAB_OPTION, $optionkeys); 
				echo '<div id="message" class="updated fade"><p>'. __('Successfylly updated', 'beit_sidetab') .'</p></div>';
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
  
?> 
<div class=wrap>

	<?php screen_icon(); ?> <h2><?php _e('Sidetab Settings', 'beit_sidetab') ?></h2> 

	<form name="tab-form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	
	<input type="hidden" name="action" value="click" />
	
	<table class="form-table">
		
  	<tr valign="top">
      <td colspan="2">
      		<h3><?php _e('Facebook settings', 'beit_sidetab') ?></h3>
      </td>
    </tr>		
		
  	<tr valign="top">
    	<th scope="row">
      	<label for="url"><?php _e('FB Url', 'beit_sidetab') ?></label>
      </th>
      <td>
      	<input type="text" name="fb_data_href" id="fb_data_href" class="b-input" value="<?php echo $data_href; ?>" />
      </td>
    </tr>

  	<tr valign="top">
    	<th scope="row">
      	<label for="url"><?php _e('FB App Id', 'beit_sidetab') ?></label>
      </th>
      <td>
      	<input type="text" name="fb_app_id" id="fb_app_id" class="b-input" value="<?php echo $app_id; ?>" />
      </td>
    </tr>
 
  	<tr valign="top">
    	<th scope="row">
      	<label for="url"><?php _e('FB Width x Height', 'beit_sidetab') ?></label>
      </th>
      <td>
      	<input type="text" name="fb_width" id="fb_width" class="s-input" value="<?php echo $width; ?>" /> X <input type="text" name="fb_height" id="fb_height" class="s-input" value="<?php echo $height; ?>" />
      </td>
    </tr>
 
  	<tr valign="top">
    	<th scope="row">
      	<label for="url"><?php _e('FB Show header', 'beit_sidetab') ?></label>
      </th>
      <td>
      		<p class="field switch">
    				<input type="radio" id="radio1" name="fb_show_header" value="true" <?php if($show_header=='true') echo 'checked'; ?> />
    				<input type="radio" id="radio2" name="fb_show_header" value="false" <?php if($show_header=='false') echo 'checked'; ?> />
    				<label for="radio1" class="cb-enable <?php if($show_header=='true') echo 'selected'; ?>"><span><?php _e('Enable') ?></span></label>
    				<label for="radio2" class="cb-disable <?php if($show_header=='false') echo 'selected'; ?>"><span><?php _e('Disable') ?></span></label>
					</p>
      </td>
    </tr>  

  	<tr valign="top">
    	<th scope="row">
      	<label for="url"><?php _e('FB Show stream', 'beit_sidetab') ?></label>
      </th>
      <td>
      		<p class="field switch">
    				<input type="radio" id="radio3" name="fb_show_stream" value="true" <?php if($show_stream=='true') echo 'checked'; ?> />
    				<input type="radio" id="radio4" name="fb_show_stream" value="false" <?php if($show_stream=='false') echo 'checked'; ?> />
    				<label for="radio3" class="cb-enable <?php if($show_stream=='true') echo 'selected'; ?>"><span><?php _e('Enable') ?></span></label>
    				<label for="radio4" class="cb-disable <?php if($show_stream=='false') echo 'selected'; ?>"><span><?php _e('Disable') ?></span></label>
					</p>
      </td>
    </tr> 

  	<tr valign="top">
    	<th scope="row">
      	<label for="url"><?php _e('FB Show faces', 'beit_sidetab') ?></label>
      </th>
      <td>
      		<p class="field switch">
    				<input type="radio" id="radio5" name="fb_show_faces" value="true" <?php if($show_faces=='true') echo 'checked'; ?> />
    				<input type="radio" id="radio6" name="fb_show_faces" value="false" <?php if($show_faces=='false') echo 'checked'; ?> />
    				<label for="radio5" class="cb-enable <?php if($show_faces=='true') echo 'selected'; ?>"><span><?php _e('Enable') ?></span></label>
    				<label for="radio6" class="cb-disable <?php if($show_faces=='false') echo 'selected'; ?>"><span><?php _e('Disable') ?></span></label>
					</p>
      </td>
    </tr> 

  	<tr valign="top">
      <td colspan="2">
      		<h3><?php _e('Slide settings', 'beit_sidetab') ?></h3>
      </td>
    </tr>	

  	<tr valign="top">
    	<th scope="row">
      	<label for="url"><?php _e('Float Left or Right', 'beit_sidetab') ?></label>
      </th>
      <td>
      		<p class="field switch">
    				<input type="radio" id="radio7" name="location" value="left" <?php if($location=='left') echo 'checked'; ?> />
    				<input type="radio" id="radio8" name="location" value="right" <?php if($location=='right') echo 'checked'; ?> />
    				<label for="radio7" class="cb-enable <?php if($location=='left') echo 'selected'; ?>"><span><?php _e('Left') ?></span></label>
    				<label for="radio8" class="cb-disable <?php if($location=='right') echo 'selected'; ?>"><span><?php _e('Right') ?></span></label>
					</p>
      </td>
    </tr> 

  	<tr valign="top">
      <td colspan="2">
      		<span style="color: #666; font-style: italic;"><?php _e('When changing float left or right the image will adjust automatically after save if you haven´t changed image below', 'beit_sidetab') ?></span>
      </td>
    </tr>     

<!--
  	<tr valign="top">
    	<th scope="row">
      	<label for="action"><php _e('Trigger on Click or Hover') ?></label>
      </th>
      <td>
      		<p class="field switch">
    				<input type="radio" id="radio9" name="action" value="click" <php if($action=='click') echo 'checked'; ?> />
    				<input type="radio" id="radio10" name="action" value="hover" <php if($action=='hover') echo 'checked'; ?> />
    				<label for="radio9" class="cb-enable <php if($action=='click') echo 'selected'; ?>"><span><php _e('Click') ?></span></label>
    				<label for="radio10" class="cb-disable <php if($action=='hover') echo 'selected'; ?>"><span><php _e('Hover') ?></span></label>
					</p>
      </td>
    </tr> 
-->

  	<tr valign="top">
    	<th scope="row">
      	<label for="url"><?php _e('Tab Sticked or Floating', 'beit_sidetab') ?></label>
      </th>
      <td>
      		<p class="field switch">
    				<input type="radio" id="radio11" name="sticked" value="absolute" <?php if($sticked=='absolute') echo 'checked'; ?> />
    				<input type="radio" id="radio12" name="sticked" value="fixed" <?php if($sticked=='fixed') echo 'checked'; ?> />
    				<label for="radio11" class="cb-enable <?php if($sticked=='absolute') echo 'selected'; ?>"><span><?php _e('Sticked') ?></span></label>
    				<label for="radio12" class="cb-disable <?php if($sticked=='fixed') echo 'selected'; ?>"><span><?php _e('Floated') ?></span></label>
					</p>
      </td>
    </tr>
    
  	<tr valign="top">
    	<th scope="row">
      	<label for="url"><?php _e('Slide speed', 'beit_sidetab') ?></label>
      </th>
      <td>
      	<input type="text" name="speed" id="speed" class="s-input" value="<?php echo $speed; ?>" />
      </td>
    </tr>

  	<tr valign="top">
    	<th scope="row">
      	<label for="url"><?php _e('From top position', 'beit_sidetab') ?></label>
      </th>
      <td>
      	<input type="text" name="toppos" id="toppos" class="s-input" value="<?php echo $toppos; ?>" />
      </td>
    </tr>

  	<tr valign="top">
    	<th scope="row">
      	<label for="url"><?php _e('Image', 'beit_sidetab') ?></label>
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
    <input type="submit" class="button-primary" value="<?php _e('Save Changes', 'beit_sidetab') ?>" />
	</p>
 
</form>

</div>

<br />

<div class=wrap>

	<?php screen_icon(); ?> <h2><?php _e('Donate and Like', 'beit_sidetab') ?></h2>
	<div>
		<iframe src="http://www.be-it.se/donate.php" frameborder="0" width="100%" height="80" style="margin-top:20px;"></iframe>
	</div>
	
</div>

<?php  
}


// Function head
function add_sidetab_head() {

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
add_action( 'wp_head', 'add_sidetab_head');



//This function is called in the wp_footer and welcomes every visitor
function add_sidetab_footer() {

	//check_if_sidetab_setup();
	
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
    
    list($img_width, $img_height, $img_type, $img_attr) = getimagesize($img);
    
?>
<style>
#fb-fader {
		position: <?php echo $sticked; ?>;
		<?php echo $location; ?>: 0;
		top: <?php echo $toppos; ?>px;
}
  
#fb-fader .clickme {
  	background: url(<?php echo $img; ?>) no-repeat;
  	float: <?php echo $location; ?>;
  	width: <?php echo $img_width; ?>px;
  	height: <?php echo $img_height; ?>px;
}

#fb-fader .box {
  	width: <?php echo $width; ?>px;
  	height: <?php echo $height; ?>px;
  	float: <?php echo $location; ?>;
}
</style>

	<div id="fb-fader">
		<div class="box"><div class="fb-like-box" data-href="<?php echo $data_href; ?>" data-width="<?php echo $width; ?>" data-height="<?php echo $height; ?>" data-show-faces="<?php echo $show_faces; ?>" data-stream="<?php echo $show_stream; ?>" data-header="<?php echo $show_header; ?>"></div></div>
  	<div class="clickme"></div>
	</div>

<script>
jQuery(document).ready(function() {
	jQuery('.clickme').click(function() {
  	jQuery('.box').animate({width: ['toggle', 'swing'],height: ['toggle', 'swing']}, <?php echo $speed; ?>);
	});
});
</script>
    
<?php
}

// Add action to footer 
add_action( 'wp_footer', 'add_sidetab_footer', 20);




// Some extra functions
function check_if_sidetab_setup(){
	$optionss = get_option(BE_SIDETAB_OPTION);
	if(!isset($optionss['versions'])) {
		echo '<div id="message" class="error"><p>'. __('You need to do setup.', 'beit_sidetab') .'</p></div>';
	};
}

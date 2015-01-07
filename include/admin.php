<?php
// ********************************************************************
// Display admin page
function display_sidetab_settings() {

	// Get options
	$WPlize = new WPlize(BE_SIDETAB_OPTION);


	// Save admin settings
	if (isset($_POST["update_settings"])) {  
 
 	 	if($WPlize->get_option('location')==TRUE) {
 	 		
 	 		if($WPlize->get_option('location')=='left' && $_POST['location']=='right' && strstr($_POST['img'], "facebook-left.png")) {
 	 			$img = BE_SIDETAB_URL . 'images/facebook-right.png';
 	 		} elseif($WPlize->get_option('location')=='right' && $_POST['location']=='left' && strstr($_POST['img'], "facebook-right.png")) {
 	 			$img = BE_SIDETAB_URL . 'images/facebook-left.png';
 	 		} else {
 	 			$img = esc_attr($_POST['img']);
 	 		}
 	 	
 	 	}; 		
 	 	
 	 	$WPlize->update_option(
									array(
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
										'fb_border_color' => esc_attr($_POST['fb_border_color']),
										'fb_color_scheme' => esc_attr($_POST['fb_color_scheme']),
										'bgcolor' => esc_attr($_POST['bgcolor']),
										'show_on_mobile' => esc_attr($_POST['show_on_mobile']),
										'uninstall_all' => 'true'
									));											
	
		echo '<div id="message" class="updated fade"><p>'. __('Successfylly updated') .'</p></div>';
	}
?> 

<div class=wrap>

	<?php screen_icon(); ?> <h2><?php _e('Sidetab Settings', 'beit-sidetab') ?></h2> 

	<form name="tab-form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	
	<input type="hidden" name="update_settings" value="Y" />
	
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
      	<input type="text" name="fb_data_href" id="fb_data_href" class="b-input" value="<?php echo $WPlize->get_option('fb_data_href'); ?>" />
      </td>
    </tr>

  	<tr valign="top">
    	<th scope="row">
      	<label for="url"><?php _e('FB App Id', 'beit-sidetab') ?></label>
      </th>
      <td>
      	<input type="text" name="fb_app_id" id="fb_app_id" class="b-input" value="<?php echo $WPlize->get_option('fb_app_id'); ?>" />
      </td>
    </tr>
 
  	<tr valign="top">
    	<th scope="row">
      	<label for="url"><?php _e('FB Width x Height', 'beit-sidetab') ?></label>
      </th>
      <td>
      	<input type="text" name="fb_width" id="fb_width" class="s-input" value="<?php echo $WPlize->get_option('fb_width'); ?>" /> X <input type="text" name="fb_height" id="fb_height" class="s-input" value="<?php echo $WPlize->get_option('fb_height'); ?>" />
      </td>
    </tr>
 
  	<tr valign="top">
    	<th scope="row">
      	<label for="url"><?php _e('FB Show header', 'beit-sidetab') ?></label>
      </th>
      <td>
      		<p class="field switch">
      			<?php $show_header = $WPlize->get_option('fb_show_header'); ?>
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
      			<?php $show_stream = $WPlize->get_option('fb_show_stream'); ?>
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
      			<?php $show_faces = $WPlize->get_option('fb_show_faces'); ?>      		
    				<input type="radio" id="radio5" name="fb_show_faces" value="true" <?php if($show_faces=='true') echo 'checked'; ?> />
    				<input type="radio" id="radio6" name="fb_show_faces" value="false" <?php if($show_faces=='false') echo 'checked'; ?> />
    				<label for="radio5" class="cb-enable <?php if($show_faces=='true') echo 'selected'; ?>"><span><?php _e('Enable', 'beit-sidetab') ?></span></label>
    				<label for="radio6" class="cb-disable <?php if($show_faces=='false') echo 'selected'; ?>"><span><?php _e('Disable', 'beit-sidetab') ?></span></label>
					</p>
      </td>
    </tr> 

  	<tr valign="top">
    	<th scope="row">
      	<label for="url"><?php _e('FB Color scheme', 'beit-sidetab') ?></label>
      </th>
      <td>
      		<p class="field switch">
      			<?php $color_scheme = $WPlize->get_option('fb_color_scheme'); ?>      		
    				<input type="radio" id="radio7" name="fb_color_scheme" value="light" <?php if($color_scheme=='light') echo 'checked'; ?> />
    				<input type="radio" id="radio8" name="fb_color_scheme" value="dark" <?php if($color_scheme=='dark') echo 'checked'; ?> />
    				<label for="radio7" class="cb-enable <?php if($color_scheme=='light') echo 'selected'; ?>"><span><?php _e('Light', 'beit-sidetab') ?></span></label>
    				<label for="radio8" class="cb-disable <?php if($color_scheme=='dark') echo 'selected'; ?>"><span><?php _e('Dark', 'beit-sidetab') ?></span></label>
					</p>
      </td>
    </tr>

  	<tr valign="top">
    	<th scope="row">
      	<label for="url"><?php _e('FB Border color', 'beit-sidetab') ?></label>
      </th>
      <td>
      	#<input type="text" name="fb_border_color" id="fb_border_color" class="s-input" value="<?php echo $WPlize->get_option('fb_border_color'); ?>" />
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
      			<?php $location = $WPlize->get_option('location'); ?>
    				<input type="radio" id="radio13" name="location" value="left" <?php if($location=='left') echo 'checked'; ?> />
    				<input type="radio" id="radio14" name="location" value="right" <?php if($location=='right') echo 'checked'; ?> />
    				<label for="radio13" class="cb-enable <?php if($location=='left') echo 'selected'; ?>"><span><?php _e('Left', 'beit-sidetab') ?></span></label>
    				<label for="radio14" class="cb-disable <?php if($location=='right') echo 'selected'; ?>"><span><?php _e('Right', 'beit-sidetab') ?></span></label>
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
      			<?php $action = $WPlize->get_option('action'); ?>      		
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
      			<?php $sticked = $WPlize->get_option('sticked'); ?>      	      		
    				<input type="radio" id="radio11" name="sticked" value="false" <?php if($sticked=='false') echo 'checked'; ?> />
    				<input type="radio" id="radio12" name="sticked" value="true" <?php if($sticked=='true') echo 'checked'; ?> />
    				<label for="radio11" class="cb-enable <?php if($sticked=='false') echo 'selected'; ?>"><span><?php _e('Sticked', 'beit-sidetab') ?></span></label>
    				<label for="radio12" class="cb-disable <?php if($sticked=='true') echo 'selected'; ?>"><span><?php _e('Floated', 'beit-sidetab') ?></span></label>
					</p>
      </td>
    </tr>
    
  	<tr valign="top">
    	<th scope="row">
      	<label for="url"><?php _e('Show on mobile devices', 'beit-sidetab') ?></label>
      </th>
      <td>
      		<p class="field switch">
      			<?php $show_on_mobile = $WPlize->get_option('show_on_mobile'); ?>
    				<input type="radio" id="radio20" name="show_on_mobile" value="true" <?php if($show_on_mobile=='true') echo 'checked'; ?> />
    				<input type="radio" id="radio21" name="show_on_mobile" value="false" <?php if($show_on_mobile=='false') echo 'checked'; ?> />
    				<label for="radio20" class="cb-enable <?php if($show_on_mobile=='true') echo 'selected'; ?>"><span><?php _e('Yes', 'beit-sidetab') ?></span></label>
    				<label for="radio21" class="cb-disable <?php if($show_on_mobile=='false') echo 'selected'; ?>"><span><?php _e('No', 'beit-sidetab') ?></span></label>
					</p>
      </td>
    </tr>      
    
  	<tr valign="top">
    	<th scope="row">
      	<label for="url"><?php _e('Slide speed', 'beit-sidetab') ?></label>
      </th>
      <td>
      	<input type="text" name="speed" id="speed" class="s-input" value="<?php echo $WPlize->get_option('speed'); ?>" />
      </td>
    </tr>

  	<tr valign="top">
    	<th scope="row">
      	<label for="url"><?php _e('From top position', 'beit-sidetab') ?></label>
      </th>
      <td>
      	<input type="text" name="toppos" id="toppos" class="s-input" value="<?php echo $WPlize->get_option('toppos'); ?>" />
      </td>
    </tr>

  	<tr valign="top">
    	<th scope="row">
      	<label for="url"><?php _e('Background color', 'beit-sidetab') ?></label>
      </th>
      <td>
      	#<input type="text" name="bgcolor" id="bgcolor" class="s-input" value="<?php echo $WPlize->get_option('bgcolor'); ?>" />
      </td>
    </tr>

  	<tr valign="top">
    	<th scope="row">
      	<label for="url"><?php _e('Image', 'beit-sidetab') ?></label>
      </th>
      <td>
      	<input type="text" name="img" id="img" class="b-input" value="<?php echo $WPlize->get_option('img'); ?>" />
      </td>
    </tr>

  	<tr valign="top">
    	<th scope="row">
      </th>
      <td>
      	<img src="<?php echo $WPlize->get_option('img'); ?>" />
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
}
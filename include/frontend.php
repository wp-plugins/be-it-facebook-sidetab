<?php
// Add frontend header
function beit_sidetab_frontend_head() {
	
 // Get options
 $WPlize = new WPlize(BE_SIDETAB_OPTION);

 $app_id = $WPlize->get_option('fb_app_id');
 $app_id = !empty( $app_id ) ? $app_id : 151720698324016;

 /**
 * Add Facebook javascripts
 */
	echo '<div id="fb-root"></div>
		<script>(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId='. $app_id .'&version=v2.0";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, \'script\', \'facebook-jssdk\'));</script>';
}



// Add frontend footer
function beit_sidetab_frontend_footer() {

	// Get option
	$WPlize = new WPlize(BE_SIDETAB_OPTION);
	
	// Get img width and height
  list($img_width, $img_height, $img_type, $img_attr) = getimagesize($WPlize->get_option('img'));

  if($WPlize->get_option('fb_border_color')==TRUE){
	  $border_color = 'data-border-color="#'. $WPlize->get_option('fb_border_color') .'"';
  }

  if($WPlize->get_option('fb_color_scheme')=='dark'){
 	 	$color_scheme = ' data-colorscheme="dark" ';
 	 	$fb_bg_color = '000';
  }  else {
	  $fb_bg_color = 'FFF';
  }
?>
<script type="text/javascript">
jQuery(function(){
  	jQuery('#be-it-sidetab').tabSlideOut({
       tabHandle: '.side-tab-clickme',           								//class of the element that will become your tab
       pathToTabImage: '<?php echo $WPlize->get_option('img'); ?>', 			//path to the image for the tab 
       imageHeight: '<?php echo $img_height; ?>px',  							//height of tab image           
       imageWidth: '<?php echo $img_width; ?>px',   							//width of tab image     
       tabLocation: '<?php echo $WPlize->get_option('location'); ?>',  			//side of screen where tab lives, top, right, bottom, or left
       speed: <?php echo $WPlize->get_option('speed'); ?>,             			//speed of animation
       action: '<?php echo $WPlize->get_option('action'); ?>',         			//options: 'click' or 'hover', action to trigger animation
       topPos: '<?php echo $WPlize->get_option('toppos'); ?>px',       			//position from the top/ use if tabLocation is left or right
       leftPos: '20px',                          														//position from left/ use if tabLocation is bottom or top
       fixedPosition: <?php echo $WPlize->get_option('sticked'); ?>    			//options: true makes it stick(fixed position) on scroll
     });
});
</script>

<style type="text/css">
	#be-it-sidetab {
		z-index: 999999;
		background: #<?php echo $WPlize->get_option('bgcolor'); ?>;
		padding: 0 5px;
	}      
	
	#be-it-sidetab .side-tab-bg-box {
	  	padding: 5px 5px 10px 5px;
	}
	
	#be-it-sidetab .fb-like-box {
	    background: #<?php echo $fb_bg_color; ?>;
	  	width: <?php echo $WPlize->get_option('fb_width'); ?>px;
	  	height: <?php echo $WPlize->get_option('fb_height'); ?>px;	
	  	overflow: hidden;       
	} 
</style>

<div id="be-it-sidetab">
			<div class="side-tab-bg-box">
				<div class="fb-like-box" data-href="<?php echo $WPlize->get_option('fb_data_href'); ?>" 
																 data-width="<?php echo $WPlize->get_option('fb_width'); ?>" 
																 data-height="<?php echo $WPlize->get_option('fb_height'); ?>" 
																 <?php if(isset($color_scheme)) echo $color_scheme; ?>
																 <?php if(isset($border_color)) echo $border_color; ?>
																 data-show-faces="<?php echo $WPlize->get_option('fb_show_faces'); ?>" 
																 data-stream="<?php echo $WPlize->get_option('fb_show_stream'); ?>" 
																 data-header="<?php echo $WPlize->get_option('fb_show_header'); ?>">
				</div>
			</div>
  		<div class="side-tab-clickme"></div>
</div>
    
<?php
}




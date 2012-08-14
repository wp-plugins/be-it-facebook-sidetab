<?php
	/*
	** Dynamic CSS page
	*/
	
   header("Content-type: text/css; charset: UTF-8");
   
?>


#be-it-sidetab {
	z-index: 999999;
	background: #<?php print $_GET['bgcolor']; ?>; /*  #3b62a7 */
	padding: 0 5px;
}      

#be-it-sidetab .side-tab-bg-box {
  	padding: 5px 5px 10px 5px;
}

#be-it-sidetab .fb-like-box {
    background: #<?php print $_GET['fb_bgcolor']; ?>;
		overflow: hidden;  
  	width: <?php print $_GET['width']; ?>px;
  	height: <?php print $_GET['height']; ?>px;	      
} 

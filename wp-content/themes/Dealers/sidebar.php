<div id="sidebar">
	<?php if ( function_exists ( dynamic_sidebar() ) ) : 
				dynamic_sidebar (); 
			endif; 
			comment_form();
			?>
	
</div> <!--close sidebar-->
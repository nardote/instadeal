<?php

        if(function_exists('register_sidebar')){
		register_sidebar(array(
						'name'          => 'Footer Widget 1',
						'before_widget' => '<div class="footer_box-down %s"><div class="widget-bg-top"></div>',
						'after_widget'  => '<div class="widget-bg-down"></div></div>',
						'before_title'  => '<div class="footer-widget-title"><h3>',
						'after_title'   => '</h3></div>' )
						);
	}

	if(function_exists('register_sidebar')){
		register_sidebar(array(
						'name'          => 'Footer Widget 2',
						'before_widget' => '<div class="footer_box-down %s"><div class="widget-bg-top"></div>',
						'after_widget'  => '<div class="widget-bg-down"></div></div>',
						'before_title'  => '<div class="footer-widget-title"><h3>',
						'after_title'   => '</h3></div>' )
						);
	}

	if(function_exists('register_sidebar')){
		register_sidebar(array(
						'name'          => 'Footer Widget 3',
						'before_widget' => '<div class="footer_box-down %s"><div class="widget-bg-top"></div>',
						'after_widget'  => '<div class="widget-bg-down"></div></div>',
						'before_title'  => '<div class="footer-widget-title"><h3>',
						'after_title'   => '</h3></div>' )
						);
	}


	$dynamic_sidebar = get_option(THEME_NAME."_sidebar");

	$dynamic_sidebar = unserialize($dynamic_sidebar);

		if(!empty($dynamic_sidebar))
		{
			foreach($dynamic_sidebar as $sidebar)
			{
				if ( function_exists('register_sidebar') )
			    register_sidebar(array('name' => $sidebar,'before_widget' => '<span class="sidebar_widget_holder %s">',
						'after_widget'  => '</span>',
						'before_title'  => '<h2 class="sidebar_widgettitle">',
						'after_title'   => '</h2>'));
			}
		}


?>
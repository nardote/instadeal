<?php if (!session_id())
    session_start();

/**
 * @package WordPress
 * @subpackage Dealers
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


        <title><?php if(!empty($data['seo_title'])) { echo $data['seo_title']; } else { wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); }?></title>
	<meta name="keywords" content="<?php if(!empty($data['seo_keywords'])) { echo $data['seo_keywords'];} ?>" />
	<meta name="description" content="<?php if(!empty($data['seo_description'])) { echo $data['seo_description']; } else { bloginfo('description'); }?>" />
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />


<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />


<link rel="stylesheet" media="screen" href="<?php echo get_template_directory_uri() . "/script/superfish/superfish.css"; ?>" type="text/css"/>
<link rel="stylesheet" media="screen" href="<?php echo get_template_directory_uri() . "/script/datepicker/css/smoothness/jquery-ui-1.8.16.custom.css"; ?>" type="text/css"/>
<link rel="stylesheet" media="screen" href="<?php echo get_template_directory_uri() . "/script/countdown/jquery.countdown.css"; ?>" type="text/css"/>




                        <?php
                        $browser = $_SERVER['HTTP_USER_AGENT'];

                        if (strpos($browser, 'Safari')) {
                            ?>
                        <link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/browsers/safari.css'; ?>" type="text/css" />
                            <?php
                        }
                        if (strpos($browser, 'MSIE 8.0')) {
                            ?>
                        <link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/browsers/ie8.css'; ?>" type="text/css" />
                            <?php
                        }

                        if (strpos($browser, 'MSIE 9.0')) {
                            ?>
                        <link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/browsers/ie.css'; ?>" type="text/css" />
                            <?php
                        }

                        if (strpos($browser, 'Chrome')) {
                            ?>
                        <link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/browsers/chrome.css'; ?>" type="text/css" />
                            <?php
                        }

                        if (strpos($browser, 'pera')) {
                            ?>
                        <link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/browsers/opera.css'; ?>" type="text/css" />
                        <script type="text/javascript">
                            jQuery(document).ready(function(){
                                jQuery('#wp-calendar').attr('style','height:200px!important;');


                            });
                        </script>
                            <?php
                        }
                        ?>


                          <?php
                                $ua = $_SERVER["HTTP_USER_AGENT"];
                                // Macintosh
                                $mac = strpos($ua, 'Macintosh') ? true : false;
                                // Windows
                                $win = strpos($ua, 'Windows') ? true : false;
                                        $browser =  $_SERVER['HTTP_USER_AGENT'];
                                        if(!empty($win)) {
                                        if($win == Windows) {

                                    if (strpos($browser, 'Firefox')) {
                                            ?>
                                        <link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/browsers/ff4.css'; ?>" type="text/css" />
                                        <?php
                                            }
                                                }

                                    if (strpos($browser, 'pera')) {
                                    ?>
                                    <link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/browsers/operawin.css'; ?>" type="text/css" />
                                    <script type="text/javascript">
                                        jQuery(document).ready(function(){
                                            jQuery('#wp-calendar').attr('style','height:200px!important;');
                                        });
                                    </script>
                                        <?php }
                                                    } ?>



	<!-- Favicon -->
	<?php $favicon = get_option(THEME_NAME.'_custom_favicon'); if(empty($favicon)) { $favicon = get_template_directory_uri()."/images/favicon.png"; }?>
	<link rel="shortcut icon" href="<?php echo $favicon;?>" />

<?php 
   wp_deregister_script('jquery');
    wp_register_script('jquery', get_template_directory_uri().'/script/jquery/jquery-1.6.2.min.js');
    wp_enqueue_script('jquery');
    wp_enqueue_script('superfish', get_template_directory_uri().'/script/superfish/superfish.js' );
    wp_enqueue_script('ajaxpager', get_template_directory_uri() . '/script/quickpager/quickpager.jquery.js');
    wp_enqueue_script('my-commons', get_template_directory_uri().'/script/common.js' );
    wp_enqueue_script('jquery-ui', get_template_directory_uri().'/script/jqueryui/jquery-ui-1.8.16.custom.min.js' );
    wp_enqueue_script('easing', get_template_directory_uri().'/script/easing/jquery.easing.1.3.js' );
    wp_enqueue_script('countdown', get_template_directory_uri().'/script/countdown/jquery.countdown.js' );
    wp_enqueue_script('datepicker', get_template_directory_uri().'/script/datepicker/js/jquery-ui-1.8.16.custom.min.js' );

    if (is_singular())
        wp_enqueue_script("comment-reply");
    
    ?>

        <?php wp_head();
                remove_filter ('the_content',  'wpautop');
                remove_filter ('comment_text', 'wpautop');
                remove_filter('the_content', 'wptexturize');
                remove_filter('the_excerpt', 'wptexturize');
                remove_filter('comment_text', 'wptexturize');
                $twitter = get_option(THEME_NAME.'_footer_twitter');
        ?>



        <?php
        
         $g_analitics = stripslashes(get_option(THEME_NAME.'_google_analitics'));

         if( isset ($g_analitics) && $g_analitics != ''){
             echo $g_analitics;
         }
         
        ?>

</head>
       <?php $the_background = get_option(THEME_NAME.'_Colorpicker'); if ($the_background == ''){$the_background = '#e8eff0';}?>
    <body <?php $class='body';
       body_class( $class ); ?>>

        <div id="fb-root"></div>
        <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

        <div id="container">



        <!------ HEADER ------>
        <div class="header">
            <div class="wrapper-header">

            <div class="header-left">

                    <?php $logo = get_option(THEME_NAME.'_custom_logo');
                    if(empty($logo)) {
                        $logo = get_template_directory_uri()."/images/logo.png";
                    }?>
                    <a href="<?php echo home_url(); ?>"><div class="logo left" style="background-image: url(<?php echo $logo;?>)"></div></a>


                <script type="text/javascript">
                     //Sub menu tyle
                    jQuery('ul.menu li').each(function(){
                        var changer = $(this).html();
                        $(this).html('').append('<div class="nav-div"><div class="nav-left"></div><div class="nav-center">'+changer+'</div><div class="nav-right"></div></div>');
                    })    
                </script>

                

            </div>

                <div class="header-right">
                    <?php
                         if ( function_exists('has_nav_menu') && has_nav_menu('primary-menu') ) {
                                    $nav_menu = array('title_li'=> __(''), 'theme_location' => 'primary-menu');
                                    wp_nav_menu($nav_menu);
                         }else { 
                             $all_deals_link = get_permalink(get_option('custom-all-deals-id'));
                             $submit_deal_link = get_permalink(get_option('custom-submit-id'));
                             
                             ?>
                        <?php
                         $querystr = "
                                SELECT $wpdb->posts.* 
                                FROM $wpdb->posts, $wpdb->postmeta
                                WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id 
                                AND $wpdb->postmeta.meta_key  = 'featuredeal' 
                                AND $wpdb->postmeta.meta_value  = 'yes' 

                                ORDER BY $wpdb->posts.post_date DESC
                             ";

                                $pageposts = $wpdb->get_results($querystr);
                        
                        ?>
                    
                    <a class="log_in_link" href="<?php echo $all_deals_link?>">All Deals</a><span class="log_in_link"> | </span>
                         <a class="log_in_link" href="<?php echo get_permalink($pageposts[0]->ID)?>">Featured Deal</a><span class="log_in_link"> | </span>
                         <a class="log_in_link" href="<?php get_site_url(); ?>?page_id=8">Help?</a>
                         <!--<a class="log_in_link" href="<?php echo $submit_deal_link?>">Submit Deal</a>-->
                         <div class="search-header">
                            <form role="search" method="get" id="searchform" action="">
                               <div>
                                   <input type="text" value="SEARCH YOUR DEAL..." name="s" id="s"  onfocus="if(!this.haswriting){this.style.color='#333'; this.value='';}" onblur="if(!this.value){this.style.color='#333'; this.value='SEARCH YOUR DEAL...'; this.haswriting=false;}else{this.haswriting=true};"/>
                                   <input type="submit" id="searchsubmit" value="Buscar"  />
                               </div>
                            </form>
                         </div>
                    <?php
                                            }
                      global $wpdb;

                      $querystr = "SELECT ID FROM ".$wpdb->prefix."posts WHERE post_type = 'page' AND post_status = 'publish'";

                                    $pageposts = $wpdb->get_results($querystr, OBJECT);

                                    foreach($pageposts as $post){

                                    $check_templates = get_post_meta($post->ID, '_wp_page_template', true);

                                    if ($check_templates == '_contact.php'){
                                        $contact_id = $post->ID;
                                        $contact_link = get_permalink( $contact_id );
                                    }

                                    }
                                    wp_reset_query();
                    ?>

                    <?php
                    //Link for mY profile/ Log in

                    if ( is_user_logged_in() ) {
                        $log_in_link =  home_url().'/my-profile/';
                        $log_in_value = 'My Profile';
                    }else{
                        $log_in_link =  home_url().'/wp-admin/';
                        $log_in_value = 'Log In';
                    }
                    ?>

                  <!--  <a class="log_in_link" href="<?php echo $log_in_link ?>"><?php echo $log_in_value ?></a>-->
                  <!--  <div class="contact-nav" ><a href="<?php echo $contact_link ?>"><img src="<?php echo get_template_directory_uri()?>/style/img/menu-contact.png" alt="images" title="Contact Us" /></a></div>-->




                    <?php

                    $use_sendloop = get_option(THEME_NAME.'_use_sendloop');
                    $use_mailchimp = get_option(THEME_NAME.'_use_mailchimp');

                    if ( 1==1){

                    $sendloop_username = get_option(THEME_NAME.'_sendloop_user');
                   // $sendloop_list_id = get_option(THEME_NAME.'_sendloop_list_id');

                        
                         if($_POST['mail']) {
                           //  echo $sendloop_username."---";
                                mail( $sendloop_username, 'Email from page', $_POST['mail']);
                            echo '<script>alert("Thank you for subscribe");</script>';
                        }
                        
                     ?>

             <!-- Sendloop -->
                     <div class="header-right-background">
                        <span>Sign up for free to get deals directly to your mailbox &raquo;</span>

                        <!--SEARCH-->
                        <script>
                            $(function () {
                                
                                $("#emailsend").submit(function () {
                                    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                                    if( !emailReg.test( $('#emailaddress').val() ) ) {
                                      alert("Your Email address is invalid.")
                                      return false;
                                    } else {
                                      return true;
                                    }

                                })
                            })
                        
                        </script>
                        

                                <form action="" method="post" id="emailsend">
                                    <input type="text" name="mail" value="" id="emailaddress" class="newsletter_email"/>
                                    <input type="submit" name="FormButton_Subscribe" value="SUBSCRIBE NOW" id="FormButton_Subscribe" class="btn btn-bordo submit-email"/>
                                    
                                </form>

                    </div><!--search-header-->

                 
                    <?php  } elseif ($use_mailchimp == 1){ ?>

                    <div class="header-right-background">
                        <span>Sign up for free to get deals directly to your mailbox</span>

                        <!--SEARCH-->
                        <div class="search-header">
                            <div class="sidebar_widget_holder">

                                <?php get_template_part('script/mailchimp/mailchimp')?>

                            </div>
                        </div><!--/sidebar_widget_holder-->
                    </div><!--search-header-->

                    <div class="pecat"></div>

                    <?php } elseif ($use_sendloop == 0 && $use_mailchimp == 0){}  ?>

                </div><!--header-right-background-->
                <div style="clear:both"></div>
                
            </div><!-- #header -->
           
            
        </div><!-- #header-wrapper -->
        

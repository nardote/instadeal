<?php
function my_function_admin_bar(){ return false; }
add_filter( 'show_admin_bar' , 'my_function_admin_bar');

//Define constants:
define('GD_FUNCTIONS', TEMPLATEPATH . '/admin/');
define('GD_WIDGETS', TEMPLATEPATH . '/admin/widgets/');
define('SCRIPTS', get_template_directory_uri() . '/script/');
define('GD_THEME_DIR', get_template_directory_uri());
define('AJAX_FUNCTIONS', get_template_directory_uri().'/lib/');
define('GD_MAINMENU_NAME', 'general-options');
define('THEME_NAME','Dealers');
define('THEME_VERSION','v.1.0.');
define('GD_THEME', THEME_NAME);
define('GD_SHORT', THEME_NAME.'_');
define('GD_THEME_VERSION', '1.0');
define('GD_SITE_URL', get_site_url());
update_option('THEME_NAME',THEME_NAME);
update_option('THEME_VERSION',THEME_VERSION);


        function tk_add_scripts() {
            wp_enqueue_script('jquery');
            wp_enqueue_script('jqueryui', get_template_directory_uri().'/admin/admin_js/datepicker/js/jquery-ui-1.8.16.custom.min.js' );
            
            if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
        }  
        add_action('wp_enqueue_scripts', 'tk_add_scripts');          



	require_once (GD_FUNCTIONS . 'functions.php');
	//Load admin specific files:
	if (is_admin()) :
		require_once (GD_FUNCTIONS . 'functions/meta-functions.php');
		require_once (GD_FUNCTIONS . 'functions/ajax-image.php');
		require_once (GD_FUNCTIONS . 'functions/admin-helper.php');
		require_once (GD_FUNCTIONS . 'functions/adding_menu.php');
		require_once (GD_FUNCTIONS . 'functions/helpers.php');
		require_once (GD_FUNCTIONS . 'theme.php');
        endif;

	//Register sidebar
	require_once (GD_FUNCTIONS . 'functions/register_sidebar.php');

        //Load widgets:
	require_once (GD_WIDGETS . 'widget-twitter.php');

	//Load helpers:
	require_once (GD_FUNCTIONS . 'functions/helpers.php');
	require_once (GD_FUNCTIONS . 'functions/shortcodes.php');


	if ( function_exists( 'register_nav_menu' ) ) {
		register_nav_menu( 'primary-menu', 'Primary menu for your site' );
	}

	function install_coupons () {
	      global $wpdb;
	      global $ratings_db_version;
	      $table_name = $wpdb->prefix . THEME_NAME."_coupons";
	      if($wpdb->get_var("show tables like '$table_name'") != $table_name) {

	         $sql = "CREATE TABLE " . $table_name . " (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
                                postid int(10) NOT NULL,
				coupon varchar(250) NOT NULL,
				e_mail varchar(250) NOT NULL,
                                available tinyint(1) default 1,
				UNIQUE KEY id (id)
				);";

	         require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	         dbDelta($sql);

	   		add_option(THEME_NAME."_db_version",  $ratings_db_version);
	      }
	   }
	   install_coupons();

	function install_withdrawals () {
	      global $wpdb;
	      global $ratings_db_version;
	      $table_name = $wpdb->prefix . THEME_NAME."_withdrawals";
	      if($wpdb->get_var("show tables like '$table_name'") != $table_name) {

	         $sql = "CREATE TABLE " . $table_name . " (
                        `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                        `user_id` INT( 10 ) NOT NULL ,
                        `request_date` TIMESTAMP NULL DEFAULT NULL ,
                        `request_amount` DOUBLE( 16, 2 ) NOT NULL ,
                        `user_balance` DOUBLE( 16, 2 ) NOT NULL ,
                        `user_paypal` VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
                        `payment_status` TINYINT( 1 ) NOT NULL DEFAULT '0'
				);";

	         require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	         dbDelta($sql);

	   		add_option(THEME_NAME."_db_version",  $ratings_db_version);
	      }
	   }
	   install_withdrawals();



	remove_filter( 'the_content', 'wpautop' );


        add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );



        add_action( 'login_enqueue_scripts', 'login_enqueue_scripts' );
        function login_enqueue_scripts() {
            $logo = get_template_directory_uri()."/images/logo.png";
            $the_background = get_option(THEME_NAME.'_Colorpicker'); if ($the_background == ''){$the_background = '#e8eff0';}
            echo '<link rel="stylesheet" href="'.get_template_directory_uri().'/style/login.css" type="text/css" />';
            echo '<style type="text/css" media="screen">';
            echo '.login h1 a{
            background: url("'.$logo.'") no-repeat scroll center top transparent;
            display: block;
            height: 67px;
            overflow: hidden;
            padding-bottom: 15px;
            text-indent: -9999px;
            width: 326px;
        }';
            echo 'body.login{background-color:'.$the_background.'}';
            echo '</style>';
        }


$wp_tz = get_option('gmt_offset');
if($wp_tz >0){
    date_default_timezone_set('Etc/GMT+'.$wp_tz);
}else{
    date_default_timezone_set('Etc/GMT'.$wp_tz);
}

       // date_default_timezone_set(get_option('timezone_string'));


        function get_current_user_role () {
            global $current_user;
            get_currentuserinfo();
            $user_roles = $current_user->roles;
            $user_role = array_shift($user_roles);
            return $user_role;
        };


            function tk_login_redirect() {
                if ( is_user_logged_in() ) {
                $current_user = wp_get_current_user();
                if( ((get_current_user_role ()) != 'administrator')) {
                echo "<script type=\"text/javascript\">
                        window.location = '".$my_profile_link."'
                        </script>";
                }
            }
        }
        add_action('login_head', 'tk_login_redirect', 1);



        function tk_admin_redirect() {
            if ( get_current_user_role () != 'administrator' ) {

                global $wpdb;

                $querystr = "SELECT ID FROM ".$wpdb->prefix."posts WHERE post_type = 'page' AND post_status = 'publish'";

                $pageposts = $wpdb->get_results($querystr, OBJECT);

                foreach($pageposts as $post){

                $check_templates = get_post_meta($post->ID, '_wp_page_template', true);

                if ($check_templates == '_my_profile.php'){
                    $my_profile_id = $post->ID;
                    $my_profile_link = get_permalink( $my_profile_id );
                }

                }


                echo "<script type=\"text/javascript\">
                        window.location = '".$my_profile_link."'
                        </script>";
            }
        }
        add_action('admin_head', 'tk_admin_redirect', 99);



/*FRONT END POST*/
function insert_attachment($file_handler,$post_id,$setthumb='false') {
	// check to make sure its a successful upload
    
    if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();

    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
    require_once(ABSPATH . "wp-admin" . '/includes/file.php');
    require_once(ABSPATH . "wp-admin" . '/includes/media.php');

    $brojac=1;
    foreach ($_FILES as $file => $array) {
    $attach_id = media_handle_upload( $file, $post_id );
    add_post_meta($post_id, 'image_'.$brojac, $attach_id);
    $brojac++;
    }

    return $attach_id;
}



function new_post_type() {
    register_post_type( 'deals',
        array(
            'labels' => array(
                    'name' => _x('Deals', 'deals'),
                    'singular_name' => _x('Deals ', 'deals'),
                    'add_new' => _x('Add New Deal', 'support'),
                    'add_new_item' => __('Add New Deal'),
                    'edit_item' => __('Edit Deal'),
                    'new_item' => __('New Deal'),
                    'all_items' => __('All Deals'),
                    'view_item' => __('View Deal'),
                    'search_items' => __('Search Deal'),
                    'not_found' =>  __('No Deals  found'),
                    'not_found_in_trash' => __('No Deals found in Trash'),
                    'parent_item_colon' => '',
                    'menu_name' => 'Deals'
            ),
            'public' => true,
            'supports' => array( 'title', 'editor', 'author', 'excerpt', 'comments' ),
            'taxonomies' => array('category', 'post_tag'), 
            'capability_type' => 'post',
            'rewrite' => array("slug" => "deals"), // Permalinks format
            'menu_position' => 5,
            'register_meta_box_cb' => 'add_deals_metaboxes'
        )
    );
}

add_action( 'init', 'new_post_type' );

function add_deals_metaboxes() {
    add_meta_box('wpt_events_location', 'Deal Options', 'wpt_events_location', 'deals', 'side', 'high');
}

// The Event Location Metabox

function wpt_events_location() {
    global $post;

    // Noncename needed to verify where the data originated
    echo '<input type="hidden" name="eventmeta_noncename" id="eventmeta_noncename" value="' .
    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';

    // Get the location data if its already been entered
        $deal_owner = get_post_meta($post->ID, 'deal_owner', true);
        $real_price = get_post_meta($post->ID, 'real_price', true);
        $discount_price = get_post_meta($post->ID, 'discount_price', true);
        $deal_percentage = get_post_meta($post->ID, 'deal_percentage', true);
        $start_date = get_post_meta($post->ID, 'start_date', true);
        $end_date = get_post_meta($post->ID, 'end_date', true);
        $deal_type = get_post_meta($post->ID, 'deal_type', true);
        
        $youtube = get_post_meta($post->ID, 'youtube', true);
        $latitud = get_post_meta($post->ID, 'latitud', true);
        $longitud = get_post_meta($post->ID, 'longitud', true);
        $maindeal = get_post_meta($post->ID, 'maindeal', true);
        $featuredeal = get_post_meta($post->ID, 'featuredeal', true);
        $address = get_post_meta($post->ID, 'address', true);
        $tel = get_post_meta($post->ID, 'tel', true);
        $email = get_post_meta($post->ID, 'email', true);
        
        
        
        $upload_dir = wp_upload_dir();
        
        $deal_image_1_id = get_post_meta($post->ID, 'image_1', true);
        $deal_image_2_id = get_post_meta($post->ID, 'image_2', true);
        $deal_image_3_id = get_post_meta($post->ID, 'image_3', true);
        $deal_image_4_id = get_post_meta($post->ID, 'image_4', true);
        $deal_image_5_id = get_post_meta($post->ID, 'image_5', true);
        $deal_image_6_id = get_post_meta($post->ID, 'image_6', true);
        $deal_image_7_id = get_post_meta($post->ID, 'image_7', true);
        $deal_image_8_id = get_post_meta($post->ID, 'image_8', true);
        $deal_image_9_id = get_post_meta($post->ID, 'image_9', true);
        $deal_image_10_id = get_post_meta($post->ID, 'image_10', true);
        $deal_image_11_id = get_post_meta($post->ID, 'image_11', true);
        
        $deal_image_1 = get_post_meta($post->ID, '_wp_attached_file_1', true);
        $deal_image_2 = get_post_meta($post->ID, '_wp_attached_file_2', true);
        $deal_image_3 = get_post_meta($post->ID, '_wp_attached_file_3', true);
        $deal_image_4 = get_post_meta($post->ID, '_wp_attached_file_4', true);
        $deal_image_5 = get_post_meta($post->ID, '_wp_attached_file_5', true);
        $deal_image_6 = get_post_meta($post->ID, '_wp_attached_file_6', true);
        $deal_image_7 = get_post_meta($post->ID, '_wp_attached_file_7', true);
        $deal_image_8 = get_post_meta($post->ID, '_wp_attached_file_8', true);
        $deal_image_9 = get_post_meta($post->ID, '_wp_attached_file_9', true);
        $deal_image_10 = get_post_meta($post->ID, '_wp_attached_file_10', true);
        $deal_image_11 = get_post_meta($post->ID, '_wp_attached_file_11', true);
        
        
        
        $deal_file_1_id = get_post_meta($post->ID, 'file_1', false);
         if(!isset($deal_file_1_id[0])) {
            add_post_meta($post->ID, 'file_1', $post->ID);                  
        }
        $deal_file_2_id = get_post_meta($post->ID, 'file_2', false);
         if(!isset($deal_file_2_id[0])) {
            add_post_meta($post->ID, 'file_2', $post->ID);                  
        }
        $deal_file_3_id = get_post_meta($post->ID, 'file_3', false);
         if(!isset($deal_file_3_id[0])) {
            add_post_meta($post->ID, 'file_3', $post->ID);                  
        }
        $deal_file_4_id = get_post_meta($post->ID, 'file_4', false);
        if(!isset($deal_file_4_id[0])) {
            add_post_meta($post->ID, 'file_4', $post->ID);                  
        }
        $deal_file_5_id = get_post_meta($post->ID, 'file_5', false);
        if(!isset($deal_file_5_id[0])) {
            add_post_meta($post->ID, 'file_5', $post->ID);                  
        }
        $deal_file_1 = get_post_meta($post->ID, '_wp_attached_file_12', false);
         if(!isset($deal_file_1[0])) {
            add_post_meta($post->ID, '_wp_attached_file_12', null);                  
        }
        $deal_file_2 = get_post_meta($post->ID, '_wp_attached_file_13', false);
         if(!isset($deal_file_2[0])) {
            add_post_meta($post->ID, '_wp_attached_file_13', null);                  
        }
        $deal_file_3 = get_post_meta($post->ID, '_wp_attached_file_14', false);
         if(!isset($deal_file_3[0])) {
            add_post_meta($post->ID, '_wp_attached_file_14', null);                  
        }
        $deal_file_4 = get_post_meta($post->ID, '_wp_attached_file_15', false);
        if(!isset($deal_file_4[0])) {
            add_post_meta($post->ID, '_wp_attached_file_15', null);                  
        }
        $deal_file_5 = get_post_meta($post->ID, '_wp_attached_file_16', false);
        if(!isset($deal_file_5[0])) {
            add_post_meta($post->ID, '_wp_attached_file_16', null);                  
        }
     
      

         /*   $check_dummy_1 = strpos($deal_image_1, 'images/dummy');
            if($check_dummy_1 == false){
                $check_image_1 = strpos($deal_image_1, 'wp-content/uploads');
                if($check_image_1 == false){
                    $deal_image_1 = $upload_dir['baseurl'].'/'.$deal_image_1;
                }
            }else{
                $deal_image_1= get_template_directory_uri().'/images/dummy/red.png';
            }
            


            $check_dummy_2 = strpos($deal_image_2, 'images/dummy');
            if($check_dummy_2 == false){
                $check_image_2 = strpos($deal_image_2, 'wp-content/uploads');
                if($check_image_2 == false){
                    $deal_image_2 = $upload_dir['baseurl'].'/'.$deal_image_2;
                }
            }else{
                $deal_image_2= get_template_directory_uri().'/images/dummy/red.png';
            }
            
            $check_dummy_3 = strpos($deal_image_3, 'images/dummy');
            if($check_dummy_3 == false){
                $check_image_3 = strpos($deal_image_3, 'wp-content/uploads');
                if($check_image_3 == false){
                    $deal_image_3 = $upload_dir['baseurl'].'/'.$deal_image_3;
                }
            }else{
                $deal_image_3= get_template_directory_uri().'/images/dummy/red.png';
            }
            
            $check_dummy_4 = strpos($deal_image_4, 'images/dummy');
            if($check_dummy_4 == false){
                $check_image_4 = strpos($deal_image_4, 'wp-content/uploads');
                if($check_image_4 == false){
                    $deal_image_4 = $upload_dir['baseurl'].'/'.$deal_image_4;
                }
            }else{
                $deal_image_4= get_template_directory_uri().'/images/dummy/red.png';
            }
            
            $check_dummy_5 = strpos($deal_image_5, 'images/dummy');
            if($check_dummy_5 == false){
                $check_image_5 = strpos($deal_image_5, 'wp-content/uploads');
                if($check_image_5 == false){
                    $deal_image_5 = $upload_dir['baseurl'].'/'.$deal_image_5;
                }
            }else{
                $deal_image_5= get_template_directory_uri().'/images/dummy/red.png';
            }
            
            $check_dummy_6 = strpos($deal_image_6, 'images/dummy');
            if($check_dummy_6 == false){
                $check_image_6 = strpos($deal_image_6, 'wp-content/uploads');
                if($check_image_6 == false){
                    $deal_image_6 = $upload_dir['baseurl'].'/'.$deal_image_6;
                }
            }else{
                $deal_image_6= get_template_directory_uri().'/images/dummy/red.png';
            }
            
            $check_dummy_7 = strpos($deal_image_7, 'images/dummy');
            if($check_dummy_7 == false){
                $check_image_7 = strpos($deal_image_7, 'wp-content/uploads');
                if($check_image_7 == false){
                    $deal_image_7 = $upload_dir['baseurl'].'/'.$deal_image_7;
                }
            }else{
                $deal_image_7= get_template_directory_uri().'/images/dummy/red.png';
            }
            
            $check_dummy_8 = strpos($deal_image_8, 'images/dummy');
            if($check_dummy_8 == false){
                $check_image_8 = strpos($deal_image_8, 'wp-content/uploads');
                if($check_image_8 == false){
                    $deal_image_8 = $upload_dir['baseurl'].'/'.$deal_image_8;
                }
            }else{
                $deal_image_8= get_template_directory_uri().'/images/dummy/red.png';
            }
            
            $check_dummy_9 = strpos($deal_image_9, 'images/dummy');
            if($check_dummy_9 == false){
                $check_image_9 = strpos($deal_image_9, 'wp-content/uploads');
                if($check_image_9 == false){
                    $deal_image_9 = $upload_dir['baseurl'].'/'.$deal_image_9;
                }
            }else{
                $deal_image_9= get_template_directory_uri().'/images/dummy/red.png';
            }
            
            $check_dummy_10 = strpos($deal_image_10, 'images/dummy');
            if($check_dummy_10 == false){
                $check_image_10 = strpos($deal_image_10, 'wp-content/uploads');
                if($check_image_10 == false){
                    $deal_image_10 = $upload_dir['baseurl'].'/'.$deal_image_10;
                }
            }else{
                $deal_image_10= get_template_directory_uri().'/images/dummy/red.png';
            }
            
            $check_dummy_11 = strpos($deal_image_11, 'images/dummy');
            if($check_dummy_11 == false){
                $check_image_11 = strpos($deal_image_11, 'wp-content/uploads');
                if($check_image_11 == false){
                    $deal_image_11 = $upload_dir['baseurl'].'/'.$deal_image_11;
                }
            }else{
                $deal_image_11= get_template_directory_uri().'/images/dummy/red.png';
            }*/

      
        if( $deal_type == 'digital'){
            $digital_type = 'selected';
        }else{$digital_type = '';}

        if($deal_type == 'custom'){
            $custom_type = 'selected';
        }else{$custom_type = '';}

        if($deal_type == 'coupon'){
            $coupon_type = 'selected';
        }else{$coupon_type = '';}

        $deal_info = get_post_meta($post->ID, 'deal_info', true);

    // Echo out the field
        echo '<p>Deal owner:</p>';
        echo '<input type="text" name="deal_owner" value="' . $deal_owner  . '" class="widefat" />';
        echo '<p>Regular price (Deal value):</p>';
        echo '<input type="text" name="real_price" value="' . $real_price  . '" class="widefat" />';
        echo '<p>Discounted price:</p>';
        echo '<input type="text" name="discount_price" value="' . $discount_price  . '" class="widefat" />';
        echo '<p>How much in % goes to deal owner:</p>';
        echo '<input type="text" name="deal_percentage" value="' . $deal_percentage  . '" class="widefat" />';
        echo '<p>Deal start date:</p>';
        echo '<input type="text" name="start_date" value="' . $start_date  . '" class="widefat" id="start_date"/>';
        echo '<p>Deal end date:</p>';
        echo '<input type="text" name="end_date" value="' . $end_date  . '" class="widefat" id="end_date" />';
        echo '<p>Deal type:</p>';
        echo '<select name="deal_type" style="width:100%;">
                        <option '.$digital_type.'  value="digital">Digital Download Deal</option>
                        <option '.$custom_type.' value="custom">Custom Link Deal</option>
                        <option '.$coupon_type.' value="coupon">Coupon Deal</option>
                    </select>';
        echo '<p>Deal information:</p>';
        echo '<textarea name="deal_info" id="deal_info">' . $deal_info  . '</textarea>';
        echo '<p>Deal Image Large:</p>';
        echo '<input type="text" name="deal_image_1" value="' . $deal_image_1  . '" class="widefat" id="deal_image_1" />';
        echo '<p>Deal Image Small:</p>';
        echo '<input type="text" name="deal_image_2" value="' . $deal_image_2  . '" class="widefat" id="deal_image_2" />';
        echo '<p>Deal Image 2 Large:</p>';
        echo '<input type="text" name="deal_image_3" value="' . $deal_image_3  . '" class="widefat" id="deal_image_3" />';
        echo '<p>Deal Image 3 Large:</p>';
        echo '<input type="text" name="deal_image_4" value="' . $deal_image_4  . '" class="widefat" id="deal_image_4" />';
        echo '<p>Deal Image 4 Large:</p>';
        echo '<input type="text" name="deal_image_5" value="' . $deal_image_5  . '" class="widefat" id="deal_image_5" />';
        echo '<p>Deal Image 5 Large:</p>';
        echo '<input type="text" name="deal_image_6" value="' . $deal_image_6  . '" class="widefat" id="deal_image_6" />';
        echo '<p>Deal Image 6 Large:</p>';
        echo '<input type="text" name="deal_image_7" value="' . $deal_image_7  . '" class="widefat" id="deal_image_7" />';
        echo '<p>Deal Image 7 Large:</p>';
        echo '<input type="text" name="deal_image_8" value="' . $deal_image_8  . '" class="widefat" id="deal_image_8" />';
        echo '<p>Deal Image 8 Large:</p>';
        echo '<input type="text" name="deal_image_9" value="' . $deal_image_9  . '" class="widefat" id="deal_image_9" />';
        echo '<p>Deal Image 9 Large:</p>';
        echo '<input type="text" name="deal_image_10" value="' . $deal_image_10  . '" class="widefat" id="deal_image_10" />';
        echo '<p>Deal Image 10 Large:</p>';
        echo '<input type="text" name="deal_image_11" value="' . $deal_image_11  . '" class="widefat" id="deal_image_11" />';
        
        echo '<p>Deal File:</p>';
        echo '<input type="text" name="deal_file_1" value="' . $deal_file_1[0]  . '" class="widefat" id="deal_file_1" />';
        /*
        echo '<p>Deal File 2:</p>';
        echo '<input type="text" name="deal_file_2" value="' . $deal_file_2[0]  . '" class="widefat" id="deal_file_2" />';
        echo '<p>Deal File 3:</p>';
        echo '<input type="text" name="deal_file_3" value="' . $deal_file_3[0]  . '" class="widefat" id="deal_file_3" />';
        echo '<p>Deal File 4:</p>';
        echo '<input type="text" name="deal_file_4" value="' . $deal_file_4[0]  . '" class="widefat" id="deal_file_4" />';
        echo '<p>Deal File 5:</p>';
        echo '<input type="text" name="deal_file_5" value="' . $deal_file_5[0]  . '" class="widefat" id="deal_file_5" />';
        */
        echo '<p>Video Code (Youtube):</p>';
        echo '<input type="text" name="youtube" value="' . $youtube  . '" class="widefat" id="youtube" />';
        echo '<p>Latitude:</p>';
        echo '<input type="text" name="latitud" value="' . $latitud  . '" class="widefat" id="latitud" />';
        echo '<p>Longitude:</p>';
        echo '<input type="text" name="longitud" value="' . $longitud  . '" class="widefat" id="longitud" />';
        echo '<p>Address:</p>';
        echo '<input type="text" name="address" value="' . $address  . '" class="widefat" id="address" />';
        echo '<p>Telephone:</p>';
        echo '<input type="text" name="tel" value="' . $tel  . '" class="widefat" id="tel" />';
        echo '<p>Email:</p>';
        echo '<input type="text" name="email" value="' . $email  . '" class="widefat" id="email" />';
        
        
        
        echo '<p>Main Deal (Home):</p>';
        echo '<select name="maindeal">';
        if($maindeal != '') {
            $selected = 'selected="selected"';
        } else {
            $selected = '';
        }
        echo '<option value="no" '.$selected.' >No</option>';
        if($maindeal == 'yes') {
            $selected = 'selected="selected"';
        } else {
            $selected = '';
        }
        echo '<option value="yes" '.$selected.' >Yes</option>
            </select>';
        
        
        echo '<p>Feature Deal :</p>';
        echo '<select name="featuredeal">';
        if($featuredeal != '') {
            $selected = 'selected="selected"';
        } else {
            $selected = '';
        }
        echo '<option value="no" '.$selected.' >No</option>';
        if($featuredeal == 'yes') {
            $selected = 'selected="selected"';
        } else {
            $selected = '';
        }
        echo '<option value="yes" '.$selected.' >Yes</option>
            </select>';
              
           
}


add_action('save_post', 'save_meta_deal');
function save_meta_deal($post_id) {
		global $post, $meta_boxes_post, $meta_boxes_post_images, $meta_boxes_post_room, $meta_boxes_page, $key;

			if ( !current_user_can( 'edit_post', $post_id ))
			return $post_id;

                    $upload_dir = wp_upload_dir();

                    if(isset ($_POST[ 'deal_owner'])) {
                        update_post_meta( $post_id, 'deal_owner', $_POST[ 'deal_owner'] );
                    }

                    if(isset ($_POST[ 'real_price'])) {
                        update_post_meta( $post_id, 'real_price', $_POST[ 'real_price'] );
                    }

                    if(isset ($_POST[ 'discount_price'])) {
                        update_post_meta( $post_id, 'discount_price', $_POST[ 'discount_price'] );
                    }

                    if(isset ($_POST[ 'deal_percentage'])) {
                        update_post_meta( $post_id, 'deal_percentage', $_POST[ 'deal_percentage'] );
                    }

                    if(isset ($_POST[ 'start_date'])) {
                        update_post_meta( $post_id, 'start_date', $_POST[ 'start_date'] );
                    }

                    if(isset ($_POST[ 'end_date'])) {
                        update_post_meta( $post_id, 'end_date', $_POST[ 'end_date'] );
                    }

                    if(isset ($_POST[ 'deal_type'])) {
                        update_post_meta( $post_id, 'deal_type', $_POST[ 'deal_type'] );
                    }

                    if(isset ($_POST[ 'deal_info'])) {
                        update_post_meta( $post_id, 'deal_info', $_POST[ 'deal_info'] );
                    }

                   /* if(isset ($_POST[ 'deal_image_1'])) {
                        $check_dummy_1 = strpos($_POST[ 'deal_image_1'], 'images/dummy');
                        if($check_dummy_1 == false){

                    $check_image_1 = strpos($_POST[ 'deal_image_1'], 'wp-content/uploads');
                    if($check_image_1 == false){
                        update_post_meta( $post_id, '_wp_attached_file_1', $upload_dir['baseurl'].'/'.$_POST[ 'deal_image_1'] );
                    }else{
                        update_post_meta( $post_id, '_wp_attached_file_1', $_POST[ 'deal_image_1'] );
                    }
                    }

                    else{
                        update_post_meta( $post_id+1, '_wp_attached_file_1', get_template_directory_uri().'/images/dummy/red.png' );
                    }
                    }

                    if(isset ($_POST[ 'deal_image_2'])) {
                        $check_dummy_2 = strpos($_POST[ 'deal_image_2'], 'images/dummy');
                        if($check_dummy_2 == false){

                    $check_image_2 = strpos($_POST[ 'deal_image_2'], 'wp-content/uploads');
                    if($check_image_2 == false){
                        update_post_meta( $post_id, '_wp_attached_file_2', $upload_dir['baseurl'].'/'.$_POST[ 'deal_image_2'] );
                    }else{
                        update_post_meta( $post_id, '_wp_attached_file_2', $_POST[ 'deal_image_2'] );
                    }
                    }
                    else{
                        update_post_meta( $post_id, '_wp_attached_file_2', get_template_directory_uri().'/images/dummy/red.png' );
                    }
                    }
                    */
                    /* agregado */
                    
                    
                  /*  if(isset ($_POST[ 'deal_image_3'])) {
                        $check_dummy_2 = strpos($_POST[ 'deal_image_3'], 'images/dummy');
                        if($check_dummy_2 == false){

                    $check_image_2 = strpos($_POST[ 'deal_image_3'], 'wp-content/uploads');
                    if($check_image_2 == false){
                        update_post_meta( $post_id, '_wp_attached_file_3', $upload_dir['baseurl'].'/'.$_POST[ 'deal_image_3'] );
                    }else{
                        update_post_meta( $post_id, '_wp_attached_file_3', $_POST[ 'deal_image_3'] );
                    }
                    }
                    else{
                        update_post_meta( $post_id, '_wp_attached_file_3', get_template_directory_uri().'/images/dummy/red.png' );
                    }
                    }
                    
                    if(isset ($_POST[ 'deal_image_4'])) {
                        $check_dummy_2 = strpos($_POST[ 'deal_image_4'], 'images/dummy');
                        if($check_dummy_2 == false){

                    $check_image_2 = strpos($_POST[ 'deal_image_4'], 'wp-content/uploads');
                    if($check_image_2 == false){
                        update_post_meta( $post_id, '_wp_attached_file_4', $upload_dir['baseurl'].'/'.$_POST[ 'deal_image_4'] );
                    }else{
                        update_post_meta( $post_id, '_wp_attached_file_4', $_POST[ 'deal_image_4'] );
                    }
                    }
                    else{
                        update_post_meta( $post_id, '_wp_attached_file_4', get_template_directory_uri().'/images/dummy/red.png' );
                    }
                    }
                    
                    if(isset ($_POST[ 'deal_image_5'])) {
                        $check_dummy_2 = strpos($_POST[ 'deal_image_5'], 'images/dummy');
                        if($check_dummy_2 == false){

                    $check_image_2 = strpos($_POST[ 'deal_image_5'], 'wp-content/uploads');
                    if($check_image_2 == false){
                        update_post_meta( $post_id, '_wp_attached_file_5', $upload_dir['baseurl'].'/'.$_POST[ 'deal_image_5'] );
                    }else{
                        update_post_meta( $post_id, '_wp_attached_file_5', $_POST[ 'deal_image_5'] );
                    }
                    }
                    else{
                        update_post_meta( $post_id, '_wp_attached_file_5', get_template_directory_uri().'/images/dummy/red.png' );
                    }
                    }
                    
                    if(isset ($_POST[ 'deal_image_6'])) {
                        $check_dummy_2 = strpos($_POST[ 'deal_image_6'], 'images/dummy');
                        if($check_dummy_2 == false){

                    $check_image_2 = strpos($_POST[ 'deal_image_6'], 'wp-content/uploads');
                    if($check_image_2 == false){
                        update_post_meta( $post_id, '_wp_attached_file_6', $upload_dir['baseurl'].'/'.$_POST[ 'deal_image_6'] );
                    }else{
                        update_post_meta( $post_id, '_wp_attached_file_6', $_POST[ 'deal_image_6'] );
                    }
                    }
                    else{
                        update_post_meta( $post_id, '_wp_attached_file_6', get_template_directory_uri().'/images/dummy/red.png' );
                    }
                    }
                    
                    if(isset ($_POST[ 'deal_image_7'])) {
                        $check_dummy_2 = strpos($_POST[ 'deal_image_7'], 'images/dummy');
                        if($check_dummy_2 == false){

                    $check_image_2 = strpos($_POST[ 'deal_image_7'], 'wp-content/uploads');
                    if($check_image_2 == false){
                        update_post_meta( $post_id, '_wp_attached_file_7', $upload_dir['baseurl'].'/'.$_POST[ 'deal_image_7'] );
                    }else{
                        update_post_meta( $post_id, '_wp_attached_file_7', $_POST[ 'deal_image_7'] );
                    }
                    }
                    else{
                        update_post_meta( $post_id, '_wp_attached_file_7', get_template_directory_uri().'/images/dummy/red.png' );
                    }
                    }
                    
                    
                    if(isset ($_POST[ 'deal_image_8'])) {
                        $check_dummy_2 = strpos($_POST[ 'deal_image_8'], 'images/dummy');
                        if($check_dummy_2 == false){

                    $check_image_2 = strpos($_POST[ 'deal_image_8'], 'wp-content/uploads');
                    if($check_image_2 == false){
                        update_post_meta( $post_id, '_wp_attached_file_8', $upload_dir['baseurl'].'/'.$_POST[ 'deal_image_8'] );
                    }else{
                        update_post_meta( $post_id, '_wp_attached_file_8', $_POST[ 'deal_image_8'] );
                    }
                    }
                    else{
                        update_post_meta( $post_id, '_wp_attached_file_8', get_template_directory_uri().'/images/dummy/red.png' );
                    }
                    }
                    
                    
                    if(isset ($_POST[ 'deal_image_9'])) {
                        $check_dummy_2 = strpos($_POST[ 'deal_image_9'], 'images/dummy');
                        if($check_dummy_2 == false){

                    $check_image_2 = strpos($_POST[ 'deal_image_9'], 'wp-content/uploads');
                    if($check_image_2 == false){
                        update_post_meta( $post_id, '_wp_attached_file_9', $upload_dir['baseurl'].'/'.$_POST[ 'deal_image_9'] );
                    }else{
                        update_post_meta( $post_id, '_wp_attached_file_9', $_POST[ 'deal_image_9'] );
                    }
                    }
                    else{
                        update_post_meta( $post_id, '_wp_attached_file_9', get_template_directory_uri().'/images/dummy/red.png' );
                    }
                    }
                    
                    if(isset ($_POST[ 'deal_image_10'])) {
                        $check_dummy_2 = strpos($_POST[ 'deal_image_10'], 'images/dummy');
                        if($check_dummy_2 == false){

                    $check_image_2 = strpos($_POST[ 'deal_image_10'], 'wp-content/uploads');
                    if($check_image_2 == false){
                        update_post_meta( $post_id, '_wp_attached_file_10', $upload_dir['baseurl'].'/'.$_POST[ 'deal_image_10'] );
                    }else{
                        update_post_meta( $post_id, '_wp_attached_file_10', $_POST[ 'deal_image_10'] );
                    }
                    }
                    else{
                        update_post_meta( $post_id, '_wp_attached_file_10', get_template_directory_uri().'/images/dummy/red.png' );
                    }
                    }
                    
                    if(isset ($_POST[ 'deal_image_11'])) {
                        $check_dummy_2 = strpos($_POST[ 'deal_image_11'], 'images/dummy');
                        if($check_dummy_2 == false){

                    $check_image_2 = strpos($_POST[ 'deal_image_11'], 'wp-content/uploads');
                    if($check_image_2 == false){
                        update_post_meta( $post_id, '_wp_attached_file_11', $upload_dir['baseurl'].'/'.$_POST[ 'deal_image_11'] );
                    }else{
                        update_post_meta( $post_id, '_wp_attached_file_11', $_POST[ 'deal_image_11'] );
                    }
                    }
                    else{
                        update_post_meta( $post_id, '_wp_attached_file_11', get_template_directory_uri().'/images/dummy/red.png' );
                    }
                    }*/
                    /* evalua todas las imagenes */
                    for($i=1; $i<=11; $i++) {
                        if(isset ($_POST[ 'deal_image_'.$i])) {
                             update_post_meta( $post_id, '_wp_attached_file_'.$i, $_POST[ 'deal_image_'.$i] );
                        }
                    }
                    
                    for($i=1; $i<=5; $i++) {
                       
                        if(isset ($_POST[ 'deal_file_'.$i])) {
                             update_post_meta( $post_id, '_wp_attached_file_'.($i+11), $_POST[ 'deal_file_'.$i] );
                        }
                    }
                    
                    
                    if(isset ($_POST[ 'youtube'])) {
                        update_post_meta( $post_id, 'youtube', $_POST[ 'youtube'] );
                    }
                    
                    if(isset ($_POST[ 'latitud'])) {
                        update_post_meta( $post_id, 'latitud', $_POST[ 'latitud'] );
                    }
                    if(isset ($_POST[ 'longitud'])) {
                        update_post_meta( $post_id, 'longitud', $_POST[ 'longitud'] );
                    }
                    
                    
                    if(isset ($_POST[ 'maindeal'])) {
                        
                        update_post_meta( $post_id, 'maindeal', $_POST[ 'maindeal'] );
                    }
                    
                    if(isset ($_POST[ 'featuredeal'])) {
                        
                        update_post_meta( $post_id, 'featuredeal', $_POST[ 'featuredeal'] );
                    }
                    
                    if(isset ($_POST[ 'address'])) {
                        
                        update_post_meta( $post_id, 'address', $_POST[ 'address'] );
                    }
                    
                    if(isset ($_POST[ 'tel'])) {
                        
                        update_post_meta( $post_id, 'tel', $_POST[ 'tel'] );
                    }
                    
                    if(isset ($_POST[ 'email'])) {
                        
                        update_post_meta( $post_id, 'email', $_POST[ 'email'] );
                    }
                    
                    /* fin agregado */
                    
                    
                    

}


function remove_submenus() {
    global $submenu;
    unset($submenu['edit.php?post_type=deals'][10]);
}
add_action('admin_menu', 'remove_submenus');

function hide_that_stuff() {
if('deals' == get_post_type())
echo '<style type="text/css">
#favorite-actions {display:none;}
.add-new-h2{display:none;}
.tablenav{display:none;}
</style>';
if (strpos(strtolower($_SERVER['REQUEST_URI']), '/wp-admin/post-new.php?post_type=deals')) {
@wp_redirect(get_option('siteurl').'/wp-admin/edit.php?post_type=deals');
echo '
<script type="text/javascript">
<!--
window.location = "'.get_option('siteurl').'/wp-admin/edit.php?post_type=deals";
//-->
</script>';
}

}
add_action('admin_head', 'hide_that_stuff');

function SearchFilter($query) {
if ($query->is_search) {
$query->set('post_type', 'deals');
}
return $query;
}

add_filter('pre_get_posts','SearchFilter');


////////////////// INSERTING POST AT THEME ACTIVATION ////////////////////

            function insert_pages() {
                global $check_my_deals, $check_contact, $check_submit, $check_my_profil, $post, $wpdb;

                $check_first_run = get_option('check_first_run');

                if ( $check_first_run !== "set" ) {

                $querystr = "SELECT ID FROM ".$wpdb->prefix."posts WHERE post_type = 'page' AND post_status = 'publish'";

                $pageposts = $wpdb->get_results($querystr, OBJECT);

                $check_my_deals = FALSE;
                $check_contact = FALSE;
                $check_submit = FALSE;
                $check_my_profile = FALSE;
                $check_my_withdrawals = FALSE;
                $check_home = FALSE;
                $check_all_deals = FALSE;

                foreach($pageposts as $post){

                $check_templates = get_post_meta($post->ID, '_wp_page_template', true);
                $check_page_name = get_the_title($post->ID);

                if ($check_templates == 'submit_deal.php'){
                    $check_submit = true;
                }

                if ($check_templates == '_contact.php'){
                    $check_contact = true;
                }

                if ($check_templates == '_my_deals.php'){
                    $check_my_deals = true;
                }

                if ($check_templates == '_my_profile.php'){
                    $check_my_profile = true;
                }

                if ($check_templates == '_my_withdrawals.php'){
                    $check_my_withdrawals = true;
                }

                if ($check_templates == 'page.php' && $check_page_name == 'Home'){
                    $check_home = true;
                }

                if ($check_templates == '_all_deals.php'){
                    $check_all_deals = true;
                }


                }

                if ($check_submit !== true){
                  $submit_page = array(
                     'post_title' => 'Submit Deal',
                     'post_content' => ' ',
                     'post_status' => 'publish',
                     'post_author' => 1,
                      'post_type' => 'page',
                  );

                  $submit_page_id = wp_insert_post( $submit_page );
                  add_option('custom-submit-id', $submit_page_id);

                  update_post_meta($submit_page_id, '_wp_page_template', 'submit_deal.php');
                }

                if ($check_contact !== true){
                  $contact_page = array(
                     'post_title' => 'Contact Us',
                     'post_content' => ' ',
                     'post_status' => 'publish',
                     'post_author' => 1,
                      'post_type' => 'page',
                  );

                  $contact_page_id = wp_insert_post( $contact_page );

                  update_post_meta($contact_page_id, '_wp_page_template', '_contact.php');
                }

                if ($check_my_deals !== true){
                  $my_deals_page = array(
                     'post_title' => 'My Deals',
                     'post_content' => ' ',
                     'post_status' => 'publish',
                     'post_author' => 1,
                      'post_type' => 'page',
                  );

                  $my_deals_pageid = wp_insert_post( $my_deals_page );

                  update_post_meta($my_deals_pageid, '_wp_page_template', '_my_deals.php');
                }

                if ($check_my_profile !== true){
                  $my_profile_page = array(
                     'post_title' => 'My Profile',
                     'post_content' => ' ',
                     'post_status' => 'publish',
                     'post_author' => 1,
                      'post_type' => 'page',
                  );

                  $my_profile_page_id = wp_insert_post( $my_profile_page );

                  update_post_meta($my_profile_page_id, '_wp_page_template', '_my_profile.php');
                }

                if ($check_my_withdrawals !== true){
                  $my_withdrawals_page = array(
                     'post_title' => 'My Withdrawals',
                     'post_content' => ' ',
                     'post_status' => 'publish',
                     'post_author' => 1,
                      'post_type' => 'page',
                  );

                  $my_withdrawals_page_id = wp_insert_post( $my_withdrawals_page );

                  update_post_meta($my_withdrawals_page_id, '_wp_page_template', '_my_withdrawals.php');
                }

                if ($check_home !== true){
                  $my_home = array(
                     'post_title' => 'Home',
                     'post_content' => ' ',
                     'post_status' => 'publish',
                     'post_author' => 1,
                      'post_type' => 'page',
                  );

                  $my_home_id = wp_insert_post( $my_home );
                  add_option('custom-home-id', $my_home_id);
                }

                if ($check_all_deals !== true){
                  $my_all_deals = array(
                     'post_title' => 'All Deals',
                     'post_content' => ' ',
                     'post_status' => 'publish',
                     'post_author' => 1,
                      'post_type' => 'page',
                  );

                  $my_all_deals_id = wp_insert_post( $my_all_deals );
                  update_post_meta($my_all_deals_id, '_wp_page_template', '_all_deals.php');
                  update_option('all_deals_id', $my_all_deals_id);
                  add_option('custom-all-deals-id', $my_all_deals_id);

                }

                update_option('users_can_register', 1);
                update_option('show_on_front', 'page');
                update_option('page_on_front', $my_home_id);
                update_option('permalink_structure', '/%postname%/');


                add_option('check_first_run', "set");
                }
            }
                add_action('admin_head', 'insert_pages');


             function delete_pages() {
                    delete_option('check_first_run');
                }

            add_action('switch_theme', 'delete_pages');

////////////////// INSERTING POST AT THEME ACTIVATION ////////////////////




            
////////////////// PAY-PAL  ////////////////////



//PayPal notification
if(@$_GET['paypal'] == '1'){
	paypal_notification();
}
if(@$_GET['download-file'] != ''){
    download_file();
}

function paypal_notification(){
global $wpdb;
$sandbox = $_POST['test_ipn'];

foreach ($_POST as $key => $value) {
$value = urlencode(stripslashes($value));
$req .= "&$key=$value";
}

// assign posted variables to local variables
$txn_id = $_POST['txn_id'];
$item_name = $_POST['item_name'];
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$payer_email = $_POST['payer_email'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$custom = $_POST['custom'];
$payment_date = $_POST['payment_date'];
$test_ipn = $_POST['test_ipn'];
$valid_days = get_option(THEME_NAME.'_link_valid');
$post_id = substr($custom, 32);
$custom = substr($custom, 0, 32);

if($valid_days == ''){
    $valid_days = '1';
}

$todayDate = date("Y-m-d H:i:s");
$date = strtotime(date("Y-m-d H:i:s", strtotime($todayDate)) . " +".$valid_days." day");
$valid_link_date = date('Y-m-d H:i:s',$date);

$deal_percentage = get_post_meta($post_id, 'deal_percentage', true);
$deal_percentage = $deal_percentage/100;

$table_name = $wpdb->prefix .THEME_NAME. "paypal_transactions";
$wpdb->query('INSERT INTO '.$table_name.'
    (txn_id, payment_date, payment_status, mc_currency, mc_gross, deal_perc, first_name, last_name, payer_email, custom, downloaded,post_ID, valid_date, test_ipn)
    VALUES ("'.$txn_id.'",
            "'.$payment_date.'",
            "'.$payment_status.'",
            "'.$payment_currency.'",
             '.$payment_amount.',
             '.$deal_percentage.',
            "'.$first_name.'",
            "'.$last_name.'",
            "'.$payer_email.'",
            "'.$custom.'",
             "0",
            "'.$post_id.'",
            "'.$valid_link_date.'",
            "'.$test_ipn.'"
)');

    $check_deal = get_post_meta($post_id, 'deal_type', true);

if($check_deal == 'coupon') {

    $table_name = $wpdb->prefix . THEME_NAME.'_coupons';

    $querystr = "SELECT * FROM ".$table_name."
                        WHERE postid = ".$post_id." AND available = 1 LIMIT 1";
    
    $result = $wpdb->get_results($querystr,ARRAY_A);

    $coupon = $result[0]['coupon'];

    $coupon = trim($coupon);

    $update_query = "
	UPDATE ".$table_name."
	SET e_mail = '".$payer_email."', available = '0'
	WHERE coupon = ".$coupon."
        AND postid =".$post_id."
        ";
    $wpdb->query($update_query);

    $message = get_option(THEME_NAME.'_email_message');

    $mail_template_from = array('[FIRST_NAME]','[LAST_NAME]','[PRODUCT_NAME]','Download link [DOWNLOAD LINK]','[TRANSACTION_ID]','[LINK_VALID]');

    $mail_template_to = array($first_name, $last_name, $item_name, 'Coupon: '.$coupon, $txn_id, get_option(THEME_NAME.'_link_valid').' days');

    $message = str_replace($mail_template_from, $mail_template_to, $message);

    wp_mail( $payer_email, 'Download link', $message) ;

}else {

    $download_link = home_url().'/?download-file='.$custom;

    $message = get_option(THEME_NAME.'_email_message');

    $mail_template_from = array('[FIRST_NAME]','[LAST_NAME]','[PRODUCT_NAME]','Download link [DOWNLOAD LINK]','[TRANSACTION_ID]','[LINK_VALID]');

    $mail_template_to = array($first_name, $last_name, $item_name, $download_link, $txn_id, get_option(THEME_NAME.'_link_valid').' days');

    $message = str_replace($mail_template_from, $mail_template_to, $message);

    wp_mail( $payer_email, 'Download link', $message) ;

}
//mail('marko.ic@gmail.com', 'Download link', $message, $email_headers);
// check the payment_status is Completed
// check that txn_id has not been previously processed
// check that receiver_email is your Primary PayPal email
// check that payment_amount/payment_currency are correct
// process payment
//}
//}
}

function download_file(){
global $wpdb;
//echo $_GET['download-file'];
$table_name = $wpdb->prefix .THEME_NAME. "paypal_transactions";
$querystr = "SELECT * FROM " . $table_name . " WHERE custom = '".mysql_real_escape_string(@$_GET['download-file'])."' AND test_ipn = '".get_option(THEME_NAME.'_paypal_sandbox')."' AND valid_date >= NOW()";
$result = $wpdb->get_results($querystr,ARRAY_A);
$id = @$result[0]['id'];
$deal_id = @$result[0]['post_ID'];

    if($id != ''){

        $updateDownloads = "UPDATE " . $wpdb->prefix .THEME_NAME. "paypal_transactions SET downloaded = (downloaded + 1) WHERE custom = '".mysql_real_escape_string(@$_GET['download-file'])."'";
        $wpdb->query( $updateDownloads );

        $download_url = get_post_meta($deal_id, 'deal_info', true);
        header('Content-disposition: attachment; filename=' . basename($download_url));
	header('Content-Type: application/octet-stream');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Expires: 0');
	$result = wp_remote_get($download_url);
	echo $result['body'];
	die();
    }
}
?>
<?php
if ( is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ) {
    paypal_table_install();
}
function paypal_table_install() {
   global $wpdb;
   $table_name = $wpdb->prefix .THEME_NAME. "paypal_transactions";
   $sql = "CREATE TABLE IF NOT EXISTS " . $table_name . " (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID',
  `txn_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL COMMENT 'PayPal transaction ID',
  `payment_date` varchar(15) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Payment date received by PayPal',
  `payment_status` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `mc_currency` varchar(5) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Currency (EUR, USD, etc.)',
  `mc_gross` float NOT NULL COMMENT 'Product gross price',
  `deal_perc` float NOT NULL COMMENT 'Deal percentage',
  `first_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Payer first name',
  `last_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Payer last name',
  `payer_email` text COLLATE utf8_unicode_ci NOT NULL,
  `custom` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Security code',
  `downloaded` int(11) NOT NULL COMMENT 'How many times payer downloaded product',
  `post_ID` int(11) NOT NULL COMMENT 'Deal ID',
  `valid_date` datetime NOT NULL COMMENT 'Validation date of link sent to payer',
  `test_ipn` tinyint(4) NOT NULL COMMENT 'Is it Sendbox? 1 = (test purchase), 0 = no (real purchase)',
  PRIMARY KEY (`id`)
) CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;";

   require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   if(dbDelta($sql)){
       //TABLE CREATED!
   }else{
       //TABLE ISN'T CREATED
   }
}


////////////////// DUMMY CONTENT ////////////////////


function insert_dummy(){
                global $wpdb;


                // USER 1

                $dummy_user_id_1 = username_exists( 'Test1' );
                if ( !$dummy_user_id_1 ) {
                        $dummy_user_id_1 = wp_create_user( 'Test1', 'test', 'test1@test.com' );
                }

                // USER 2

                $dummy_user_id_2 = username_exists( 'Test2' );
                if ( !$dummy_user_id_2 ) {
                        $dummy_user_id_2 = wp_create_user( 'Test2', 'test', 'test2@test.com' );
                }


            // USER 1 DEALS
                // DEAL 1

                $table_name = $wpdb->prefix.'posts';
                $query_string = 'SELECT * FROM '.$table_name.' WHERE post_title = "Lorem ipsum dolor sit amet, consectetur adipiscing elit." AND post_status = "publish" AND post_author = "'.$dummy_user_id_1.'"';
                $dummy_1_exists = $wpdb->query($query_string);
                if($dummy_1_exists == 0){
                  $dummy_deal_1 = array(
                     'post_title' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                     'post_content' => ' Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sed nulla mauris, sed auctor justo. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Duis vel diam odio, eu gravida lacus. Ut vestibulum aliquet eleifend. Nam orci ipsum, convallis at aliquet in, gravida ut magna. Proin faucibus congue quam vitae faucibus. Integer volutpat sollicitudin mi quis commodo. Etiam vel facilisis ante. Aliquam malesuada leo at sem egestas imperdiet. Sed quis ipsum tortor. Vestibulum sed turpis turpis. Mauris sagittis erat et velit dapibus et facilisis lacus semper. Vestibulum sit amet sem sit amet ligula cursus venenatis sit amet at nulla. Sed sit amet urna velit, vel commodo enim. Pellentesque faucibus commodo vulputate.',
                     'post_status' => 'publish',
                     'post_author' => $dummy_user_id_1,
                      'post_type' => 'deals',
                  );

                  $dummy_deal_1_id = wp_insert_post( $dummy_deal_1 );

                    $dummy_deal_img_1 = array(
                            'post_title' => 'reserved',
                            'guid' => get_template_directory_uri().'/images/dummy/red.png',
                            'post_status' => 'inherit',
                            'post_author' => $dummy_user_id_1,
                            'post_type' => 'post',
                    );

                    $dummy_deal_1_img_id_1 = wp_insert_post( $dummy_deal_img_1 );

                    $dummy_deal_img_1 = array(
                            'post_title' => 'reserved',
                            'guid' => get_template_directory_uri().'/images/dummy/red.png',
                            'post_status' => 'inherit',
                            'post_author' => $dummy_user_id_1,
                            'post_type' => 'post',
                    );

                    $dummy_deal_1_img_id_2 = wp_insert_post( $dummy_deal_img_1 );

                 $this_post = get_post( $dummy_deal_1_id );
                 $dummy_start_date = date('m/d/Y', strtotime($this_post->post_date));
                 $dummy_end_date = strtotime('+1 day' , strtotime ( $this_post->post_date ));
                 $dummy_end_date = date('m/d/Y', $dummy_end_date);

                  add_post_meta($dummy_deal_1_id, 'deal_owner', 'Test1');
                  add_post_meta($dummy_deal_1_id, 'real_price', '5');
                  add_post_meta($dummy_deal_1_id, 'discount_price', '1');
                  add_post_meta($dummy_deal_1_id, 'deal_percentage', '50');
                  add_post_meta($dummy_deal_1_id, 'start_date', $dummy_start_date);
                  add_post_meta($dummy_deal_1_id, 'end_date', $dummy_end_date);
                  add_post_meta($dummy_deal_1_id, 'deal_type', 'digital');
                  add_post_meta($dummy_deal_1_id, 'deal_info', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, 'image_1', $dummy_deal_1_id);
                  add_post_meta($dummy_deal_1_id, 'image_2', $dummy_deal_1_id);
                  add_post_meta($dummy_deal_1_id, 'image_3', $dummy_deal_1_id);
                  add_post_meta($dummy_deal_1_id, 'image_4', $dummy_deal_1_id);
                  add_post_meta($dummy_deal_1_id, 'image_5', $dummy_deal_1_id);
                  add_post_meta($dummy_deal_1_id, 'image_6', $dummy_deal_1_id);
                  add_post_meta($dummy_deal_1_id, 'image_7', $dummy_deal_1_id);                  
                  add_post_meta($dummy_deal_1_id, 'image_8', $dummy_deal_1_id);                  
                  add_post_meta($dummy_deal_1_id, 'image_9', $dummy_deal_1_id);                  
                  add_post_meta($dummy_deal_1_id, 'image_10', $dummy_deal_1_id);                  
                  add_post_meta($dummy_deal_1_id, 'image_11', $dummy_deal_1_id);
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_1', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_2', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_3', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_4', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_5', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_6', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_7', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_8', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_9', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_10', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_11', get_template_directory_uri().'/images/dummy/red.png');
                  
                  
                }



                // DEAL 2

                $table_name = $wpdb->prefix.'posts';
                $query_string = 'SELECT * FROM '.$table_name.' WHERE post_title = "Ut nec lectus et neque volutpat varius." AND post_status = "publish" AND post_author = "'.$dummy_user_id_1.'"';
                $dummy_1_exists = $wpdb->query($query_string);

                if($dummy_1_exists == 0){
                  $dummy_deal_1 = array(
                     'post_title' => 'Ut nec lectus et neque volutpat varius.',
                     'post_content' => 'Ut nec lectus et neque volutpat varius. Nunc eu leo vitae sem posuere porttitor. Sed rhoncus laoreet mauris nec accumsan. Vivamus sed odio lacus. Nam lacinia eleifend augue. Etiam interdum mattis orci. Etiam ac sem nec orci sagittis mattis vel quis eros. Nunc quis turpis felis, ut porttitor eros. Praesent commodo lorem nec urna volutpat ullamcorper. Sed posuere eros non magna vehicula non semper tellus accumsan. ',
                     'post_status' => 'publish',
                     'post_author' => $dummy_user_id_1,
                      'post_type' => 'deals',
                  );

                  $dummy_deal_1_id = wp_insert_post( $dummy_deal_1 );

                    $dummy_deal_img_1 = array(
                            'post_title' => 'reserved',
                            'guid' => get_template_directory_uri().'/images/dummy/red.png',
                            'post_status' => 'inherit',
                            'post_author' => $dummy_user_id_1,
                            'post_type' => 'post',
                    );

                    $dummy_deal_1_img_id_1 = wp_insert_post( $dummy_deal_img_1 );

                    $dummy_deal_img_1 = array(
                            'post_title' => 'reserved',
                            'guid' => get_template_directory_uri().'/images/dummy/red.png',
                            'post_status' => 'inherit',
                            'post_author' => $dummy_user_id_1,
                            'post_type' => 'post',
                    );

                    $dummy_deal_1_img_id_2 = wp_insert_post( $dummy_deal_img_1 );

                 $this_post = get_post( $dummy_deal_1_id );
                 $dummy_start_date = date('m/d/Y', strtotime($this_post->post_date));
                 $dummy_end_date = strtotime('+2 day' , strtotime ( $this_post->post_date ));
                 $dummy_end_date = date('m/d/Y', $dummy_end_date);

                  add_post_meta($dummy_deal_1_id, 'deal_owner', 'Test1');
                  add_post_meta($dummy_deal_1_id, 'real_price', '10');
                  add_post_meta($dummy_deal_1_id, 'discount_price', '1');
                  add_post_meta($dummy_deal_1_id, 'deal_percentage', '30');
                  add_post_meta($dummy_deal_1_id, 'start_date', $dummy_start_date);
                  add_post_meta($dummy_deal_1_id, 'end_date', $dummy_end_date);
                  add_post_meta($dummy_deal_1_id, 'deal_type', 'custom');
                  add_post_meta($dummy_deal_1_id, 'deal_info', 'http://www.google.com');
                  add_post_meta($dummy_deal_1_id, 'image_1', $dummy_deal_1_id);
                  add_post_meta($dummy_deal_1_id, 'image_2', $dummy_deal_1_id);
                  add_post_meta($dummy_deal_1_id, 'image_3', $dummy_deal_1_id);
                  add_post_meta($dummy_deal_1_id, 'image_4', $dummy_deal_1_id);
                  add_post_meta($dummy_deal_1_id, 'image_5', $dummy_deal_1_id);
                  add_post_meta($dummy_deal_1_id, 'image_6', $dummy_deal_1_id);
                  add_post_meta($dummy_deal_1_id, 'image_7', $dummy_deal_1_id);                  
                  add_post_meta($dummy_deal_1_id, 'image_8', $dummy_deal_1_id);                  
                  add_post_meta($dummy_deal_1_id, 'image_9', $dummy_deal_1_id);                  
                  add_post_meta($dummy_deal_1_id, 'image_10', $dummy_deal_1_id);                  
                  add_post_meta($dummy_deal_1_id, 'image_11', $dummy_deal_1_id);
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_1', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_2', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_3', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_4', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_5', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_6', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_7', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_8', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_9', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_10', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_11', get_template_directory_uri().'/images/dummy/red.png');
                  
                }



                // DEAL 3

                $table_name = $wpdb->prefix.'posts';
                $query_string = 'SELECT * FROM '.$table_name.' WHERE post_title = "Donec commodo, mi ut suscipit scelerisque, ante turpis egestas ante, quis eleifend ante justo at eros." AND post_status = "publish" AND post_author = "'.$dummy_user_id_1.'"';
                $dummy_1_exists = $wpdb->query($query_string);

                if($dummy_1_exists == 0){
                  $dummy_deal_1 = array(
                     'post_title' => 'Donec commodo, mi ut suscipit scelerisque, ante turpis egestas ante, quis eleifend ante justo at eros.',
                     'post_content' => 'Donec commodo, mi ut suscipit scelerisque, ante turpis egestas ante, quis eleifend ante justo at eros. Mauris euismod, orci a gravida dictum, orci tortor scelerisque augue, at aliquam mauris erat vel dui. Vivamus eget ipsum orci, sed facilisis sapien. Ut tincidunt varius massa non dapibus. Vestibulum neque dolor, rhoncus a aliquet quis, facilisis eu lectus. Mauris vel purus lobortis mauris dapibus volutpat in non libero. Sed at consectetur nulla. ',
                     'post_status' => 'publish',
                     'post_author' => $dummy_user_id_1,
                      'post_type' => 'deals',
                  );

                  $dummy_deal_1_id = wp_insert_post( $dummy_deal_1 );

                    $dummy_deal_img_1 = array(
                            'post_title' => 'reserved',
                            'guid' => get_template_directory_uri().'/images/dummy/red.png',
                            'post_status' => 'inherit',
                            'post_author' => $dummy_user_id_1,
                            'post_type' => 'post',
                    );

                    $dummy_deal_1_img_id_1 = wp_insert_post( $dummy_deal_img_1 );

                    $dummy_deal_img_1 = array(
                            'post_title' => 'reserved',
                            'guid' => get_template_directory_uri().'/images/dummy/red.png',
                            'post_status' => 'inherit',
                            'post_author' => $dummy_user_id_1,
                            'post_type' => 'post',
                    );

                    $dummy_deal_1_img_id_2 = wp_insert_post( $dummy_deal_img_1 );

                 $this_post = get_post( $dummy_deal_1_id );
                 $dummy_start_date = date('m/d/Y', strtotime($this_post->post_date));
                 $dummy_end_date = strtotime('+0 day' , strtotime ( $this_post->post_date ));
                 $dummy_end_date = date('m/d/Y', $dummy_end_date);

                  add_post_meta($dummy_deal_1_id, 'deal_owner', 'Test1');
                  add_post_meta($dummy_deal_1_id, 'real_price', '15');
                  add_post_meta($dummy_deal_1_id, 'discount_price', '1');
                  add_post_meta($dummy_deal_1_id, 'deal_percentage', '80');
                  add_post_meta($dummy_deal_1_id, 'start_date', $dummy_start_date);
                  add_post_meta($dummy_deal_1_id, 'end_date', $dummy_end_date);
                  add_post_meta($dummy_deal_1_id, 'deal_type', 'coupon');
                  add_post_meta($dummy_deal_1_id, 'deal_info', "coupon1\ncoupon2\ncoupon3");
                  add_post_meta($dummy_deal_1_id, 'image_1', $dummy_deal_1_id);
                  add_post_meta($dummy_deal_1_id, 'image_2', $dummy_deal_1_id);
                  add_post_meta($dummy_deal_1_id, 'image_3', $dummy_deal_1_id);
                  add_post_meta($dummy_deal_1_id, 'image_4', $dummy_deal_1_id);
                  add_post_meta($dummy_deal_1_id, 'image_5', $dummy_deal_1_id);
                  add_post_meta($dummy_deal_1_id, 'image_6', $dummy_deal_1_id);
                  add_post_meta($dummy_deal_1_id, 'image_7', $dummy_deal_1_id);                  
                  add_post_meta($dummy_deal_1_id, 'image_8', $dummy_deal_1_id);                  
                  add_post_meta($dummy_deal_1_id, 'image_9', $dummy_deal_1_id);                  
                  add_post_meta($dummy_deal_1_id, 'image_10', $dummy_deal_1_id);                  
                  add_post_meta($dummy_deal_1_id, 'image_11', $dummy_deal_1_id);
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_1', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_2', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_3', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_4', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_5', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_6', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_7', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_8', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_9', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_10', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_11', get_template_directory_uri().'/images/dummy/red.png');
                  
                insert_coupons("coupon1\ncoupon2\ncoupon3", $dummy_deal_1_id);
                }



                
            // USER 2 DEALS
                // DEAL 1

                $table_name = $wpdb->prefix.'posts';
                $query_string = 'SELECT * FROM '.$table_name.' WHERE post_title = "Donec vulputate augue eget ante posuere id molestie erat ultrices." AND post_status = "publish" AND post_author = "'.$dummy_user_id_2.'"';
                $dummy_1_exists = $wpdb->query($query_string);

                if($dummy_1_exists == 0){
                  $dummy_deal_1 = array(
                     'post_title' => 'Donec vulputate augue eget ante posuere id molestie erat ultrices.',
                     'post_content' => 'Donec vulputate augue eget ante posuere id molestie erat ultrices. Curabitur turpis nibh, laoreet ac facilisis vel, condimentum sagittis justo. Sed vulputate turpis at metus varius id tristique tellus malesuada. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Mauris quis ante dolor. Curabitur a massa risus, nec sollicitudin nisi. Donec sit amet orci dui, vitae viverra diam. ',
                     'post_status' => 'publish',
                     'post_author' => $dummy_user_id_2,
                      'post_type' => 'deals',
                  );

                  $dummy_deal_2_id = wp_insert_post( $dummy_deal_1 );

                    $dummy_deal_img_1 = array(
                            'post_title' => 'reserved',
                            'guid' => get_template_directory_uri().'/images/dummy/red.png',
                            'post_status' => 'inherit',
                            'post_author' => $dummy_user_id_2,
                            'post_type' => 'post',
                    );

                    $dummy_deal_1_img_id_1 = wp_insert_post( $dummy_deal_img_1 );

                    $dummy_deal_img_1 = array(
                            'post_title' => 'reserved',
                            'guid' => get_template_directory_uri().'/images/dummy/red.png',
                            'post_status' => 'inherit',
                            'post_author' => $dummy_user_id_2,
                            'post_type' => 'post',
                    );

                    $dummy_deal_1_img_id_2 = wp_insert_post( $dummy_deal_img_1 );

                 $this_post = get_post( $dummy_deal_2_id );
                 $dummy_start_date = date('m/d/Y', strtotime($this_post->post_date));
                 $dummy_end_date = strtotime('+3 day' , strtotime ( $this_post->post_date ));
                 $dummy_end_date = date('m/d/Y', $dummy_end_date);

                  add_post_meta($dummy_deal_2_id, 'deal_owner', 'Test2');
                  add_post_meta($dummy_deal_2_id, 'real_price', '7');
                  add_post_meta($dummy_deal_2_id, 'discount_price', '1');
                  add_post_meta($dummy_deal_2_id, 'deal_percentage', '10');
                  add_post_meta($dummy_deal_2_id, 'start_date', $dummy_start_date);
                  add_post_meta($dummy_deal_2_id, 'end_date', $dummy_end_date);
                  add_post_meta($dummy_deal_2_id, 'deal_type', 'digital');
                  add_post_meta($dummy_deal_2_id, 'deal_info', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, 'image_1', $dummy_deal_1_id);
                  add_post_meta($dummy_deal_1_id, 'image_2', $dummy_deal_1_id);
                  add_post_meta($dummy_deal_1_id, 'image_3', $dummy_deal_1_id);
                  add_post_meta($dummy_deal_1_id, 'image_4', $dummy_deal_1_id);
                  add_post_meta($dummy_deal_1_id, 'image_5', $dummy_deal_1_id);
                  add_post_meta($dummy_deal_1_id, 'image_6', $dummy_deal_1_id);
                  add_post_meta($dummy_deal_1_id, 'image_7', $dummy_deal_1_id);                  
                  add_post_meta($dummy_deal_1_id, 'image_8', $dummy_deal_1_id);                  
                  add_post_meta($dummy_deal_1_id, 'image_9', $dummy_deal_1_id);                  
                  add_post_meta($dummy_deal_1_id, 'image_10', $dummy_deal_1_id);                  
                  add_post_meta($dummy_deal_1_id, 'image_11', $dummy_deal_1_id);
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_1', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_2', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_3', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_4', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_5', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_6', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_7', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_8', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_9', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_10', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_11', get_template_directory_uri().'/images/dummy/red.png');
                  }



                // DEAL 2

                $table_name = $wpdb->prefix.'posts';
                $query_string = 'SELECT * FROM '.$table_name.' WHERE post_title = "Sed iaculis mauris sed diam elementum pellentesque." AND post_status = "publish" AND post_author = "'.$dummy_user_id_2.'"';
                $dummy_1_exists = $wpdb->query($query_string);

                if($dummy_1_exists == 0){
                  $dummy_deal_1 = array(
                     'post_title' => 'Sed iaculis mauris sed diam elementum pellentesque.',
                     'post_content' => 'Sed iaculis mauris sed diam elementum pellentesque. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse accumsan malesuada elementum. Nulla facilisi. Fusce porttitor auctor elit, at iaculis lacus eleifend sit amet. Fusce facilisis leo non lorem bibendum elementum. Maecenas quis nisi est, sit amet scelerisque orci. Maecenas orci dolor, rutrum sed egestas ac, pharetra vitae diam. Ut at quam lectus, et vehicula lorem. Proin placerat laoreet massa a auctor. Integer eget lacus ut nisl eleifend laoreet. Sed nec purus nec enim vulputate condimentum. Pellentesque arcu risus, varius a dapibus vel, tempus eget libero. Curabitur fermentum, turpis quis convallis euismod, sapien turpis cursus lorem, at luctus dolor mauris vel neque. ',
                     'post_status' => 'publish',
                     'post_author' => $dummy_user_id_2,
                      'post_type' => 'deals',
                  );

                  $dummy_deal_2_id = wp_insert_post( $dummy_deal_1 );

                    $dummy_deal_img_1 = array(
                            'post_title' => 'reserved',
                            'guid' => get_template_directory_uri().'/images/dummy/red.png',
                            'post_status' => 'inherit',
                            'post_author' => $dummy_user_id_2,
                            'post_type' => 'post',
                    );

                    $dummy_deal_1_img_id_1 = wp_insert_post( $dummy_deal_img_1 );

                    $dummy_deal_img_1 = array(
                            'post_title' => 'reserved',
                            'guid' => get_template_directory_uri().'/images/dummy/red.png',
                            'post_status' => 'inherit',
                            'post_author' => $dummy_user_id_2,
                            'post_type' => 'post',
                    );

                    $dummy_deal_1_img_id_2 = wp_insert_post( $dummy_deal_img_1 );

                 $this_post = get_post( $dummy_deal_2_id );
                 $dummy_start_date = date('m/d/Y', strtotime($this_post->post_date));
                 $dummy_end_date = strtotime('+0 day' , strtotime ( $this_post->post_date ));
                 $dummy_end_date = date('m/d/Y', $dummy_end_date);

                  add_post_meta($dummy_deal_2_id, 'deal_owner', 'Test2');
                  add_post_meta($dummy_deal_2_id, 'real_price', '99');
                  add_post_meta($dummy_deal_2_id, 'discount_price', '1');
                  add_post_meta($dummy_deal_2_id, 'deal_percentage', '85');
                  add_post_meta($dummy_deal_2_id, 'start_date', $dummy_start_date);
                  add_post_meta($dummy_deal_2_id, 'end_date', $dummy_end_date);
                  add_post_meta($dummy_deal_2_id, 'deal_type', 'custom');
                  add_post_meta($dummy_deal_2_id, 'deal_info', 'http://www.google.com');
                  add_post_meta($dummy_deal_1_id, 'image_1', $dummy_deal_1_id);
                  add_post_meta($dummy_deal_1_id, 'image_2', $dummy_deal_1_id);
                  add_post_meta($dummy_deal_1_id, 'image_3', $dummy_deal_1_id);
                  add_post_meta($dummy_deal_1_id, 'image_4', $dummy_deal_1_id);
                  add_post_meta($dummy_deal_1_id, 'image_5', $dummy_deal_1_id);
                  add_post_meta($dummy_deal_1_id, 'image_6', $dummy_deal_1_id);
                  add_post_meta($dummy_deal_1_id, 'image_7', $dummy_deal_1_id);                  
                  add_post_meta($dummy_deal_1_id, 'image_8', $dummy_deal_1_id);                  
                  add_post_meta($dummy_deal_1_id, 'image_9', $dummy_deal_1_id);                  
                  add_post_meta($dummy_deal_1_id, 'image_10', $dummy_deal_1_id);                  
                  add_post_meta($dummy_deal_1_id, 'image_11', $dummy_deal_1_id);
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_1', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_2', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_3', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_4', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_5', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_6', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_7', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_8', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_9', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_10', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_11', get_template_directory_uri().'/images/dummy/red.png');
                  }



                // DEAL 3

                $table_name = $wpdb->prefix.'posts';
                $query_string = 'SELECT * FROM '.$table_name.' WHERE post_title = "Contrary to popular belief" AND post_status = "publish" AND post_author = "'.$dummy_user_id_2.'"';
                $dummy_1_exists = $wpdb->query($query_string);

                if($dummy_1_exists == 0){
                  $dummy_deal_1 = array(
                     'post_title' => 'Contrary to popular belief',
                     'post_content' => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. ',
                     'post_status' => 'publish',
                     'post_author' => $dummy_user_id_2,
                      'post_type' => 'deals',
                  );

                  $dummy_deal_2_id = wp_insert_post( $dummy_deal_1 );

                    $dummy_deal_img_1 = array(
                            'post_title' => 'reserved',
                            'guid' => get_template_directory_uri().'/images/dummy/red.png',
                            'post_status' => 'inherit',
                            'post_author' => $dummy_user_id_2,
                            'post_type' => 'post',
                    );

                    $dummy_deal_1_img_id_1 = wp_insert_post( $dummy_deal_img_1 );

                    $dummy_deal_img_1 = array(
                            'post_title' => 'reserved',
                            'guid' => get_template_directory_uri().'/images/dummy/red.png',
                            'post_status' => 'inherit',
                            'post_author' => $dummy_user_id_2,
                            'post_type' => 'post',
                    );

                    $dummy_deal_1_img_id_2 = wp_insert_post( $dummy_deal_img_1 );

                 $this_post = get_post( $dummy_deal_2_id );
                 $dummy_start_date = date('m/d/Y', strtotime($this_post->post_date));
                 $dummy_end_date = strtotime('+7 day' , strtotime ( $this_post->post_date ));
                 $dummy_end_date = date('m/d/Y', $dummy_end_date);

                  add_post_meta($dummy_deal_2_id, 'deal_owner', 'Test2');
                  add_post_meta($dummy_deal_2_id, 'real_price', '65');
                  add_post_meta($dummy_deal_2_id, 'discount_price', '1');
                  add_post_meta($dummy_deal_2_id, 'deal_percentage', '33');
                  add_post_meta($dummy_deal_2_id, 'start_date', $dummy_start_date);
                  add_post_meta($dummy_deal_2_id, 'end_date', $dummy_end_date);
                  add_post_meta($dummy_deal_2_id, 'deal_type', 'coupon');
                  add_post_meta($dummy_deal_2_id, 'deal_info', "coupon1\ncoupon2\ncoupon3");
                  add_post_meta($dummy_deal_1_id, 'image_1', $dummy_deal_1_id);
                  add_post_meta($dummy_deal_1_id, 'image_2', $dummy_deal_1_id);
                  add_post_meta($dummy_deal_1_id, 'image_3', $dummy_deal_1_id);
                  add_post_meta($dummy_deal_1_id, 'image_4', $dummy_deal_1_id);
                  add_post_meta($dummy_deal_1_id, 'image_5', $dummy_deal_1_id);
                  add_post_meta($dummy_deal_1_id, 'image_6', $dummy_deal_1_id);
                  add_post_meta($dummy_deal_1_id, 'image_7', $dummy_deal_1_id);                  
                  add_post_meta($dummy_deal_1_id, 'image_8', $dummy_deal_1_id);                  
                  add_post_meta($dummy_deal_1_id, 'image_9', $dummy_deal_1_id);                  
                  add_post_meta($dummy_deal_1_id, 'image_10', $dummy_deal_1_id);                  
                  add_post_meta($dummy_deal_1_id, 'image_11', $dummy_deal_1_id);
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_1', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_2', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_3', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_4', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_5', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_6', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_7', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_8', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_9', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_10', get_template_directory_uri().'/images/dummy/red.png');
                  add_post_meta($dummy_deal_1_id, '_wp_attached_file_11', get_template_directory_uri().'/images/dummy/red.png');
                  
                insert_coupons("coupon1\ncoupon2\ncoupon3", $dummy_deal_2_id);
                }

}


if (isset($_GET['dummy'])){
    if ($_GET['dummy'] == 1){
    insert_dummy();
}}


 function remove_wp_magic_quotes()
    {
        $_GET    = stripslashes_deep($_GET);
        $_POST   = stripslashes_deep($_POST);
        $_COOKIE = stripslashes_deep($_COOKIE);
        $_REQUEST = stripslashes_deep($_REQUEST);
    }

    remove_wp_magic_quotes();



    function print_money_symbol($currency) {

        if($currency == 'USD') {$currency = str_replace('USD', '$', $currency);}
        if($currency == 'EUR') {$currency = str_replace('EUR', '€', $currency);}
        if($currency == 'AUD') {$currency = str_replace('AUD', '$', $currency);}
        if($currency == 'CAD') {$currency = str_replace('CAD', '$', $currency);}
        if($currency == 'GBP') {$currency = str_replace('GBP', '£', $currency);}
        if($currency == 'JPY') {$currency = str_replace('JPY', '¥', $currency);}
        if($currency == 'NZD') {$currency = str_replace('NZD', '$', $currency);}
        if($currency == 'HKD') {$currency = str_replace('HKD', '$', $currency);}
        if($currency == 'SGD') {$currency = str_replace('SGD', '$', $currency);}

        return ($currency);
    };
    
    
    function add_sumtips_admin_bar_link() {
	global $wp_admin_bar;
	if ( !is_super_admin() || !is_admin_bar_showing() )
		return;
	$wp_admin_bar->add_menu( array(
	'id' => 'sumtips_link',
	'title' => __( 'New Deal'),
	'href' => __('admin.php?page=Dealers-theme&create=deal'),
	) );
}
add_action('admin_bar_menu', 'add_sumtips_admin_bar_link',25);



function new_excerpt_length($length) {
return 40; 
}
add_filter('excerpt_length', 'new_excerpt_length');

?>

<?php session_start();
// Hook for adding admin menus
	add_action('admin_menu', 'add_pages');
	//$setupnames = update_option(THEME_NAME.'-setup-names','');
	// action function for above hook
        function add_pages() {
                add_menu_page( THEME_NAME, THEME_NAME, 'manage_options',THEME_NAME.'-theme', 'theme_panel');
                add_submenu_page(THEME_NAME.'-theme',  __(THEME_NAME.' Panel','admin-menu'), __(THEME_NAME.' Panel','admin-menu'), 'manage_options', THEME_NAME.'-theme', 'theme_panel'  );
                add_submenu_page(THEME_NAME.'-theme',  __(THEME_NAME.' Transactions','admin-menu'), __(THEME_NAME.' Transactions','admin-menu'), 'manage_options', THEME_NAME.'-transaction', 'theme_transaction' );
                add_submenu_page(THEME_NAME.'-theme',  __(THEME_NAME.' Withdrawals','admin-menu'), __(THEME_NAME.' Withdrawals','admin-menu'), 'manage_options', THEME_NAME.'-withdrawals', 'theme_withdrawals' );
	}





/*-------ADMIN START---------*/


function theme_panel() {



      //
//      START DEFINING ELEMENTS FOR ADMINISTRATION
//


$admin_form = array(

        'Main'=>array(


                'Logo' => array(

                        'label' => 'Logo',

                        'name' => THEME_NAME.'_custom_logo',

                        'type' => 'file',

                        'description' => 'Upload Your logo or paste logo url',

                        'default' => get_template_directory_uri().'/images/logo.png'

                ),

                'Favicon' => array(

                        'label' => 'Favicon',

                        'name' => THEME_NAME.'_custom_favicon',

                        'type' => 'file',

                        'description' => 'Upload Your favicon or paste favicon url (16x16px)',

                        'default' => get_template_directory_uri().'/images/favicon.ico'

                ),

                'Footer' => array(

                        'label' => 'Footer Copyright Text',

                        'name' => THEME_NAME.'_footer_copyright',

                        'type' => 'text',

                        'description' => 'Insert Your Copyright text',

                        'default' => 'Copyright Information Goes Here 2012. All Rights Reserved. Designed by  Themeskingdom'

                ),

            'Background Color' => array(

                        'label' => 'Background Color',

                        'name' => THEME_NAME.'_Colorpicker',

                        'type' => 'colorpicker',

                        'description' => 'Chose a color for your site.'

                ),

            'Google Analytics' => array(

                        'label' => 'Google Analytics',

                        'name' => THEME_NAME.'_google_analitics',

                        'type' => 'textarea',

                        'description' => 'Insert here your Google Analytics code, or leave it blank if you dont need this option',

                        'default' => ''

                ),

        ),


        'Front'=>array(

                'Use Featured Category' => array(

                        'label' => 'Use Featured Category',

                        'name' => THEME_NAME.'_use_featured_category',

                        'type' => 'singlecheck',

                        'description' => 'Select this option if you want to use Featured Category for front page posts.',

                        'default' => ''

                ),

                'Featured Category' => array(

                        'label' => 'Featured Category',

                        'name' => THEME_NAME.'_featured_category',

                        'type' => 'dropdown',

                        'description' => 'Chose Category of featured posts, those posts will be shown on front page.',

                        'default' => ''

                ),

                'Use Sendloop' => array(

                        'label' => 'Show Email send',

                        'name' => THEME_NAME.'_use_sendloop',

                        'type' => 'singlecheck',

                        'description' => 'Show sing up box',

                        'default' => ''

                ),

            'SendloopUser' => array(

                        'label' => 'Email to',

                        'name' => THEME_NAME.'_sendloop_user',

                        'type' => 'text',

                        'description' => 'Email to send user email.',

                        'default' => ''

                ),

          /*  'SendloopListId' => array(

                        'label' => 'Sendloop List Id',

                        'name' => THEME_NAME.'_sendloop_list_id',

                        'type' => 'text',

                        'description' => 'Insert your Sandloop List Id. It can be found at Subscriber Lists-><strong>Your List</strong>->Edit List Settings',

                        'default' => ''

                ),

                'Use Mailchimp' => array(

                        'label' => 'Use Mailchimp',

                        'name' => THEME_NAME.'_use_mailchimp',

                        'type' => 'singlecheck',

                        'description' => 'Use <a href="http://mailchimp.com/">Mailchimp</a> as your newsletter manager',

                        'default' => ''

                ),

            'MailChimpKey' => array(

                        'label' => 'MailChimp API Key',

                        'name' => THEME_NAME.'_mailchimp_key',

                        'type' => 'text',

                        'description' => 'Grab and insert an API Key from http://admin.mailchimp.com/account/api/',

                        'default' => ''

                ),

            'MailChimpList' => array(

                        'label' => 'MailChimp API List',

                        'name' => THEME_NAME.'_mailchimp_list',

                        'type' => 'text',

                        'description' => 'Grab your Lists Unique Id by going to http://admin.mailchimp.com/lists/. Click the "settings" link for the list - the Unique Id is at the bottom of that page. ',

                        'default' => ''

                ),
*/
                'BottomBanner' => array(

                        'label' => 'Bottom Banner Show/Hide',

                        'name' => THEME_NAME.'_bottom_banner',

                        'type' => 'singlecheck',

                        'description' => 'Check this if you want to show bottom banner.',

                        'default' => ''

                ),

            'BannerImage' => array(

                        'label' => 'Bottom Banner Image',

                        'name' => THEME_NAME.'_banner_image',

                        'type' => 'text',

                        'description' => 'Insert URL to your banner image. Recomended size 945x115 px.',

                        'default' => get_template_directory_uri().'/images/dummy/red.png'

                ),


        ),


        'Contact'=>array(

                'Subject error' => array(

                        'label' => 'Subject error message:',

                        'name' => THEME_NAME.'_subject_error_msg',

                        'type' => 'text',

                        'description' => 'Edit error and success messages for contact form',

                        'default' => 'Please insert message subject!'

                ),

                'Name error' => array(

                        'label' => 'Name error message:',

                        'name' => THEME_NAME.'_name_error_msg',

                        'type' => 'text',

                        'description' => 'Edit error and success messages for contact form',

                        'default' => 'Please insert your name!'

                ),

                'E-mail error' => array(

                        'label' => 'E-mail error message:',

                        'name' => THEME_NAME.'_email_error_msg',

                        'type' => 'text',

                        'description' => 'Edit error and success messages for contact form',

                        'default' => 'Please insert your e-mail!'

                ),

                'Message error' => array(

                        'label' => 'Message error message:',

                        'name' => THEME_NAME.'_message_error_msg',

                        'type' => 'text',

                        'description' => 'Edit error and success messages for contact form',

                        'default' => 'Please insert your message!'

                ),

                'Successfull mail send:' => array(

                        'label' => 'Message on successfull mail send:',

                        'name' => THEME_NAME.'_mail_success_msg',

                        'type' => 'text',

                        'description' => 'Edit error and success messages for contact form',

                        'default' => 'Message sent!'

                ),

                'Unsuccessfull mail send:' => array(

                        'label' => 'Message on unsuccessfull mail send:',

                        'name' => THEME_NAME.'_mail_error_msg',

                        'type' => 'text',

                        'description' => 'Edit error and success messages for contact form',

                        'default' => 'Some error occured!'

                ),


    ),

  	'StoreSettings'=>array(


                'PayPal Email' => array(

                        'label' => 'PayPal Email',

                        'name' => THEME_NAME.'_paypal_email',

                        'type' => 'text',

                        'description' => 'Please enter your PayPal email address.',

                        'default' => ''

                ),


                'PayPal Sandbox' => array(

                        'label' => 'PayPal Sandbox',

                        'name' => THEME_NAME.'_paypal_sandbox',

                        'type' => 'singlecheck',

                        'description' => 'Enable PayPal Sanbox',

                        'default' => ''

                ),


                'Currency' => array(

                        'label' => 'Currency',

                        'name' => THEME_NAME.'_currency',

                        'type' => 'customdropdown',

                        'description' => 'Select the currency that your product will be sold in.'

                ),


                'Link is valid? (days)' => array(

                        'label' => 'Link is valid? (days)',

                        'name' => THEME_NAME.'_link_valid',

                        'type' => 'text',

                        'description' => 'Link will expire after a certain amount of time.'

                ),

                'Minimal Withdrawal' => array(

                        'label' => 'Minimal Withdrawal',

                        'name' => THEME_NAME.'_minimal_withdrawal',

                        'type' => 'text',

                        'description' => 'Enter how much is user minimal withdrawal.',

                        'default' => '50'

                ),

            'Return URL' => array(

                        'label' => 'Return URL',

                        'name' => THEME_NAME.'_return_url',

                        'type' => 'text',

                        'description' => 'Page URL on your site where buyer will be returned after payment.'

                ),

            'Email Message' => array(

                        'label' => 'Email Message',

                        'name' => THEME_NAME.'_email_message',

                        'type' => 'textarea',

                        'description' => 'Email this to your buyer after the payment.',

                        'default' => 'Hello [FIRST_NAME] [LAST_NAME],'."\n\n".'Thank you for your purchase of [PRODUCT_NAME]!'."\n".'Download link [DOWNLOAD LINK]'."\n".'Your transaction ID is [TRANSACTION_ID]'."\n".'Link is valid [LINK_VALID]'."\n\n".'Kind Regards!'

                ),


        ),

      

);


//
//      END DEFINING ELEMENTS FOR ADMINISTRATION
//











//
//      START UPDATING ELEMENTS IN ADMINISTRATION
//
if($_GET['create']) {
    global $wpdb;
    $table_name = $wpdb->prefix.'posts';
                $query_string = 'SELECT * FROM '.$table_name.' WHERE post_title = "Lorem ipsum dolor sit amet, consectetur adipiscing elit." AND post_status = "publish" AND post_author = "'.$dummy_user_id_1.'"';
                $dummy_1_exists = $wpdb->query($query_string);
                if($dummy_1_exists == 0){
                  $dummy_deal_1 = array(
                     'post_title' => 'New deal',
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
}
if(isset($_POST['admin_submit'])) {
    

    foreach ($admin_form as $admin_panel) {

        foreach($admin_panel as $admin_option ) {

            foreach ($admin_option as $admin_option_name => $admin_option_value){

                if($admin_option_name == 'name'){

                    $posted_item = is_array($_POST[$admin_option_value]);
                     if ($posted_item == false){
                         $escaped_option = esc_html($_POST[$admin_option_value]);
                         if($admin_option_value == 'Dealers_google_analitics'){
                         $escaped_option = addslashes($_POST[$admin_option_value]);
                         update_option($admin_option_value, $escaped_option);
                         }else{
                         update_option($admin_option_value, $escaped_option);
                     }
                     }else{
                         update_option($admin_option_value, $_POST[$admin_option_value]);
                     }

                }

            }

        }

    }

}


//
//      END UPDATING ELEMENTS IN ADMINISTRATION
//

?>



<!-- Header for administration-->

            <div id="header">

                <div class="icon-option"></div>

                <div class="theme-name">

                    <?php echo THEME_NAME?>

                </div>

                <div class="theme-version"><?php echo THEME_VERSION?></div>

                <div class="clear-both"></div>

            </div><!-- close #header-->



<!-- For for admin settings-->
<h2><a href="<?php echo get_page_url(); ?>&create=deal" class="add-new-h2">Create new deal</a></h2>
<form action="<?php echo get_page_url(); ?>" method="POST" enctype="multipart/form-data">

    <div class="admin-panel">

        

        <div class='left-side' >

            <?php

            foreach ($admin_form as $panel_name => $panel_options) {

                if (isset($panel_name)) { ?>

                        <label class='admin-nav' rev='<?php echo $panel_name?>'><?php echo $panel_name ?></label>

                        <script type="text/javascript">

                            jQuery(document).ready(function() {

                                // Border cleaner
                                    jQuery('.<?php echo $panel_name?> .option-section:last').attr('style', 'border-bottom:none');

                            });

                        </script>

             <?php  } } ?>

        </div><!-- close .left-side-->



        <div class='right-side' >

            <?php

            foreach ($admin_form as $panel_name => $panel_options) { ?>

            <div class="<?php echo $panel_name.' hide mainspan'?>">

                <h2><?php echo $panel_name ?></h2>

                    <?php



                        //
                      //      Checking option type START
                    //



                    foreach ($panel_options as $input_name => $input_type) {



                        //      if is input type text

                        if ($input_type['type']  == 'text') {

                            $value = get_option($input_type['name']);

                            $value = stripslashes($value);

                            if($value == ""){

                                $value = $input_type['default'];

                            }

                            ?>

                <div class="option-section">

                    <label class="option-title"><?php echo $input_type['label']?></label>

                    <div class="option-holder">

                        <input type="text" name="<?php echo $input_type['name']?>" class="input-text" value="<?php echo $value;  ?>">

                        <label class="option-description"><?php echo $input_type['description']?></label>

                    </div>

                </div>

                            <?php   }



                        //      if is input type dropdown


                        if ($input_type['type']  == 'dropdown') { ?>

                <div class="option-section">

                    <label class="option-title"><?php echo $input_type['label']?></label>

                    <div class="option-holder">



                   <?php
				$cat = get_option($input_type['name']);
 				$selected_category = $cat;
				$args = array(
				    'show_option_all'    => '',
				    'show_option_none'   => '',
				    'orderby'            => 'ID',
				    'order'              => 'ASC',
				    'show_last_update'   => 0,
				    'show_count'         => 0,
				    'hide_empty'         => 1,
				    'child_of'           => 0,
				    'exclude'            => '',
				    'echo'               => 1,
				    'selected'           => $selected_category,
				    'hierarchical'       => 0,
				    'name'               => $input_type['name'],
				    'id'                 => 'option_dropdown',
				    'class'              => 'postform',
				    'depth'              => 0,
				    'tab_index'          => 0,
				    'taxonomy'           => 'category',
				    'hide_if_empty'      => false );
				     wp_dropdown_categories( $args );
				?>

                        <label class="option-description"><?php echo $input_type['description']?></label>

                    </div>

                </div>

                            <?php     }



                        //      if is input type textarea

                        if ($input_type['type']  == 'textarea') {

                            $value = get_option($input_type['name']);

                            $value = stripcslashes($value);

                            if($value == "") {

                                $value = $input_type['default'];

                            }

                            ?>

                <div class="option-section">

                    <label class="option-title"><?php echo $input_type['label']?></label>

                    <div class="option-holder">

                        <textarea type='text' name='<?php echo $input_type['name'] ?>' class='admin-textarea'><?php echo $value?></textarea>

                        <label class='option-description'><?php echo $input_type['description'] ?></label>

                    </div>

                </div>

                            <?php     }



                        //      if is input type file

                        if ($input_type['type']  == 'file') { ?>



                <div class=" option-section">

                    <label class="option-title"><?php echo $input_type['label']?></label>

                    <div class="upload-section-holder">

                        <div class="left_content">

					<?php

						$file_value = get_option($input_type['name']); if(empty($file_value)) {$file_value = $input_type['default'];}
					?>

					<input type="text" value="<?php echo $file_value;?>" name="<?php echo $input_type['name'];?>"  class="postbox small input-text"/>

					<span id="<?php echo $input_type['name'];?>" class="button upload gd_upload logoupload show">Upload Image</span>

					<span class="button gd_remove" id="remove_<?php echo $input_type['name'];?>">Remove Image</span>

					<div class="gd_image_preview_holder">

						<img src="<?php echo $file_value;?>"/>

					</div>

			</div> <!--close content-->

                    </div>

                                        <label class='option-description'><?php echo $input_type['description']?></label>


                </div> <!--close content-->

                            <?php   }



                        //      if is input type checkbox single

                        if ($input_type['type']  == 'singlecheck') {

                            $singlecheck = get_option($input_type['name']);

                        ?>

                <div class="option-section">

                    <label class="option-title"><?php echo $input_type['label']?></label>

                    <div class="option-holder">

                        <input class ="admin_single_checkbox" type="checkbox" value="1" name="<?php echo $input_type['name']?>" <?php if($singlecheck == '1') {echo ' checked '; } ?> >

                        <label class="option-description"><?php echo $input_type['description']?></label>

                    </div>

                </div>

                            <?php   }



                        //      if is input type checkbox multi

                        if ($input_type['type']  == 'multicheck') { ?>

                <div class="option-section">

                    <label class="option-title"><?php echo $input_type['label']?></label>

                    <div class="option-holder">

                        <div class="option-cat-holder">

                                    <?php

                                    $categories = get_categories('orderby=name');

                                    $cheked_category = get_option($input_type['name']);

                                    foreach ($categories as $category_list ) {

                                        ?>

                                <input class="gd_super_check" type="checkbox" value="<?php echo $category_list->cat_ID;?>" name="<?php echo $input_type['name']."[]"?>"

                               <?php

                               if(!empty($cheked_category)){

                                   foreach ($cheked_category as $checked_one){

                                       if($checked_one == $category_list->cat_ID) { echo "checked"; }

                                   }

                               }
                               ?> >

                               <div class="category-name"><?php echo $category_list->cat_name;?></div> <?php  } ?>

                        </div>

                        <label class="option-description"><?php echo $input_type['description']?></label>

                    </div>

                </div>
                            <?php   }



					 //      if is input type custom dropdown


                       if ($input_type['type']  == 'customdropdown') { ?>
                  <?php
               $currency = get_option($input_type['name']);
               $selected_category = $currency;?>
               <div class="option-section">

                   <label class="option-title"><?php echo $input_type['label']?></label>

                   <div class="option-holder">

                       <select id="option_dropdown" class="postform" name="<?php echo $input_type['name']?>">
                            <option class="level-0" <?php if ($selected_category == 'AUD')  { echo 'selected'; } ?> value="AUD">Australian Dollar (A $) AUD</option>
                            <option class="level-0" <?php if ($selected_category == 'CAD')  { echo 'selected'; } ?> value="CAD">Canadian Dollar (C $) CAD</option>
                            <option class="level-0" <?php if ($selected_category == 'EUR')  { echo 'selected'; } ?> value="EUR">Euro (€) EUR</option>
                            <option class="level-0" <?php if ($selected_category == 'GBP')  { echo 'selected'; } ?> value="GBP">British Pound (£) GBP</option>
                            <option class="level-0" <?php if ($selected_category == 'JPY')  { echo 'selected'; } ?> value="JPY">Japanese Yen (¥) JPY</option>
                            <option class="level-0" <?php if ($selected_category == 'USD')  { echo 'selected'; } ?> value="USD">U.S. Dollar ($)	USD</option>
                            <option class="level-0" <?php if ($selected_category == 'NZD')  { echo 'selected'; } ?> value="NZD">New Zealand Dollar ($) NZD</option>
                            <option class="level-0" <?php if ($selected_category == 'CHF')  { echo 'selected'; } ?> value="CHF">Swiss Franc	CHF</option>
                            <option class="level-0" <?php if ($selected_category == 'HKD')  { echo 'selected'; } ?> value="HKD">Hong Kong Dollar ($) HKD</option>
                            <option class="level-0" <?php if ($selected_category == 'SGD')  { echo 'selected'; } ?> value="SGD">Singapore Dollar ($) SGD</option>
                            <option class="level-0" <?php if ($selected_category == 'SEK')  { echo 'selected'; } ?> value="SEK">Swedish Krona SEK</option>
                            <option class="level-0" <?php if ($selected_category == 'DKK')  { echo 'selected'; } ?> value="DKK">Danish Krone DKK</option>
                            <option class="level-0" <?php if ($selected_category == 'PLN')  { echo 'selected'; } ?> value="PLN">Polish Zloty PLN</option>
                            <option class="level-0" <?php if ($selected_category == 'NOK')  { echo 'selected'; } ?> value="NOK">Norwegian Krone	NOK</option>
                            <option class="level-0" <?php if ($selected_category == 'HUF')  { echo 'selected'; } ?> value="HUF">Hungarian Forint HUF</option>
                            <option class="level-0" <?php if ($selected_category == 'CZK')  { echo 'selected'; } ?> value="CZK">Czech Koruna CZK</option>
                            <option class="level-0" <?php if ($selected_category == 'ILS')  { echo 'selected'; } ?> value="ILS">Israeli New Shekel ILS</option>
                            <option class="level-0" <?php if ($selected_category == 'MXN')  { echo 'selected'; } ?> value="MXN">Mexican Peso MXN</option>
                            <option class="level-0" <?php if ($selected_category == 'BRL')  { echo 'selected'; } ?> value="BRL">Brazilian Real BRL</option>
                            <option class="level-0" <?php if ($selected_category == 'MYR')  { echo 'selected'; } ?> value="MYR">Malaysian Ringgit MYR</option>
                            <option class="level-0" <?php if ($selected_category == 'PHP')  { echo 'selected'; } ?> value="PHP">Philippine Peso	PHP</option>
                            <option class="level-0" <?php if ($selected_category == 'TWD')  { echo 'selected'; } ?> value="TWD">New Taiwan Dollar TWD</option>
                            <option class="level-0" <?php if ($selected_category == 'THB')  { echo 'selected'; } ?> value="THB">Thai Baht THB</option>
                            <option class="level-0" <?php if ($selected_category == 'TRY')  { echo 'selected'; } ?> value="TRY">Turkish Lira TRY</option>
                       </select>

                       <label class="option-description"><?php echo $input_type['description']?></label>

                   </div>

               </div>

                           <?php     }


                        //      if is input type stylechanger

                        if ($input_type['type']  == 'stylechanger') {

                            $selected_style = get_option($input_type['name']);

                            ?>

                <div class="option-section">

                    <label class="option-title"><?php echo $input_type['label']?></label>

                                <?php foreach ($input_type['styles'] as $styleobject) { ?>

                        <div class="one-style">

                                    <input type="radio" name="<?php echo $input_type['name']; ?>" value="<?php echo $styleobject; ?>"  class="style-radio" <?php if($selected_style == $styleobject){echo 'checked';}?> >

                                    <div class="style-preview" style="background-image:url(<?php echo get_template_directory_uri()?>/stylechanger/<?php echo $styleobject?>.png);background-color:<?php echo $styleobject?>;"></div>

                        </div>

                                <?php } ?>

                    <label class="option-description"><?php echo $input_type['description']?></label>

                </div>

                            <?php   }



                        //      if is input type stylechanger

                        if ($input_type['type']  == 'colorpicker') {?>

                    <script type="text/javascript">
                        jQuery(document).ready(function() {
                            jQuery('#<?php echo $input_type['name']?>_colorpicker').farbtastic('#<?php echo $input_type['name']?>_color');
                        })
                    </script>

                <div class="option-section">

                    <label class="option-title"><?php echo $input_type['label']?></label>

                    <?php $item_color = get_option($input_type['name']);


                                if($item_color=="") {

                                    $item_color='#e8eff0';  } ?>

                    <form><input type="text" id="<?php echo $input_type['name']?>_color" name="<?php echo $input_type['name']?>" value="<?php echo $item_color?>" class="picker-text"/></form>

                    <div id="<?php echo $input_type['name']?>_colorpicker" class="picker-box"></div>

                    <label class="option-description" rev="picker_on"><?php echo $input_type['description']?></label>

                </div>

                <?php

                        }

                    } ?>

                            </div>


             <?php    }

                ?>


        </div>

        <a class="insert_dummy" href="<?php home_url()?>?page=Dealers-theme&dummy=1">Insert dummy content</a>


        <input type="submit" value="Save" name="admin_submit" class="submitbutton"/>

    </div>

</form>



<?php }

function theme_transaction(){

include(TEMPLATEPATH."/admin/transactions.php");


}


function theme_withdrawals(){

include(TEMPLATEPATH."/admin/withdrawals.php");


}

?>
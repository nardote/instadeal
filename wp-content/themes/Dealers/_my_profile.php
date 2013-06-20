<?php
/*

Template Name: User Profile

*/
get_header();


global $current_user;
get_currentuserinfo();
if ( is_user_logged_in() ) {
$user_username = $current_user->user_login;
$user_email = $current_user->user_email;
$user_first_name = get_user_meta($current_user->ID, 'first_name', true);
$user_last_name = get_user_meta($current_user->ID, 'last_name', true);
$user_old_company = get_user_meta($current_user->ID, 'last_name', true);
$user_old = get_user_meta($current_user->ID, 'last_name', true);

if($user_first_name !== '' && $user_last_name !== ''){$hello_user = $user_first_name.' '.$user_last_name;}
else{
    $hello_user = $current_user->display_name;
}

$username_exists = false;
if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) &&  $_POST['action'] == "new_deal") {

$user_username = $_POST['user_username'];
$user_password = $_POST['user_password'];
$user_re_password = $_POST['user_re_password'];
$user_name = $_POST['user_name'];
$user_surname = $_POST['user_surname'];
$user_email = $_POST['user_email'];
$user_company = $_POST['user_company'];
$user_website = $_POST['user_website'];

            if($user_password !== 'Password' && $user_password == $user_re_password) {
                wp_update_user( array ('ID' => $current_user->data->ID, 'user_pass' => $user_password) ) ;
            }

            if (is_email($user_email) && $user_email !== $current_user->data->user_email) {
                wp_update_user( array ('ID' => $current_user->data->ID,  'user_email' => $user_email) ) ;
            }

            if($user_name !== 'Name') {
                update_user_meta( $current_user->data->ID, 'first_name', $user_name );

            }

            if($user_surname !== 'Surname') {
                update_user_meta( $current_user->data->ID, 'last_name', $user_surname );

            }

            if($user_website !== 'Website') {
                update_user_meta( $current_user->data->ID, 'company', $user_company );

            }

            if($user_company !== 'Company') {
                update_user_meta( $current_user->data->ID, 'website', $user_website );
            }


}else{

        $user_username = $current_user->data->user_login;
        $user_email =$current_user->data->user_email;
        $user_name = get_user_meta($current_user->data->ID, 'first_name', true);
        $user_surname = get_user_meta($current_user->data->ID, 'last_name', true);
        $user_company = get_user_meta($current_user->data->ID, 'company', true);
        $user_website = get_user_meta($current_user->data->ID, 'website', true);

}


?>
    <!------ CONTENT ------>
    <div class="content">
        <div class="wrapper">

            <div class="content-background">
                <div class="content-wripper">

                    <div class="content-others left">

                        <div class="my-title-nav left">
                            <div class="my-profile-title left"><h1>Hello, <?php echo $hello_user?></h1></div>

                                <?php get_template_part( 'user_header' ); ?>
                            
                        </div><!--/my-title-nav-->

   
                        <div class="form">
                <!--FORM-->
                            <div class="title-border-content left">
                                <h2>Your current profile</h2>
                            </div><!--/title-border-->

                        <form class="new_deal" name="new_deal" method="post" action=""  enctype="multipart/form-data">
                                <div class="form-content left">

                                    <input type="text" value="<?php echo $user_username?>" name="user_username" id="user_username" readonly="readonly" />

                                    <input style="width: 194px;" type="text" onfocus="if(value==defaultValue)value=''" onblur="if(value=='')value=defaultValue" value="Password" name="user_password" id="user_password"/>

                                    <input style="width: 194px; margin-right: 0;" type="text" onfocus="if(value==defaultValue)value=''" onblur="if(value=='')value=defaultValue" value="Re-type password" name="user_re_password" id="user_re_password"/>

                                    <input style="width: 194px;" type="text" onfocus="if(value==defaultValue)value=''" onblur="if(value=='')value=defaultValue" value="<?php if($user_name !==''){echo $user_name;}else{echo 'Name';}?>" name="user_name" id="user_name"/>

                                    <input style="width: 194px;" type="text" onfocus="if(value==defaultValue)value=''" onblur="if(value=='')value=defaultValue" value="<?php if($user_surname !==''){echo $user_surname;}else{echo 'Surname';}?>" name="user_surname" id="user_surname"/>

                                    <input style="margin-right: 0;" type="text" onfocus="if(value==defaultValue)value=''" onblur="if(value=='')value=defaultValue" value="<?php if($user_email !==''){echo $user_email;}else{echo 'E-mail Address';}?>" name="user_email" id="user_email" />

                                    <input type="text" onfocus="if(value==defaultValue)value=''" onblur="if(value=='')value=defaultValue" value="<?php if($user_company !==''){echo $user_company;}else{echo 'Company';}?>" name="user_company" id="user_company"/>
                                    
                                    <input style="margin-right: 0;" type="text" onfocus="if(value==defaultValue)value=''" onblur="if(value=='')value=defaultValue" value="<?php if($user_website !==''){echo $user_website;}else{echo 'Website';}?>" name="user_website" id="user_website"/>

                                </div><!--/form-content-->

                                <div class="clear"></div>

                                <div class="form-button">
                                        <div class="button-send">
                                            <div class="button-send-left left"></div>
                                            <div class="button-send-center left"><input name="user_submit" type="submit" id="submit" class="emailsubmit"  tabindex="5" value="Submit"  /></div>
                                            <div class="button-send-right left"></div>
                                        </div>
                                </div><!--/form-button-->

                                <div id="contact-error"><?php if($username_exists==true){echo 'Username is already taken';}?></div>
                                <div class="ajax" id="ajax"></div>

                        <input type="hidden" name="action" value="new_deal" />

                        <?php wp_nonce_field( 'new_deal' ); ?>

                </form><!--close form -->



            </div> <!--close left_content -->
                        </div><!--/form-->
        </div> <!---->

        <div class="clear-both"></div>
    </div><!--front-info-box-->

</div><!--/content-->
</div><!--/content-->
<?php get_footer(); ?>
<?php }
else{
    @wp_redirect( home_url().'/wp-login.php' );
echo '
<script type="text/javascript">
<!--
window.location = "'.get_option('siteurl').'/wp-login.php";
//-->
</script>';
}
?>
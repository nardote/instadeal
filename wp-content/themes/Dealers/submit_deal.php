<?php
/*

Template Name: Submit

*/
get_header();
global $current_user;
get_currentuserinfo();


if ( is_user_logged_in() ) {

if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) &&  $_POST['action'] == "new_post") {

$deal_title = $_POST['deal_title'];

$submit_message =$_POST['submit_message'];

$dicounted_price = $_POST['submit_dicounted_price'];

$regular_price = $_POST['submit_regular_price'];

$start_date = $_POST['submit_start_date'];

$end_date = $_POST['submit_end_date'];

$deal_info =$_POST['deal_info'];

$deal_type =$_POST['deal_type'];

    // ADD THE FORM INPUT TO $new_post ARRAY
    $new_post = array(
    'post_title'    =>   $deal_title,
    'post_status'   =>   'draft', 
    'post_content'   =>   $submit_message,
    'post_type' =>   'deals' ,
    'post_author'   => $current_user->data->user_login,
    );

    //SAVE THE POST
    $pid = wp_insert_post($new_post);

    if ($_FILES) {
        foreach ($_FILES as $file => $array) {
            $newupload = insert_attachment($file,$pid);
            // $newupload returns the attachment id of the file that
            // was just uploaded. Do whatever you want with that now.
        }
    }

        $deal_owner = ($current_user->data->user_login);

        add_post_meta($pid, 'deal_owner', $deal_owner);

        add_post_meta($pid, 'start_date', $start_date);

        add_post_meta($pid, 'end_date', $end_date);

        add_post_meta($pid, 'real_price', $regular_price);

        add_post_meta($pid, 'discount_price', $dicounted_price);

        add_post_meta($pid, 'deal_info', $deal_info);

        add_post_meta($pid, 'deal_type', $deal_type);

        @$newupload = insert_attachment($file,$pid);

        if($deal_type == 'coupon'){
            insert_coupons($deal_info, $pid);
        }

        $post_sent_message = 'Congratulation your deal has been successfuly sent.';
}

do_action('wp_insert_post', 'wp_insert_post');

?>

    <!------ CONTENT ------>
    <div class="content">
        <div class="wrapper">

            <div class="content-background">
                <div class="content-wripper">



                    <div class="content-others left">


                <?php
                /* Run the loop to output the page.
					 * If you want to overload this in a child theme then include a file
					 * called loop-page.php and that will be used instead.
                */
                //get_template_part( 'loop', 'page' );
                wp_reset_query();
                if ( have_posts() ) : while ( have_posts() ) : the_post();
                        the_content();
                    endwhile;
                else:
                endif;
                wp_reset_query();
                ?>

                <!-- Validate script -->
                <script type="text/javascript">
                    function validate_email(field,alerttxt)
                    {
                        with (field)
                        {
                            apos=value.indexOf("@");
                            dotpos=value.lastIndexOf(".");
                            if (apos<1||dotpos-apos<2)
                            {$('#contact-error').empty().append(alerttxt);return false;}
                            else {return true;}
                        }
                    }

                    function check_field(field,alerttxt,checktext){
                        with (field)
                        {
                            var checkfalse = 0;
                            if(field.value == ""){
                                $('#contact-error').empty().append(alerttxt);
                                field.focus();checkfalse=1;}

                            if(field.value==checktext)
                            {
                                $('#contact-error').empty().append(alerttxt);
                                field.focus();checkfalse=1;}

                            if(checkfalse==1){return false;}else{return true;}
                        }
                    }

                    function checkForms(thisform)
                    {
                        with (thisform)
                        {
                            var error = 0;

/*                           var deal_info = document.getElementById('deal_info');
                            if(check_field(deal_info,"Deal information is needed","")==false){
                                error = 1;
                            }*/

                            var fileName_small = document.getElementById('fileName_small');
                            if(check_field(fileName_small,"Small image not inserted","Upload Small Image ( 268 x 133 Recomended)")==false){
                                error = 1;
                            }

                            var fileName_large = document.getElementById('fileName_large');
                            if(check_field(fileName_large,"Large image not inserted","Upload Large Image ( 566 x 293 Recomended)")==false){
                                error = 1;
                            }

                            var submit_dicounted_price = document.getElementById('submit_dicounted_price');
                            if(check_field(submit_dicounted_price,"Discounted price not inserted, or it's not a number","Discounted price")==false){
                                error = 1;
                            }else{
                                if (isNaN( $("#submit_dicounted_price").val() )) {
                                    $('#contact-error').empty().append("Discounted price not inserted, or it's not a number");$('#submit_dicounted_price').val('').focus();
                                    error = 1;
                                }
                            }

                            var submit_regular_price = document.getElementById('submit_regular_price');
                            if(check_field(submit_regular_price,"Regular price not inserted, or it's not a number","Regular price")==false){
                                error = 1;
                            }else{
                                if (isNaN( $("#submit_regular_price").val() )) {
                                    $('#contact-error').empty().append("Regular price not inserted, or it's not a number");$('#submit_regular_price').val('').focus();
                                    error = 1;
                                }
                            }

                            var submit_end_date = document.getElementById('submit_end_date');
                            if(check_field(submit_end_date,"Deal end date not inserted","Deal end time")==false){
                                error = 1;
                            }

                            var submit_start_date = document.getElementById('submit_start_date');
                            if(check_field(submit_start_date,"Deal start date not inserted","Deal start time")==false){
                                error = 1;
                            }
                            
                            var submit_message = document.getElementById('submit_message');
                            if(check_field(submit_message,"Message not inserted","Please enter a detailed description of your product or service as well as its regular price and discounted price:")==false){
                                error = 1;
                            }

                            var deal_title = document.getElementById('deal_title');
                            if(check_field(deal_title,"Deal title not inserted","Deal Title")==false){
                                error = 1;
                            }
                            if(error == 0){
                            var deal_title = document.getElementById('deal_title');
                            var submit_message = document.getElementById('submit_message');
                            var submit_start_date = document.getElementById('submit_start_date');
                            var submit_end_date = document.getElementById('submit_end_date');
                            var submit_regular_price = document.getElementById('submit_regular_price');
                            var submit_dicounted_price = document.getElementById('submit_dicounted_price');
                            var fileName_small = document.getElementById('fileName_small');
                            var fileName_large = document.getElementById('fileName_large');
                            var deal_info = document.getElementById('deal_info');
                                return true;
                            }
                            return false;
                        }
                    }
                </script>
                <!-- end of script -->
                        <div class="form">
                <!--FORM-->
                            <div class="title-border-content left">
                                <h2>Submit New Deal</h2>
                            </div><!--/title-border-->


                <form id="new_post" name="new_post" method="post" action="" enctype="multipart/form-data">
                                <div class="form-content left">

                                    <fieldset name="sub_deal_title">
                                    <input style="width: 300px;" type="text" onfocus="if(value==defaultValue)value=''" onblur="if(value=='')value=defaultValue" value="Deal Title" name="deal_title" id="deal_title"/>
                                    </fieldset>

                                    <fieldset name="sub_message">
                                    <textarea onfocus="if(value==defaultValue)value=''" onblur="if(value=='')value=defaultValue" name="submit_message" id="submit_message">Please enter a detailed description of your product or service as well as its regular price and discounted price:</textarea>
                                    </fieldset>

                                    <fieldset name="sub_start_time">
                                    <div class="form-input-date-button left"><input  readonly="readonly" style="width: 152px;" type="text" onfocus="if(value==defaultValue)value=''" onblur="if(value=='')value=defaultValue" value="Deal start time" name="submit_start_date" id="submit_start_date" /><input id ="submit_start_picker" type="text" class="form-date-button left" onchange="javascript: document.getElementById('submit_start_date').value = this.value"  ></div>
                                    </fieldset>

                                    <fieldset name="sub_end_time">
                                    <div class="form-input-date-button left"><input  readonly="readonly" style="width: 152px;" type="text" onfocus="if(value==defaultValue)value=''" onblur="if(value=='')value=defaultValue" value="Deal end time" name="submit_end_date" id="submit_end_date"/><input id ="submit_end_picker" type="text" class="form-date-button left" onchange="javascript: document.getElementById('submit_end_date').value = this.value"  ></div>
                                    </fieldset>

                                    <fieldset name="sub_regular_price">
                                    <input style="width: 195px;" type="text" onfocus="if(value==defaultValue)value=''" onblur="if(value=='')value=defaultValue" value="Regular price" name="submit_regular_price" id="submit_regular_price"/>
                                    </fieldset>

                                    <fieldset name="sub_discounted_price">
                                    <input style="width: 195px; margin-right: 0;" type="text" onfocus="if(value==defaultValue)value=''" onblur="if(value=='')value=defaultValue" value="Discounted price" name="submit_dicounted_price" id="submit_dicounted_price"/>
                                    </fieldset>

                                    <fieldset name="sub_sum_img_large">
                                        <div class="form-input-browse-button left"><input style="width: 347px;" type="text" onfocus="if(value==defaultValue)value=''" onblur="if(value=='')value=defaultValue" id="fileName_large" class="file_input_textbox" readonly="readonly" tabindex="1" value="Upload Large Image ( 566 x 293 Recomended)"><div class="form-browse-button left"><input type="file" name="submit_image_large" id ="submit_image_large" class="file_input_hidden submit_image_large file_upload" onchange="javascript: document.getElementById('fileName_large').value = this.value" /></div></div>
                                    </fieldset>

                                    <fieldset name="sub_sum_img_small">
                                    <div class="form-input-browse-button left" style="margin-right: 0;"><input style="width: 347px;" type="text" onfocus="if(value==defaultValue)value=''" onblur="if(value=='')value=defaultValue" id="fileName_small" class="file_input_textbox" readonly="readonly" tabindex="1" value="Upload Small Image ( 268 x 133 Recomended)"><div class="form-browse-button left"><input type="file" name="submit_image_small" id ="submit_image_small" class="file_input_hidden submit_image_large file_upload" onchange="javascript: document.getElementById('fileName_small').value = this.value" /></div></div>
                                    </fieldset>

                                    <script type="text/javascript">
                                        jQuery(document).ready(function(){
                                            $(".form-radio-button input").change(function(){

                                                 var deal_type = jQuery(this, ':checked').val();

                                                     if (deal_type =='digital'){
                                                         jQuery('#deal_info').val('Insert file download path');
                                                         jQuery('#deal_info').attr('rel','Insert file download path');
                                                     };

                                                     if (deal_type =='custom'){
                                                         jQuery('#deal_info').val('Insert custom link');
                                                         jQuery('#deal_info').attr('rel','Insert custom link');
                                                     };

                                                     if (deal_type =='coupon'){
                                                         jQuery('#deal_info').val('Insert your coupons. IMPORTANT: Each code has to be separated by new line (Enter )');
                                                         jQuery('#deal_info').attr('rel','Insert your coupons. IMPORTANT: Each code has to be separated by new line (Enter )');
                                                     };

                                            });
                                        });
                                    </script>


                                    <div class="form-radio-button left">
                                        <h2>Select the deal type:</h2>
                                        <input class="submit_radio_digital" type="radio" name="deal_type" value="digital" checked>Digital Download Deal
                                        <input class="submit_radio_custom" type="radio" name="deal_type" value="custom" >Custom link deal
                                        <input class="submit_radio_coupon" type="radio" name="deal_type" value="coupon" >Coupon deal
                                    </div><!--/form-radio-button-->

                                    <div class="clear"></div>

                                    <fieldset name="sub_deal_title">
                                        <textarea onfocus="if (value == 'Please select your deal type and insert link or coupon ID' || value == 'Insert your coupons. IMPORTANT: Each code has to be separated by new line (Enter )' || value == 'Insert custom link' || value == 'Insert file download path')value=''" onblur="if(value=='')value= jQuery(this).attr('rel')" name="deal_info" id="deal_info" rel="Please select your deal type and insert link or coupon ID">Please select your deal type and insert link or coupon ID</textarea>
                                    </fieldset>

                                </div><!--/form-content-->

                                <div class="clear"></div>

                                <div class="form-button">
                                        <div class="button-send">
                                            <div class="button-send-left left"></div>
                                            <div class="button-send-center left"><input name="submit_submit" type="submit" id="submit" class="emailsubmit"  tabindex="5" value="Submit" onclick="return checkForms(this)" /></div>
                                            <div class="button-send-right left"></div>
                                        </div>
                                </div><!--/form-button-->

                                <div id="contact-error"><?php if (isset($post_sent_message)) {echo $post_sent_message;}?></div>

	<input type="hidden" name="action" value="new_post" />

	<?php wp_nonce_field( 'new-post' ); ?>
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
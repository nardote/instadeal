<?php
/*

Template Name: Contact

*/
get_header(); ?>



    <!------ CONTENT ------>
    <div class="content">
        <div class="wrapper">

            <div class="content-background">
                <div class="content-wripper">



                    <div class="content-others left">


                



                <?php
                $name_error_msg = get_option(THEME_NAME.'_name_error_msg');
                $surname_error_msg = get_option(THEME_NAME.'_surname_error_msg');
                $email_error_msg = get_option(THEME_NAME.'_email_error_msg');
                $company_error_msg = get_option(THEME_NAME.'_company_error_msg');
                $website_error_msg = get_option(THEME_NAME.'_website_error_msg');
                $message_error_msg = get_option(THEME_NAME.'_message_error_msg');
                $mail_success_msg = get_option(THEME_NAME.'_mail_success_msg');
                $mail_error_msg = get_option(THEME_NAME.'_mail_error_msg');
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

                    function checkForm(thisform)
                    {
                        with (thisform)
                        {
                            var error = 0;

                            var message = document.getElementById('contact_message');
                            if(check_field(message,"<?php echo $message_error_msg?>","Message")==false){
                                error = 1;
                            }

                            var contactwebsite = document.getElementById('contact_website');
                            if(check_field(contactwebsite,"<?php echo $website_error_msg?>","Website")==false){
                                error = 1;
                            }

                            var contactcompany = document.getElementById('contact_company');
                            if(check_field(contactcompany,"<?php echo $company_error_msg?>","Company")==false){
                                error = 1;
                            }

                            var email = document.getElementById('contact_email');
                            if (validate_email(email,"<?php echo $email_error_msg?>")==false)
                            {email.focus();error = 1;}

                            var contactsurname = document.getElementById('contact_surname');
                            if(check_field(contactsurname,"<?php echo $surname_error_msg?>","Surname")==false){
                                error = 1;
                            }

                            var contactname = document.getElementById('contact_name');
                            if(check_field(contactname,"<?php echo $name_error_msg?>","Name")==false){
                                error = 1;
                            }


                            if(error == 0){
                            var contactname = document.getElementById('contact_name');
                            var contactsurname = document.getElementById('contact_surname');
                            var email = document.getElementById('contact_email');
                            var contactcompany = document.getElementById('contact_company');
                            var contactwebsite = document.getElementById('contact_website');
                            var message = document.getElementById('contact_message');
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
                                <h2>Send us your thoughts</h2>
                            </div><!--/title-border-->


                <form method="POST" id="contactform" onsubmit="return checkForm(this)" action="<?php echo get_template_directory_uri().'/sendcontact.php'?>">
                                <div class="form-content left">
                                    <input style="width: 194px;" type="text" onfocus="if(value==defaultValue)value=''" onblur="if(value=='')value=defaultValue" value="Name" name="contact_name" id="contact_name"/>
                                    <input style="width: 194px;" type="text" onfocus="if(value==defaultValue)value=''" onblur="if(value=='')value=defaultValue" value="Surname" name="contact_surname" id="contact_surname" />
                                    <input style="margin-right: 0;" type="text" onfocus="if(value==defaultValue)value=''" onblur="if(value=='')value=defaultValue" value="E-mail Address" name="contact_email"  id="contact_email" />
                                    <input type="text" onfocus="if(value==defaultValue)value=''" onblur="if(value=='')value=defaultValue" value="Company" name="contact_company"  id="contact_company" />
                                    <input style="margin-right: 0;" type="text" onfocus="if(value==defaultValue)value=''" onblur="if(value=='')value=defaultValue" value="Website" name="contact_website"  id="contact_website" />

                                    <textarea onfocus="if(value==defaultValue)value=''" onblur="if(value=='')value=defaultValue" name="contact_message" id="contact_message">Message</textarea>
                                </div><!--/form-content-->

                                <div class="clear"></div>

                                <div class="form-button">
                                       <input name="contact_submit" type="submit" id="submit" class="btn btn-warning"  tabindex="5" value="Submit" onclick="return checkForm(this)" />
                                </div><!--/form-button-->
                    <input type="hidden" name="returnurl" value="<?php echo get_permalink();  ?>">
                    <div id="contact-success"><?php if(isset($_GET['sent'])) {
    $what = $_GET['sent'];
    if($what == 'success') {
        echo $mail_success_msg;
    }
}
?></div>
                    <div id="contact-error"><?php if(isset($_GET['sent'])) {
    $what = $_GET['sent'];
                        if($what == 'error') {
                            echo $mail_error_msg;
    }
}
?></div>


                </form><!--close form -->
              
            </div> <!--close left_content -->
                        </div><!--/form-->
                 <div style="clear:both; margin-bottom: 40px;"></div>         
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
        </div> <!---->

        <div class="clear-both"></div>
    </div><!--front-info-box-->

</div><!--/content-->
</div><!--/content-->
    <div class="footer">
        <div class="wrapper">

        <?php get_footer('footer'); ?>


        </div><!--/wrapper-->
    </div><!--/footer-->


</div><!--/container-->

<div class="clear-both"></div>
    
<?php wp_footer(); ?>
</body>
</html>


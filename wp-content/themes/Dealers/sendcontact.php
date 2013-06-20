<?php

//loading wordpress functions
    require( '../../../wp-load.php' );


define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');


 $to = get_option('admin_email');                  //Enter your e-mail here.
 $subject = get_option('Dealers_subject_error_msg');                     //Customize your subject

$from = $_POST['contact_email'];
$name = $_POST['contact_name'];
$surname = $_POST['contact_surname'];
$website = $_POST['contact_website'];
$company = $_POST['contact_company'];
$message = $_POST['contact_message'];
$headers = "From:".$name."<".$from.">\n";
$headers .= "Reply-To:".$subject."<".$from.">\n";
$return = $_POST['returnurl'];
 $sitename =get_bloginfo('name');

 $body = "You received e-mail from ".$from.",  ".$name." ".$surname.", [".$company.", ".$website."] "." using ".$sitename."\n\n\n".$message;

 $send = mail($to, $subject, $body, $headers) ;


if($send){
wp_redirect($return.'?sent=success');
}else{
    wp_redirect($return.'?sent=error');

    }

 ?> 
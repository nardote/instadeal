<?php
/*

Template Name: My Withdrawals

*/
get_header();
global $current_user, $wpdb;
get_currentuserinfo();

if ( is_user_logged_in() ) {
$user_first_name = get_user_meta($current_user->ID, 'first_name', true);
$user_last_name = get_user_meta($current_user->ID, 'last_name', true);

if($user_first_name !== '' && $user_last_name !== ''){$hello_user = $user_first_name.' '.$user_last_name;}
else{
    $hello_user = $current_user->display_name;
}

$minimal_withdrawal = get_option(THEME_NAME.'_minimal_withdrawal');
if($minimal_withdrawal == ''){$minimal_withdrawal = 50;}

$table_name = $wpdb->prefix.THEME_NAME.'_withdrawals';

// CHECK FIRST WITHDRAW

    $querystr1 = "SELECT user_balance FROM ".$table_name." WHERE user_id = ".$current_user->ID;
    $query_result1 = $wpdb->get_results($querystr1, ARRAY_A);
    if(empty($query_result1[0])) {

         $args=array('post_type' => 'deals', 'post_status' => 'publish','paged' => 0,'posts_per_page' => 1000,'ignore_sticky_posts'=> 1, 'orderby' => 'meta_value', 'meta_key' => 'deal_owner');

            //The Query
            query_posts($args);

            $user_posts = '';

        if ( have_posts() ) : while ( have_posts() ) : the_post();

                $deal_owner = get_post_meta($post->ID, 'deal_owner', true);
                $deal_type = get_post_meta($post->ID, 'deal_type', true);
                
                if($deal_owner == $current_user->user_login ) {

                    $user_posts .= $post->ID.',';

            } endwhile;
        else:
        endif;
        
$user_posts = substr($user_posts, 0, -1);

$table_name = $wpdb->prefix.THEME_NAME. "paypal_transactions";

$querystr2 = "SELECT SUM(mc_gross*deal_perc) FROM ".$table_name. " WHERE post_ID IN (".$user_posts.")";
    $query_result2 = $wpdb->get_results($querystr2, ARRAY_A);
    $user_balance = $query_result2[0]['SUM(mc_gross*deal_perc)'];
    $user_balance = round($user_balance, 2);
    }

    // CHECK FIRST WITHDRAW

    else {
        $user_balance = $query_result1[0]['user_balance'];
    }

    if(!isset ($user_balance)){$user_balance = 0;}

    $currency = get_option(THEME_NAME.'_currency');

//POST DATA
if(isset($_POST['withdraw_amount'])){
                $current_date = date('Y-m-d G:i:s');
                $table_name = $wpdb->prefix.THEME_NAME.'_withdrawals';
                $wpdb->insert( $table_name, array( 'user_id' => $current_user->ID, 'request_date' => $current_date, 'request_amount' => $_POST['withdraw_amount'], 'user_balance' => $user_balance, 'user_paypal' => $_POST['withdraw_account'], 'payment_status' => 0) );

}


?>
   <div class="content">
        <div class="wrapper">

            <div class="content-background">
                <div class="content-wripper">

                    <div class="content-others left">
                        <div class="my-title-nav left">
                            <div class="my-profile-title left"><h1>Hello, <?php echo $hello_user?></h1></div>
                                <?php get_template_part( 'user_header' ); ?>
                        </div>


                     <form class="withdraw_form" name="withdraw_form" method="post" action=""  enctype="multipart/form-data">
                        <div class="account-withdraw-input left">
                            <ul>
                                <li>Amount to withdraw:</li>
                                <li class="withdraw-input-one left"><input type="text" onfocus="if(value==defaultValue)value=''" onblur="if(value=='')value=defaultValue" value="<?php echo print_money_symbol($currency).' '.$user_balance?>" name="withdraw_amount" /></li>
                                <li class="withdraw-input-two left"><input type="text" onfocus="if(value==defaultValue)value=''" onblur="if(value=='')value=defaultValue" value="PayPal Account" name="withdraw_account" /></li>
                            </ul>
                            <ul>
                            <?php if ((int)$user_balance < (int)$minimal_withdrawal){ echo 'You dont have enough to withdraw. Minimal withdraw limit is: '.print_money_symbol($currency).' '.$minimal_withdrawal.', you have: '.print_money_symbol($currency).' '.$user_balance; } else{?>

                                <div class="form-button">
                                        <div class="button-send">
                                            <div class="button-send-left left"></div>
                                            <div class="button-send-center left"><input name="user_submit" type="submit" id="submit" class="emailsubmit"  tabindex="5" value="Submit"  /></div>
                                            <div class="button-send-right left"></div>
                                        </div>
                                </div><!--/form-button-->
                                
                            <?php }?>
                            </ul>
                        </div><!--/account-withdraw-input-->
                     </form>

                        <div class="account-withdraw-table left">
                            <TABLE>
                                <TR CLASS="table-one-row">
                                    <TD CLASS="table-one-column" style="width: 142px!important; word-wrap: break-word; text-align: left; padding-left: 20px;">REQUEST DATE</TD>
                                    <TD CLASS="table-one-column" style="width: 106px!important; word-wrap: break-word;">AMOUNT</TD>
                                    <TD CLASS="table-one-column" style="width: 480px!important; text-align: left; padding-left: 20px; word-wrap: break-word; ">REQUEST ACCOUNT</TD>
                                    <TD CLASS="table-one-column" style="width: 113px!important; word-wrap: break-word;">STATUS</TD>
                                </TR>

                                <?php

                                $table_name = $wpdb->prefix.THEME_NAME.'_withdrawals';

                                $querystr2 = "SELECT * FROM ".$table_name." WHERE user_id = ".$current_user->ID;

                                $query_result2 = $wpdb->get_results($querystr2, ARRAY_A);
                                foreach($query_result2 as $one_request) {

                                    $withdrawal_date = explode(' ', $one_request['request_date']);

                                    if ( $one_request['payment_status'] == 0) {
                                        $withdraw_state = 'Pending';
                                        $deal_state = 'Expired';
                                    }
                                    else {
                                        $withdraw_state = 'Payed';
                                        $deal_state = 'Active';
                                    }
                                    ?>


                                <TR>
                                    <TD style="width: 142px!important; text-align: left; padding-left: 20px;"><?php echo $withdrawal_date[0]?></TD>
                                    <TD><?php echo $one_request['request_amount']?></TD>
                                    <TD style="width: 480px!important; text-align: left; padding-left: 20px;"><?php echo $one_request['user_paypal']?></TD>
                                    <TD><div class="table-<?php echo $deal_state?>"><?php echo $withdraw_state?></div></TD>
                                </TR>
                                    <?php
                                }
                                ?>

                            </TABLE>
                        </div>




                    </div><!--/content-others-->
                    </div><!--/content-others-->
                    </div><!--/content-others-->
                    </div><!--/content-others-->
                    </div><!--/content-others-->
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
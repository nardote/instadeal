<?php
/*

Template Name: My Deals

*/
get_header();
global $current_user;
get_currentuserinfo();


if ( is_user_logged_in() ) {
$user_first_name = get_user_meta($current_user->ID, 'first_name', true);
$user_last_name = get_user_meta($current_user->ID, 'last_name', true);

if($user_first_name !== '' && $user_last_name !== ''){$hello_user = $user_first_name.' '.$user_last_name;}
else{
    $hello_user = $current_user->display_name;
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

                        <div class="my-deals-table left">
                            <TABLE>
                                <TR CLASS="table-one-row">
                                    <TD CLASS="table-one-column" style="width: 165px!important; word-wrap: break-word; text-align: left; padding-left: 20px;">TITLE</TD>
                                    <TD CLASS="table-one-column" style="width: 127px!important; word-wrap: break-word;">START DATE</TD>
                                    <TD CLASS="table-one-column" style="width: 120px!important; word-wrap: break-word;">END DATE</TD>
                                    <TD CLASS="table-one-column" style="width: 121px!important; word-wrap: break-word;">SALES NUM</TD>
                                    <TD CLASS="table-one-column" style="width: 100px!important; word-wrap: break-word;">TOTAL</TD>
                                    <TD CLASS="table-one-column" style="width: 105px!important; word-wrap: break-word;">EARNED</TD>
                                    <TD CLASS="table-one-column" style="width: 113px!important; word-wrap: break-word;">STATUS</TD>
                                </TR>

                                    
<?php

 $args=array('post_type' => 'deals', 'post_status' => array( 'publish', 'draft' ),'paged' => 0,'posts_per_page' => 1000,'ignore_sticky_posts'=> 1, 'orderby' => 'meta_value', 'meta_key' => 'deal_owner');

            //The Query
            query_posts($args);

            //The Loop
            if ( have_posts() ) : while ( have_posts() ) : the_post();

                    $currency = get_option(THEME_NAME.'_currency');
                    $real_price = get_post_meta($post->ID, 'real_price', true);
                    $discount_price = get_post_meta($post->ID, 'discount_price', true);
                    $deal_percentage = get_post_meta($post->ID, 'deal_percentage', true);
                    $start_date = get_post_meta($post->ID, 'start_date', true);
                    $end_date = get_post_meta($post->ID, 'end_date', true);
                    $deal_owner = get_post_meta($post->ID, 'deal_owner', true);
                    $deal_type = get_post_meta($post->ID, 'deal_type', true);
                    if($deal_owner == $current_user->user_login ){

                    $title = the_title('','',FALSE);

                    if ($title<>substr($title,0,110)) {
                        $dots = "...";
                    }else {
                        $dots = "";
                    }
                    if (isset($real_price) && ($real_price !=='') ) {$real_price = $real_price;};
                    if (isset($discount_price) && ($discount_price !=='') ) {$discount_price = $discount_price;};
                    if (isset($deal_percentage) && ($deal_percentage !=='') ) {$deal_percentage = $deal_percentage;};
                    if (isset($start_date) && ($start_date !=='') ) {$start_date = $start_date;};
                    if (isset($end_date) && ($end_date !=='') ) {
                        $end_date1 = $end_date;
                        $end_date = explode('/', $end_date1);
                    };
                    $discount_perc = ($discount_price*100)/$real_price;
                    $discount_perc = $discount_perc;
                    $discount_perc = round($discount_perc, 0).'%';
                    if($discount_perc<0){$discount_perc = 'invalid entry';}
                    $you_save = $real_price-$discount_price;
                    if($you_save<0){$you_save = 'invalid entry';}
                    $post_time1 = get_the_time('G:i') ;
                    $post_time = explode(':', $post_time1);
                    $fulltime = $end_date1.' '.$post_time1;
                    $fulltime = strtotime($fulltime);
                    $server_time = time();

                    if($deal_type == 'coupon'){

                    $table_name = $wpdb->prefix . THEME_NAME.'_coupons';

                    $querystr = "SELECT COUNT(coupon) FROM ".$table_name."
                                        WHERE postid = ".$post->ID." AND available = 0";

                    $result = $wpdb->get_results($querystr,ARRAY_A);

                    $total_sales = (int)$result*$discount_price;

                    $earned_money = (int)$total_sales*$deal_percentage/100;

                    }else{
                         $querystr2 = "SELECT COUNT(post_ID) FROM ".$wpdb->prefix .THEME_NAME. "paypal_transactions WHERE post_ID = ".$post->ID;
                         $pageposts = $wpdb->get_results($querystr2, ARRAY_A);

                         $result = $pageposts[0]['COUNT(post_ID)'];
                         
                         $total_sales = (int)$result*$discount_price;

                         $earned_money = $total_sales*$deal_percentage/100;
                    }

                    if ( $server_time < $fulltime) {
                        $deal_state = 'Active';
                    }
                    else {
                        $deal_state = 'Expired';
                    }

                    if($post->post_status == 'draft'){
                        $deal_state = 'Pending';
                    }
                    ?>

                                <TR>
                                    <TD><?php echo substr($title,0,110).$dots; ?></TD>
                                    <TD><?php echo $start_date; ?></TD>
                                    <TD><?php echo $end_date1; ?></TD>
                                    <TD><?php echo (int)$result?></TD>
                                    <TD><?php echo print_money_symbol($currency).' '.$total_sales ?></TD>
                                    <TD><?php echo print_money_symbol($currency).' '.$earned_money?></TD>
                                    <TD><div class="table-<?php echo $deal_state?>"><?php echo $deal_state?></div></TD>
                                </TR>
                                <?php } endwhile;?>
                                <?php else: ?>
                                <?php endif; ?>

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
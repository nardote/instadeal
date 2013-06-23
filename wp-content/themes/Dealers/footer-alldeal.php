<!------ FOOTER ------>
<?php global $posts; 
$feature_deal = $posts;

?>

    <div class="footer">
        <div class="wrapper">
            <div class="footer-background">
                <div class="footer-wripper">
                    <!-- BORDER-HORIZONTAL -->
                    <div class="all-deals home">
                        All deals
                    </div>

                    <?php $check_banner = get_option(THEME_NAME.'_bottom_banner');
                            if ($check_banner == 1){
                    ?>
                    <!-- SPONZORI-LOGO -->
                    <div class="sponzori-logo">
                        <img src="<?php echo get_option(THEME_NAME.'_banner_image');?>" title="" alt="#" />
                    </div>

                    <div class="border-horizontal"></div>

                    <?php } ?>

                    <!-- BORDER-HORIZONTAL -->

                    <!-- BLOG-SMALL -->
                    <div class="blog-small-home">

    <?php

            $slug = get_page_link();
            
            wp_reset_query();
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 0;
           
            
          /*  echo "<pre>";
                                       print_r($GLOBALS[ 'categoria' ][0]->cat_ID);
                                       echo "</pre>"; */
            $args=array('post_type' => 'deals', 'post_status' => 'publish','paged' => 0,'ignore_sticky_posts'=> 1,'order' => 'DESC');

            //The Query
            query_posts($args);
            $post_counter = 1;
            //The Loop
            if ( have_posts() ) : while ( have_posts() ) : the_post();
         //   echo $post->ID .'---'. $feature_deal->ID;
                    if($post->ID == $feature_deal->ID) {
                        continue;
                    }
                    $currency = get_option(THEME_NAME.'_currency');
                    $real_price = get_post_meta($post->ID, 'real_price', true);
                    $discount_price = get_post_meta($post->ID, 'discount_price', true);
                    $start_date = get_post_meta($post->ID, 'start_date', true);
                    $end_date = get_post_meta($post->ID, 'end_date', true);
                    $deal_type = get_post_meta($post->ID, 'deal_type', true);
                    $deal_info = get_post_meta($post->ID, 'deal_info', true);
                    $deal_image_1 = get_post_meta($post->ID, '_wp_attached_file_2', true);

                    $title = the_title('','',FALSE);

                    if ($title<>substr($title,0,30)) {
                        $dots = "...";
                    }else {
                        $dots = "";
                    }?>

                    <?php
                    $authorid = $post->post_author;
                    $author = get_userdata($authorid);
                    $written = $author->user_login;
                    if (isset($real_price) && ($real_price !=='') ) {$real_price = $real_price;};
                    if (isset($discount_price) && ($discount_price !=='') ) {$discount_price = $discount_price;};
                    if (isset($start_date) && ($start_date !=='') ) {$start_date = $start_date;};
                    if (isset($deal_type) && ($deal_type !=='') ) {$deal_type = $deal_type;};
                    if (isset($deal_info) && ($deal_info !=='') ) {$deal_info = $deal_info;};
                    if (isset($end_date) && ($end_date !=='') ) {
                        $end_date1 = $end_date;
                        $end_date = explode('/', $end_date1);
                    };
                    @$discount_perc = ($discount_price*100)/$real_price;
                    $discount_perc = $discount_perc;
                    $discount_perc = round($discount_perc, 0).'%';
                    
                    if($discount_perc<0){$discount_perc = 'invalid entry';}
                    $you_save = $real_price-$discount_price;
                    if($you_save<0){$you_save = 'invalid entry';}
                    preg_match('/(\d{4})\-(\d{2})\-(\d{2})\s(\d{2})\:(\d{2})\:(\d{2})/i', $post->post_date_gmt, $matches);
                    $fulltime = strtotime($end_date[2].'-'.$end_date[0].'-'.$end_date[1].' '.$matches[4].':'.$matches[5].':'.$matches[6]);
                    $server_time = gmdate('Y-m-d G:i:s');
                    $server_time= strtotime($server_time);
                    ?>
                        
                        <div class="blog-small">
                            <!--<div class="title-blog-small"><a href="<?php the_permalink(); ?>"><?php echo substr($title,0,30).$dots; ?></a></div><!--/title-blog-small-->
                            <div class="images-small">
                                    <a href="<?php echo the_permalink()?>" class="pirobox " title="<?php the_title(); ?>" rel="single" class="hlink">
                                        <img src="<?php echo $deal_image_1?>" alt="_" title="<?php the_title();?>" />
                                    </a>

                                <div class="statistic">
                                    <h2><?php echo substr($title,0,55); ?></h2>
                                    <ul>
                                        <li class="discount">Discount: <?php echo $discount_perc?> </li>
                                        <li class="separador">|</li>
                                        <li>Price: <s><?php echo print_money_symbol($currency).' '.$real_price?></s> &raquo; <?php echo print_money_symbol($currency).' '.$you_save?></li>
                                    
                                    </ul>
                                   <div class="description-deal">
                                    <h2><?php echo $title; ?></h2>
                                    <p><?php substr(strip_tags(the_excerpt()),0,200);?></p>
                                   </div>
                                    
                                        <a href="<?php the_permalink(); ?>" class="btn btn-warning">
                                            View Deal!
                                        </a><!--/button-->
                                </div><!--statistic-->
                            </div><!--/images-small-->
                            <div class="blog-small-button">

                        
                                
                                
                            </div><!--/blog-small-button-->
                        </div><!--/blog-small-->

                        <?php if($post_counter%3 !== 0){ ?> <div class="border-vertical"></div><?php } ?>
                        
                                <?php $post_counter++;endwhile;?>
                                <?php else: ?>
                                <?php endif; ?>

                    </div><!--blog-small-home-->

                   
                </div><!--content-wripper-->
            </div><!--footer-background-->

            <?php get_footer('footer'); ?>

        </div><!--/wrapper-->
    </div><!--/footer-->


</div><!--/container-->

<div class="clear-both"></div>

<?php wp_footer(); ?>
</body>
</html>
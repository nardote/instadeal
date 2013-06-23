<?php get_header();?>


<!------ CONTENT ------>
    <div class="content">
        <div class="wrapper">

            <div class="content-background">
                <div class="content-wripper">
                    <div class="blog-home">

            <?php
                $use_fetured_category = get_option(THEME_NAME.'_use_featured_category');
                if ($use_fetured_category == 1) {
                            $featured_post_category = get_option(THEME_NAME.'_featured_category');
                                $categories = get_categories('orderby=name');
                                $include_category = null;
                                $slug = get_page_link();
                                if($featured_post_category !== '') {
                                    if (is_array($featured_post_category)) {
                                        $allcat = implode(',', $featured_post_category);
                                    }else {
                                        $allcat = $featured_post_category;
                                    }
                                }

                    $args=array('cat'=>$allcat, 'post_type' => 'deals', 'post_status' => 'publish','paged' => 0,'posts_per_page' => 1,'ignore_sticky_posts'=> 1);
                    
                } else {
                    $args=array('post_type' => 'deals', 'post_status' => 'publish','paged' => 0,'posts_per_page' => 1,'ignore_sticky_posts'=> 1);
                }

            //The Query
           // query_posts($args);
            
            
            
            
             $querystr = "
                SELECT $wpdb->posts.* 
                FROM $wpdb->posts, $wpdb->postmeta
                WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id 
                AND $wpdb->postmeta.meta_key  = 'maindeal' 
                AND $wpdb->postmeta.meta_value  = 'yes' 
                    
                ORDER BY $wpdb->posts.post_date DESC
             ";

                $pageposts = $wpdb->get_results($querystr);
          
               
               $posts = $pageposts[0];
              
           
            if ( $posts ) : 
                

                    $currency = get_option(THEME_NAME.'_currency');
                    $real_price = get_post_meta($posts->ID, 'real_price', true);
                    $discount_price = get_post_meta($posts->ID, 'discount_price', true);
                    $start_date = get_post_meta($posts->ID, 'start_date', true);
                    $end_date = get_post_meta($posts->ID, 'end_date', true);
                    $deal_type = get_post_meta($posts->ID, 'deal_type', true);
                    $deal_info = get_post_meta($posts->ID, 'deal_info', true);
                    $deal_image_1 = get_post_meta($posts->ID, '_wp_attached_file_1', true);

                    $title = $posts->post_title;//the_title('','',FALSE);

                    if ($title<>substr($title,0,30)) {
                        $dots = "...";
                    }else {
                        $dots = "";
                    }?>


                    <?php
                    $authorid = $posts->post_author;
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
                  
                    $discount_perc = ($discount_price*100)/$real_price;
                    $discount_perc = $discount_perc;
                    $discount_perc = round($discount_perc, 0).'%';
                    if($discount_perc<0){$discount_perc = 'invalid entry';}
                    $you_save = $real_price-$discount_price;
                    if($you_save<0){$you_save = 'invalid entry';}
                    preg_match('/(\d{4})\-(\d{2})\-(\d{2})\s(\d{2})\:(\d{2})\:(\d{2})/i', $posts->post_date_gmt, $matches);
                    $fulltime = strtotime($end_date[2].'-'.$end_date[0].'-'.$end_date[1].' '.$matches[4].':'.$matches[5].':'.$matches[6]);
                    $server_time = gmdate('Y-m-d G:i:s');
                    $server_time= strtotime($server_time);
                    ?>

                    <!-- BLOG -->
                        <div class="blog-left">
                            <!--<div class="title-blog"><a href="<?php the_permalink(); ?>"><?php echo substr($title,0,30).$dots; ?></a></div><!--/title-blog-->
                            <div class="images">
                                <a href="<?php echo get_permalink($posts->ID);//echo the_permalink()?>" class="pirobox " title="<?php $title; ?>" rel="single">
                                    <img src="<?php echo $deal_image_1?>" alt="_" title="<?php the_title();?>" style="width:920px; height:391px;" />
                                </a>
                            </div><!--/images-->
                           
                        </div><!--/blog-left-->


                        <script type="text/javascript">
                        jQuery(document).ready(function(){
                            $('.countdown').countdown({until: new Date(<?php echo $end_date[2]?>, <?php echo $end_date[0]?>-1, <?php echo $end_date[1]?>, <?php echo $matches[4]?>, <?php echo $matches[5]?>, <?php echo $matches[6]?>), layout: '{dn} days {hnn} hrs {mnn} min {snn} sec', compact: true, timezone:0});
                        })
                        </script>
                        
                        <div class="blog-right">
                            
                            <div class="blog-right-text">
                                <div class="title-home-deal">
                                    <?php echo $title; ?>
                                </div>



                                <!--<span style="padding-top: 22px;">This deal will end in:</span><br />
                                <p class="countdown" style="padding-top: 12px;"></p><br />-->
                                
                                <div class="descripcion-home-deal">
                                
                                    <h2>
                                        <span>Price: </span>
                                        <span class="old"><?php echo print_money_symbol($currency).' '.$real_price;?></span> &raquo;
                                        <span style="margin-top: 0;"><?php echo print_money_symbol($currency).' '.$you_save;?></span>
                                    </h2>
                                    <h3>
                                        <span>Discount: <?php echo $discount_perc;?></span>
                                    </h3>
                                   
                                    <p><?php echo substr(strip_tags($posts->post_content),0,115);?> ...</p>
                                   
                                    
                                    <?php
                                    if($deal_type == 'coupon' ) {
                                        $table_name = $wpdb->prefix . THEME_NAME.'_coupons';

                                        $querystr = "SELECT COUNT(coupon) FROM ".$table_name."
                                                            WHERE postid = ".$posts->ID." AND available = 1";

                                        $result = $wpdb->get_results($querystr,ARRAY_A);

                                        $result = $result[0]['COUNT(coupon)'];
                                        
                                    }else {
                                        $result = '1';
                                    }

                                    if ( 1==1) {

                                        $paypal_redirect   = '';
                                        $paypal_email      = get_option(THEME_NAME.'_paypal_email');
                                        $currency          = get_option(THEME_NAME.'_currency');
                                        $notify_url        = home_url().'/?paypal=1';
                                        $return            = get_option(THEME_NAME.'_return_url');
                                        $product_cost      = urlencode($discount_price);
                                        $product_name      = get_the_title();
                                        $item_number       = '';
                                        $subscription_key  = urlencode(strtolower(md5(uniqid())));
                                        $item_name         = urlencode(''.$product_name.'');
                                        $sandbox           = get_option(THEME_NAME.'_paypal_sandbox');

                                        if($sandbox == '1') {
                                            $sendbox_addon = 'sandbox.';
                                        }else {
                                            $sendbox_addon = '';
                                        }

                                        $custom_secret = md5(date('Y-m-d H:i:s').''.rand(1,10).''.rand(1,100).''.rand(1,1000).''.rand(1,10000));
                                        $custom_secret = $custom_secret.$post->ID;

                                        $paypal_redirect  .= 'https://www.'.$sendbox_addon.'paypal.com/webscr?cmd=_xclick';
                                        $paypal_redirect  .= '&business='.$paypal_email.'&item_name='.$item_name.'&no_shipping=1&no_note=1&item_number='.$subscription_key.'&currency_code='.$currency.'&charset=UTF-8&return='.urlencode($return).'&notify_url='.urlencode($notify_url).'&rm=2&custom='.$custom_secret.'&amount='.$product_cost;
                                    
                           ?>
                            <div class="btn-center">
                             <a href="<?php echo get_permalink($posts->ID);?><?php //if($deal_type == 'custom'){echo $deal_info;} else {echo $paypal_redirect;} ?>" class="btn btn-warning">View Deal!</a>
                            </div>
                             <div class="twitter-facebook">

                                        <div class="fb-like" data-href="<?php the_permalink(); ?>" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false" data-font="arial"></div>
                                        <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink(); ?>" data-count="horizontal">Tweet</a><script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>

                                    </div>
                                     <div style="clear:both"></div>
                            </div><!--blog-right-text-->
                           
                            
                        </div><!--blog-right-->
<?php }else{ ?>
                            <div class="deal-has-expired">This deal has expired!</div>

                                <?php  } // endwhile;?>
                                <?php //else: ?>
                                <?php endif; ?>

                    </div><!--blog-home-->





                </div><!--content-wripper-->
            </div><!--content-background-->
            </div>
        </div><!--/wrapper-->
    </div><!--/content-->

<?php get_footer('alldeal'); ?>
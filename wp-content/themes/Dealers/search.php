<?php get_header(); ?>


<?php

$slug = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
if ($_SERVER["SERVER_PORT"] != "80") {
    $slug .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
}
else {
    $slug .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
}

if(!strpos($slug,'page')) {
    $_SESSION['slug'] = $slug;
}

 ?>

<!------ CONTENT ------>
<div class="content">
    <div class="wrapper">

        <div class="content-background">
            <div class="content-wripper">



                <div class="content-others left">

<?php
$post_counter =1;
wp_reset_query();
                $slug = get_page_url();
                $pageslug = explode('page/',$slug);
                $pageslug = $pageslug[0];
                //The Loop
                $cellnum = 0;
                if ( have_posts() ) : while ( have_posts() ) : the_post();

                    $currency = get_option(THEME_NAME.'_currency');
                    $real_price = get_post_meta($post->ID, 'real_price', true);
                    $discount_price = get_post_meta($post->ID, 'discount_price', true);
                    $start_date = get_post_meta($post->ID, 'start_date', true);
                    $end_date = get_post_meta($post->ID, 'end_date', true);
                    $deal_type = get_post_meta($post->ID, 'deal_type', true);
                    $deal_info = get_post_meta($post->ID, 'deal_info', true);
                    $deal_image_1 = get_post_meta($post->ID, '_wp_attached_file_2', true);
                    
                        $data = get_post_meta( $post->ID, GD_THEME, true );
                        $post_img = "";
                        if (has_post_thumbnail()) {
                            $imagedata = simplexml_load_string(get_the_post_thumbnail());
                            if(!empty($imagedata)) {
                                $post_img = $imagedata->attributes()->src;
                            }
                        }
                        $title = the_title('','',FALSE);
                        if ($title<>substr($title,0,40)) {
                            $dots = "...";
                        }else {
                            $dots = "";
                        }
                        $cellnum++;
                        ?>


        <?php
        $comments = get_comments("post_id=$post->ID");
                        $num_of_comments = 0;
                        foreach((get_the_category()) as $category) {
                            $post_category = $category->cat_name;
                            $post_category_id = $category->cat_ID;
                            $cat_slug=get_cat_slug($post_category_id);
                        }

                        foreach($comments as $comm) :
                            $num_of_comments++;

                        endforeach;
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
                                        <li>Discount: <?php echo $discount_perc?> </li>
                                       
                                        <li>Price: <s><?php echo print_money_symbol($currency).' '.$real_price?></s> &raquo; <?php echo print_money_symbol($currency).' '.$you_save?></li>
                                    
                                    </ul>
                                   <div class="description-deal">
                                    <h2><?php echo $title; ?></h2>
                                    <p><?php strip_tags(truncate_post(200));?></p>
                                   </div>
                                    
                                        <a href="<?php the_permalink(); ?>" class="btn btn-warning">
                                            View Deal!
                                        </a><!--/button-->
                                </div><!--statistic-->
                            </div><!--/images-small-->
                            <div class="blog-small-button">

                        
                                
                                
                            </div><!--/blog-small-button-->
                        </div><!--/blog-small-->
                                          

                       <?php if ($post_counter%3!==0){?> 
                        <div class="border-vertical"></div> 
                            <?php } else {?>
                        <div class="clear-both"></div><div class="border-horizontal portfolio-border"></div> <?php }?>

                                <?php $post_counter++;endwhile;?>
                <?php else : ?>
                <h2 class="center">No posts found. Try a different search?</h2>
<?php endif; ?>
                <?php	//Reset Query
                wp_reset_query();
                ?>
                                </div> <!--close left_content -->

                                <div class="border-horizontal portfolio-border"></div>
                <?php
                //activate pagination
                tk_pagination(1,5,5,$_SESSION['slug']); ?>
                            </div>

                        </div> <!---->

                        <div class="clear-both"></div>
                    </div><!--front-info-box-->

                </div><!--/content-->


</div><!--/container-->

<div class="clear-both"></div>

<!------ FOOTER ------>
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

<?php get_header();
    $oldblog = get_option('id_blog_page');
?>


    <!------ CONTENT ------>
    <div class="content">
        <div class="wrapper">

            <div class="content-background">
                <div class="content-wripper">


					<?php


            $current_page_id = get_ID_by_slug($post->post_name);
            $page = get_page_by_title($post->post_name);
            $meta = (get_post_meta($current_page_id,'',true));
            $slug = get_page_link();

                                        $posts = query_posts($query_string . "&page_id=$post->ID");

                                        
                                        
					if ( have_posts() ) : while ( have_posts() ) : the_post();

                                      
                                        $currency = get_option(THEME_NAME.'_currency');
                                        $real_price = get_post_meta($post->ID, 'real_price', true);
                                        $discount_price = get_post_meta($post->ID, 'discount_price', true);
                                        $deal_type = get_post_meta($post->ID, 'deal_type', true);
                                        $deal_info = get_post_meta($post->ID, 'deal_info', true);
                                        $start_date = get_post_meta($post->ID, 'start_date', true);
                                        $end_date = get_post_meta($post->ID, 'end_date', true);
                                        
                                     /*   $deal_image_1 = get_post_meta($post->ID, '_wp_attached_file_1', true);
                                        $deal_image_2 = get_post_meta($post->ID, '_wp_attached_file_2', true);
                                        $deal_image_3 = get_post_meta($post->ID, '_wp_attached_file_3', true);
                                        $deal_image_4 = get_post_meta($post->ID, '_wp_attached_file_4', true);
                                        $deal_image_5 = get_post_meta($post->ID, '_wp_attached_file_5', true);
                                        $deal_image_6 = get_post_meta($post->ID, '_wp_attached_file_6', true);
                                        $deal_image_7 = get_post_meta($post->ID, '_wp_attached_file_7', true);
                                        $deal_image_8 = get_post_meta($post->ID, '_wp_attached_file_8', true);
                                        $deal_image_9 = get_post_meta($post->ID, '_wp_attached_file_9', true);
                                        $deal_image_10 = get_post_meta($post->ID, '_wp_attached_file_11', true);
                                     */   
                                        $arrayImagenes = array();
                                       
                                        for($i = 3; $i<= 11; $i++ ) {
                                            
                                                $imagen = get_post_meta($post->ID, '_wp_attached_file_'.$i, true);

                                                if($imagen != '') {
                                                    $arrayImagenes[] = $imagen;
                                                }
                                             
                                            
                                        }
                                        
                                        
                                        $youtube = get_post_meta($post->ID, 'youtube', true);
                                        
                                        
                                        
                                        $deal_files[1] = get_post_meta($post->ID, '_wp_attached_file_12', true);
                                        $deal_files[2] = get_post_meta($post->ID, '_wp_attached_file_13', true);
                                        $deal_files[3] = get_post_meta($post->ID, '_wp_attached_file_14', true);
                                        $deal_files[4] = get_post_meta($post->ID, '_wp_attached_file_15', true);
                                        $deal_files[5] = get_post_meta($post->ID, '_wp_attached_file_16', true);
                                        
                                       
                                        
                                       $GLOBALS[ 'categoria' ] =  get_the_category($post->ID);
                                       
                                 //      var_dump(get_the_category());
                                        $latitude = get_post_meta($post->ID, 'latitud', true);
                                        $longitude = get_post_meta($post->ID, 'longitud', true);
                                        
                                        $address = get_post_meta($post->ID, 'address', true);
                                        $tel = get_post_meta($post->ID, 'tel', true);
                                        
                                        $email = get_post_meta($post->ID, 'email', true);
                                        
					$data = get_post_meta( $post->ID, GD_THEME, true );
					$imagedata = simplexml_load_string(get_the_post_thumbnail());
					$title = the_title('','',FALSE);
					$lenght = strlen($title);
					if ($title<>substr($title,0,30)){ $dots = "...";}else{$dots = "";}
					?>

								<?php $post_img = "";
									if (has_post_thumbnail()){
										      $imagedata = simplexml_load_string(get_the_post_thumbnail());
										      if(!empty($imagedata)){
										      	$post_img = $imagedata->attributes()->src;
										      }
										   	} ?>
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
                    $discount_perc = 100-$discount_perc;
                    $discount_perc = round($discount_perc, 0).'%';
                    if($discount_perc<0){$discount_perc = 'invalid entry';}
                    $you_save = $real_price-$discount_price;
                    if($you_save<0){$you_save = 'invalid entry';}
                    preg_match('/(\d{4})\-(\d{2})\-(\d{2})\s(\d{2})\:(\d{2})\:(\d{2})/i', $post->post_date_gmt, $matches);
                    $fulltime = strtotime($end_date[2].'-'.$end_date[0].'-'.$end_date[1].' '.$matches[4].':'.$matches[5].':'.$matches[6]);
                    $server_time = gmdate('Y-m-d G:i:s');
                    $server_time= strtotime($server_time);
                    
                   
                    ?>
								<!-- BLOG -->
                        <div class="blog-left">
                            <!--<div class="title-blog"><a href="<?php the_permalink(); ?>"><?php echo substr($title,0,30).$dots; ?></a></div><!--/title-blog-->
                           <?php 
                           
                           
                           if(count($arrayImagenes)>1): ?>
                            
                            
                            
                            <div class="images slide" style="">          
                                <?php foreach($arrayImagenes as $key=>$imagen): ?>
                                
                                  <img src="<?php echo $imagen?>" alt="<?php echo $key; ?>" title="<?php the_title();?>" style="width:598px; height:389px; " />     
                                <?php endforeach; ?>
                                   
                                    
                            </div><!--/images-->
                            <?php else: ?>
                            <img src="<?php echo $arrayImagenes[0]?>" alt="_3" title="<?php the_title();?>" style="width:598px; height:389px; " />     
                            
                            <?php endif; ?>
                            <script src="<?php echo get_template_directory_uri() ?>/script/slide/js/jquery.slides.js"></script>
                            <!-- End SlidesJS Required -->

                            <!-- SlidesJS Required: Initialize SlidesJS with a jQuery doc ready -->
                            <script>
                              $(function() {
                                $('.images').slidesjs({
                                  width: 598,
                                  height: 389,
                                  play: {
                                    active: false,
                                    auto: true,
                                    interval: 4000,
                                    swap: true
                                  },
                                   pagination: {
                                    active: false
                                   }
                                });
                              });
                            </script>
                        </div><!--/blog-left-->
                        

                        <script type="text/javascript">
                        jQuery(document).ready(function(){
                            $('.countdown').countdown({until: new Date(<?php echo $end_date[2]?>, <?php echo $end_date[0]?>-1, <?php echo $end_date[1]?>, <?php echo $matches[4]?>, <?php echo $matches[5]?>, <?php echo $matches[6]?>), layout: '{dn} days {hnn} hrs {mnn} min {snn} sec', compact: true, timezone:0});
                        })
                        </script>

                        <div class="blog-right">
                            
                            <div class="blog-right-text single">
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
                                        <span>Discount <?php echo $discount_perc;?></span>
                                    </h3>
                                   
                                   <!-- <p></p>-->
                                   
                                    
                                    <?php
                                    if($deal_type == 'coupon' ) {
                                        $table_name = $wpdb->prefix . THEME_NAME.'_coupons';

                                        $querystr = "SELECT COUNT(coupon) FROM ".$table_name."
                                                            WHERE postid = ".$post->ID." AND available = 1";

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
                             <!--<a href="<?php echo the_permalink()?><?php //if($deal_type == 'custom'){echo $deal_info;} else {echo $paypal_redirect;} ?>" class="btn btn-warning">View Deal!</a>-->
                            </div>
                             <div class="twitter-facebook">
                                        <span>Share now!</span>
                                        <div class="fb-like" data-href="<?php the_permalink(); ?>" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false" data-font="arial"></div>
                                        <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink(); ?>" data-count="horizontal">Tweet</a><script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>

                                    </div>
                                     <div style="clear:both"></div>
                            </div><!--blog-right-text-->
                           
                            
                        </div><!--blog-right-->
                        
<?php }else{ ?>
                        <div class="btn-center">
                            <div class="deal-has-expired">This deal has expired!</div>
                            </div>
                             <div class="twitter-facebook">
                                        <span>Share now!</span>
                                        <div class="fb-like" data-href="<?php the_permalink(); ?>" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false" data-font="arial"></div>
                                        <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink(); ?>" data-count="horizontal">Tweet</a><script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>

                                    </div>
                                     <div style="clear:both"></div>
                            </div><!--blog-right-text-->
                           
                            
                        </div><!--blog-right-->
                            

                                <?php } endwhile;?>
                                <?php else: ?>
                                <?php endif; ?>


        </div> <!--close left_content -->
       
                </div>
                 <div style="clear:both"></div>
        <div>
        <div class="contenido-deal">
            <div class="descripcion-deal">
                <h3>Deal detail</h3>
                <p><?php the_content()?></p>
                <?php if($youtube): ?>
                <h3>Video</h3>
                <iframe width="420" height="315" src="http://www.youtube.com/embed/<?php echo $youtube; ?>" frameborder="0" allowfullscreen></iframe>
                <p></p>
                <?php endif; ?>
                
                <?php
                
                if($deal_files[1]!='' || 
                   $deal_files[2]!='' ||
                   $deal_files[3]!='' ||
                   $deal_files[4]!='' ||
                   $deal_files[5]!=''): ?>
                <h3>Downloads</h3>
                <ul>
                <?php foreach($deal_files as $key=>$value): 
                    if($value != '' ): ?>
                    <li><a target="_blank" href="<?php echo $value; ?>"><?php echo $value; ?></a></li>
                <?php 
                    endif;
                endforeach; ?>
                </ul>
                <?php endif; ?>
                
                <br>
            </div>
            
            <div class="datos-deal">
                <h3>Get this deal</h3>
                <p>This is the contact infomation.<br><?php echo $tel; ?>, <?php echo $email; ?> .</p>
                <?php if ($latitude != '' && $longitude != '') : ?>
                <script type="text/javascript"
                    src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAxi-FTjBD-JsDR1iqVylSyHJAyyX3wRaI&sensor=false">
                  </script>
                  <script type="text/javascript">
                    function initialize() {
                      var latitude = '<?php echo $latitude; ?>';
                      var longitude = '<?php echo $longitude; ?>';
                      var mapOptions = {
                        center: new google.maps.LatLng(latitude, longitude),
                        zoom: 15,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                      };
                      var map = new google.maps.Map(document.getElementById("map"),
                          mapOptions);
                      var marker = new google.maps.Marker({
                        position: new google.maps.LatLng(latitude, longitude),
                        map: map
                      });
                    }
                    window.onload = initialize;
                  </script>
                <h3>Map and Location</h3>
                <div id="map" style="width:100%; height:200px;">
                    
                </div>
                <p><?php echo $address; ?></p>
                <?php endif; ?>
            </div>
        </div>
        
        
        
    </div> <!---->

    </div><!--/content-->
    </div><!--/content-->


<?php get_footer(); ?>
<?php

  global $wpdb;

  $querystr = "SELECT ID FROM ".$wpdb->prefix."posts WHERE post_type = 'page' AND post_status = 'publish'";

                $pageposts = $wpdb->get_results($querystr, OBJECT);

                foreach($pageposts as $post){

                $check_templates = get_post_meta($post->ID, '_wp_page_template', true);

                if ($check_templates == '_my_deals.php'){
                    $my_deals_id = $post->ID;
                    $my_deals_link = get_permalink( $my_deals_id );
                }

                if ($check_templates == '_my_profile.php'){
                    $my_profile_id = $post->ID;
                    $my_profile_link = get_permalink( $my_profile_id );
                }

                if ($check_templates == '_my_withdrawals.php'){
                    $my_withdrawals_id = $post->ID;
                    $my_withdrawals_link = get_permalink( $my_withdrawals_id );
                }

                }
?>



                            <!--MENU-->
                            <div class="nav-my-profile right">
                                <ul>
                                    <li style="padding-left: 0px;"><a href="<?php echo $my_profile_link ?>">My profile</a></li>
                                    <li ><a href="<?php echo $my_deals_link ?>">My deals</a></li>
                                    <li ><a href="<?php echo $my_withdrawals_link ?>">My Withdrawals</a></li>
                                    <li style="padding-right: 0;background: none!important;"><a href="<?php echo wp_logout_url(home_url()); ?>" title="Logout">Logout</a></li>
                                </ul>
                            </div><!--/nav-->
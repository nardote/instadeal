<!--FOOTER-COPY-->

            <div class="footer-copy">
                 <!--TEXT WIDGET-->
                    <div class="footer_box">
                        <?php if(function_exists('dynamic_sidebar') && dynamic_sidebar('Footer Widget 1')) : ?>
                        <?php endif; ?>
                    </div><!--/footer_box -->

                   
                    <!--TWITTER WIDGET-->
                    <div class="footer_box">
                        <?php if(function_exists('dynamic_sidebar') && dynamic_sidebar('Footer Widget 2')) : ?>
                        <?php endif; ?>
                    </div><!--/footer_box-->

                   

                    <!--CUSTOM MENU-->
                    <div class="footer_box">
                        <?php if(function_exists('dynamic_sidebar') && dynamic_sidebar('Footer Widget 3')) : ?>
                        <?php endif; ?>
                    </div><!--footer_box-->
                    <div style="clear:both"></div>
                <div class="copy-text">                    
                    <?php $copyright = get_option(THEME_NAME.'_footer_copyright');?>
                    <p><?php echo $copyright?></p>
                    <p class="link">
                        <a href="<?php get_site_url(); ?>?page_id=8">Contact us</a> | <a href="#">Follow us on facebook</a>
                    </p>
                </div><!--copy-text-->
            </div><!--footer-copy-->
            
            
<?php

get_header(); ?>
<!------ CONTENT ------>
<div class="content">
    <div class="wrapper">

        <div class="content-background">
            <div class="content-wripper">



                <div class="content-others left">


                    <div class="title-404">Looks like the page you were<br />looking for does not exist.<br />Sorry about that.</div>

                    <div class="border-404"></div>

                    <div class="text-404">Check the web address for typos, or visit the <a href="<?php echo home_url(); ?>">home</a> page</div>



                </div><!--/content-others-->
            </div><!--/content-others-->
        </div><!--/content-others-->
    </div><!--/content-others-->
</div><!--/content-others-->

<div class="corrector">
    
    <?php

    wp_link_pages( );
    post_class();
    posts_nav_link();
    paginate_comments_links();
    language_attributes();
    add_editor_style();
    add_custom_image_heade();
    add_custom_background();
    


    ?>

</div>



<?php get_footer(); ?>
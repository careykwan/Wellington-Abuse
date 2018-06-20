<?php
/* Template Name: Two column Template */

get_header();

?>
    <div class="container">
        <div class="row">
            <div class="posts col-xs-6 col-md-4">
                <div class="image_container">
                    <div class="circleImg">
                        <img src="<?php bloginfo('template_url') ?>/images/hands.jpg" class="aboutImg" width="200" height="200" alt="holding">
                    </div>
                    <div class="circleImg">
                        <img src="<?php bloginfo('template_url') ?>/images/support.jpg" class="aboutImg" width="200" height="200" alt="support">
                    </div>
                    <div class="circleImg">
                        <img src="<?php bloginfo('template_url') ?>/images/friends.jpg" class="aboutImg" width="200" height="200" alt="friends">
                    </div>
                </div>
            </div>
                
            <div class="posts col-xs-12 col-md-8">
                <div class="about_text">
                    <h1><?php echo get_the_title(); ?></h1>

                        <?php
                            //start the loop
                            if (have_posts()) :
                                while (have_posts()) :
                                    the_post();
                                            the_content();
                                endwhile;
                            endif;	
                        ?>
                </div>
            </div>
        </div>
    </div>

<?php get_footer(); ?>
<?php 
/* Main Template file*/
get_header();
?>

<div class="container shop-container">
    <div class="row">
        <div class="full-page col-sm-12">

            <?php
                if ( have_posts() ) :
                    if ( is_home() && ! is_front_page() ) :
            ?>
                <header>
                    <h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
                </header>
                        
                    <?php
                        endif;
                    ?>

                        <h1><?php echo get_the_title() ?></h1>
                                            
                        <?php
                            endif;
                                while (have_posts()) :
                                        the_post();
                                            the_content();
                                endwhile;
                        ?>
        </div>
    </div>
</div>        

<?php get_footer();?>
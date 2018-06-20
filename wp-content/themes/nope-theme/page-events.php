<?php
/* Event Page Template */

get_header();

?>
    <div class="container event-container">
        <div class="row">
            <div class="col-12">
            
                <div class="thumbnail-img"><?php the_post_thumbnail('large'); ?></div>

                <hr>
                <h1><?php echo get_the_title(); ?></h1>
                    <p>Wellington HELP needs your support! HELP works with survivors of sexual abuse and their whānau – of any age or gender. We provide a 24 hour support line as well as social work and counselling services for anyone who has experienced rape or sexual abuse, or who is concerned about a friend or family member. This year we are on track to see 700 people, more than twice the number we are funded for. As a not-for-profit organisation, we need to fundraise in order to deliver these vital services to survivors of sexual abuse and their loved ones. We are always looking for volunteers, so let us know about your skills, interests and availability. If you register as a Friend of HELP (below), we'll also keep you in touch about events and activities we're organising - and how you can get involved - or you can even organise your own. We invite you to be part of HELP. Part of changing the future. Because it’s too important not to be</p>
                    
                        <?php 
                            
                            $currentPage = (get_query_var('paged')) ? get_query_var('paged') : 1;
                            $args = array('posts_per_page' => 3, 'paged' => $currentPage);
                            query_posts($args);
                            if( have_posts() ): $i = 0;
                                
                                while( have_posts() ): the_post(); ?>
                                    
                                    <?php 
                                        if($i==0): $column = 12; $class = '';
                                        elseif($i > 0 && $i <= 2): $column = 6; $class = ' second-row-padding';
                                        elseif($i > 2): $column = 4; $class = ' third-row-padding';
                                        endif;
                                    ?>
                                    
                                        <div class="col-xs-<?php echo $column; echo $class; ?> blog-item">
                                            <?php if( has_post_thumbnail() ):
                                                $urlImg = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
                                            endif; ?>
                                            <div class="blog-element" style="background-image: url();">
                                                
                                                <?php the_title( sprintf('<h1 class="entry-title"><a href="%s">', esc_url( get_permalink() ) ),'</a></h1>' ); ?>
                                                
                                                <small><?php the_category(' '); ?></small>
                                            </div>
                                        </div>
                                
                                    <?php $i++; endwhile; ?>
                                        
                                        <div class="col-xs-6 text-left">
                                            <?php next_posts_link('« Older Posts'); ?>
                                        </div>
                                        <div class="col-xs-6 text-right">
                                            <?php previous_posts_link('Newer Posts »'); ?>
                                        </div>
                                
                                    <?php endif;
                                        wp_reset_query();
                        ?>
            </div>           
        </div>
    </div>
    
<?php get_footer(); ?>
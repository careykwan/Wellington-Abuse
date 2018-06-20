<?php get_header(); ?>

	<div class="container">
		<div class="row row-single-post">
			<div class="col-md-9 col-sm-8">
				
				<?php 
					if( have_posts() ):
						while( have_posts() ): the_post(); ?>
							<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<div class="thumbnail-img"><?php the_post_thumbnail('large'); ?></div>
		
								<?php the_title('<h1 class="entry-title">','</h1>' ); ?>
								
								<?php if( has_post_thumbnail() ): ?>
						
								<?php endif; ?>
							
									<small><?php the_category(' '); ?> || <?php the_tags(); ?> || <?php edit_post_link(); ?></small>
							
								<?php the_content(); ?>
							
								<hr>
							
									<div class="row">
										<div class="col-xs-6 text-left"><?php previous_post_link(); ?></div>
										<div class="col-xs-6 text-right"><?php next_post_link(); ?></div>
									</div>
							</article>

					<?php endwhile;
						endif;
				?>
				
			</div>
				<div class="col-md-3"></div>
			
			
		</div>
	</div>

<?php get_footer(); ?>
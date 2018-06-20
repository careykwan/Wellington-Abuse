<?php get_header(); ?>
	<div id="primary" class="container">
		<main id="main" class="site-main" role="main">
			<section class="error-404 not-found">
				<head class="page-header">
					<h1 class="page-title"> Sorry, page not found! </h1>
				</head>
				<div class="page-content">
					<h2> It looks like nothing was found at this location. Maybe try one of the links above or click onto Home. </h2>
					

					<?php the_widget('WP_Widget_Recent_Posts');  ?>
					
				</div>
			</section>
		</main>

	</div>

<?php get_footer(); ?>
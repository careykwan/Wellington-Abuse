<?php
    /* Main Header Template */
?>
    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <?php wp_head(); ?>
    </head>

    <body>
        <!-- header -->
        <div class="logoBanner">
            <img class="logo" src="<?php bloginfo('template_url') ?>/images/mainlogo.png" alt="logo badge">
        </div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button> 

            <?php 
                wp_nav_menu( $arg = array (
                    'menu_class' => 'navbar-nav mr-auto textNav',
                    'depth'				=> 2,
                    'theme_location' => 'primary',
                    'container' => 'div',
                    'container_class' => 'collapse navbar-collapse',
                    'container_id' => 'navbarSupportedContent',
                    'walker'			=> new WP_Bootstrap_Navwalker()
                ));
            ?> 
        </nav>
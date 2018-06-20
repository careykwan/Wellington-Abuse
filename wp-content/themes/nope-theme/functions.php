<?php

    if (! function_exists ('nope_setup') ):

        function nope_setup() {
            add_theme_support( 'title-tag' );
        }
    endif;

    add_action('after_setup_theme', 'nope_setup');

    /* Register menus */

    function register_nope_menu() {
        register_nav_menus(
            array(
                'primary' => __('Primary Menu')
            )
        );
    }

    add_action('init', 'register_nope_menu');



/* 
====================================================================================
    Adding JS scripts
==================================================================================== 
    */
    
    function nope_scripts() { 
        wp_register_script('jq_331','https://code.jquery.com/jquery-3.3.1.slim.min.js', array(), '3.3.1', true);
        wp_register_script('bootstrap_popper','https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js', array(), '1.12.9', true);
        wp_register_script('bootstrap_js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js', array(), '4.0.0', true);
        wp_enqueue_script('jq_331');
        wp_enqueue_script('bootstrap_popper');
        wp_enqueue_script('bootstrap_js');
    }

    add_action( 'wp_enqueue_scripts', 'nope_scripts' ); 

    /* 
====================================================================================
    Adding CSS Styles
==================================================================================== 
    */

    function nope_styles() {
        wp_register_style('bootstrap_css', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css', array(), '4.0.0', 'all');
        wp_register_style('nope_styles', get_stylesheet_uri() );
        wp_enqueue_style('bootstrap_css');
        wp_enqueue_style('google_fonts', 'https://fonts.googleapis.com/css?family=Tajawal');
        wp_enqueue_style('nope_styles');  
    }

    add_action( 'wp_enqueue_scripts', 'nope_styles' ); 

    // Register Custom Navigation Walker
    require_once get_template_directory() . '/class-wp-bootstrap-navwalker.php';

    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'nope-theme' ),
    ) );

    //Registering side bar

    function nope_widgit_init() {
        register_sidebar( array (
                'name' => __( 'Main_sidebar', 'nope'),
                'id' => 'main-sidebar',
                'description' => __( 'This is a widget'),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget' => '</section>',
                'before_title' => '<h2 class="widget-title">',
                'after_title' => '</h2>'
        ));
    }

    add_action( 'widgets_init', 'nope_widgit_init' );
/*
==========================================
    Head function
==========================================
*/
    function awesome_remove_version() {
    return '';
    }
    add_filter('the_generator', 'awesome_remove_version');

    // adding thumbnail feature on posts
    add_theme_support('post-thumbnails');
        
    // add and create post formats
    add_theme_support('post-formats', array('aside', 'image', 'video'));



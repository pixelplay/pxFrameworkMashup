<?php 
//---------------------------------------------------------------------------------------------------- FILE: includes/functions.php

//---------------------------------------------------------------------------------------------------- REMOVE IMAGE SIZES
//---------------------------------------------------------------------------------------------------- REMOVE WORDPRESS' DEFAULT IMAGE SIZES (EXCEPT THUMBNAIL)
add_filter( 'intermediate_image_sizes_advanced', 'px_remove_default_image_sizes' );
function px_remove_default_image_sizes( $sizes) 
{
	unset( $sizes['medium'] );
	unset( $sizes['large'] );

	return $sizes;
}


//---------------------------------------------------------------------------------------------------- ADD THEME SUPPORT
//---------------------------------------------------------------------------------------------------- ENABLE VARIOUS WORDPRESS THEME FEATURES
if( function_exists( 'add_theme_support' ) ) 
{
	// ENABLE THUMBNAIL SUPPORT
    add_theme_support( 'post-thumbnails' );

    // DEFINE IMAGE SIZES
    add_image_size( 'slide-image', 960, 450, true );

    // ENABLES POST AND COMMENT RSS FEED LINKS
    add_theme_support( 'automatic-feed-links');

    // ENABLE NAVIGATION MENU ADMINISTRATOR
    add_theme_support( 'menus' );
}


//---------------------------------------------------------------------------------------------------- REGISTER NAVIGATION MENUS
add_action( 'init', 'px_register_menus' );
function px_register_menus() 
{
	register_nav_menus(
		array(
			'nav-main' 		=> 'Main Navigation'
			// REGISTER MOVE NAVIGATION MENUS HERE
		)
	);
}


//---------------------------------------------------------------------------------------------------- ENQUEUE SCRIPTS
//---------------------------------------------------------------------------------------------------- LOAD JS & JQUERY LIBRARIES THE RIGHT WAY
if (!is_admin()) add_action( 'wp_enqueue_scripts', 'px_enqueue_scripts', 11 );
function px_enqueue_scripts() 
{
	// DISABLE BUILT-IN jQUERY AND LOAD IT FROM CDN
	// wp_deregister_script( 'jquery' );
	wp_enqueue_script( 'jquery' );
	//wp_enqueue_script( 'jquery', '//cdnjs.cloudflare.com/ajax/libs/jquery/1.9.0/jquery.min.js', false, '1.9.0', true );

	// LOAD MODERNIZR FROM CDN
	// wp_enqueue_script( 'modernizr', '//cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js', 'jquery', '2.6.2', false );
	// LOAD JQUERY.CYCLE FROM CDN
	// wp_enqueue_script( 'cycle', '//cdnjs.cloudflare.com/ajax/libs/jquery.cycle/2.9999.8/jquery.cycle.all.min.js', 'jquery', '2.9999.8', true );
}


//---------------------------------------------------------------------------------------------------- IE HTML5 SHIM
//---------------------------------------------------------------------------------------------------- ADD HTML5 SHIM TO IE BROWSERS BEFORE IE9
//---------------------------------------------------------------------------------------------------- NOT NEEDED IF USING MODERNIZR
//add_action( 'wp_head', 'px_html5_shim' );
function px_html5_shim() 
{
	global $is_IE;

	if ( $is_IE ) :
		echo '<!--[if lt IE 9]>';
		echo '<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>';
		echo '<![endif]-->';
	endif;
}


//---------------------------------------------------------------------------------------------------- HEAD CLEANING
//---------------------------------------------------------------------------------------------------- REMOVE SOME OF THE CRAZY JUNK THAT WORDPRESS ADDS TO THE HEAD OF EACH PAGE
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);


//---------------------------------------------------------------------------------------------------- REMOVE ACCENTS
//---------------------------------------------------------------------------------------------------- REMOVE ACCENTS FROM GREEK POST TITLES (USEFUL WHEN TITLES ARE STYLED WITH CAPITAL LETTERS)
add_filter( 'the_title', 'px_remove_accents');
function px_remove_accents( $title )
{
    $normalizeChars = array( 'ά'=>'α', 'έ'=>'ε', 'ή'=>'η', 'ί'=>'ι', 'ό'=>'ο', 'ύ'=>'υ', 'ώ'=>'ω', 'Ά'=>'Α', 'Έ'=>'Ε', 'Ή'=>'Η', 'Ί'=>'Ι', 'Ό'=>'Ο', 'Ύ'=>'Υ', 'Ώ'=>'Ω' );
    $title = strtr( $title, $normalizeChars );
    return $title;
}


//---------------------------------------------------------------------------------------------------- DYNAMIC COPYRIGHT
//---------------------------------------------------------------------------------------------------- GENERATE COPYRIGHT DATE BASED ON FIRST AND LAST POST DATES
function px_dynamic_copyright()
{
	global $wpdb;

	$copyright_dates = $wpdb->get_results("
		SELECT
		YEAR(min(post_date_gmt)) AS firstdate,
		YEAR(max(post_date_gmt)) AS lastdate
		FROM
			$wpdb->posts
		WHERE
			post_status = 'publish'
	");

	$output = '';

	if( $copyright_dates ) :
		$copyright = "&copy; " . $copyright_dates[0]->firstdate;

		if ($copyright_dates[0]->firstdate != $copyright_dates[0]->lastdate ) :
			$copyright .= '-' . $copyright_dates[0]->lastdate;
		endif;

		$output = $copyright;
	endif;
	return $output;
}


//---------------------------------------------------------------------------------------------------- SEO TITLES
//---------------------------------------------------------------------------------------------------- BETTER TITLE TAGS FOR BETTER RANKINGS
// add_filter( 'wp_title', 'px_head_title' );
function px_head_title()
{
	$site_name = get_bloginfo( 'name' );
	$site_description = get_field( 'site_description', 'options');

	$output = $site_name;

	if( is_front_page() ) :
		$output .= ' - ' . $site_description;

	else :
		$page_title = get_the_title();
		$output = $page_title . ' - ' . $output;

	endif;	

	return $output;
}
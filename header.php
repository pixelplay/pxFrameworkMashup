		<!doctype html>

		<!--[if lt IE 7]>      	<html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes();?>> 		<![endif]-->
		<!--[if IE 7]>         	<html class="no-js lt-ie9 lt-ie8" <?php language_attributes();?>> 				<![endif]-->
		<!--[if IE 8]>         	<html class="no-js lt-ie9" <?php language_attributes();?>> 						<![endif]-->
		<!--[if gt IE 8]><!--> 	<html class="no-js" <?php language_attributes();?>> 						<!--<![endif]-->

		<head>
			<title><?php wp_title(); ?></title>
			
			<meta charset="<?php bloginfo( 'charset' ); ?>" />
			<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
			
			<meta name="description" content="<?php echo get_field( 'site_description', 'options'); ?>">
			<meta name="keywords" content="<?php echo get_field( 'site_keywords', 'options' ); ?>">

			<meta name="viewport" content="width=device-width">

			<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
			<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" />

			<!-- ALL THE PLUGIN JUNK GETS THROWN HERE -->
<?php 		wp_head(); //required hook - don't delete or it may break your site ?>
		    <!-- END OF ALL THE PLUGIN JUNK -->

<?php 		if( get_field( 'site_background', 'options' ) ) :
				$background = get_field( 'site_background', 'options' ); ?>
				<style>
					body 
					{ 
						background-image: url(<?php echo $background['url']; ?>); 
					}
				</style>
<?php 		endif; ?>
		</head>

		<body <?php body_class(); ?>>
			<div class="container">
				<header id="site-header">
					<h1 id="site-name"><a href="<?php bloginfo( 'url' ); ?>"><?php bloginfo( 'name' ); ?></a></h1>

<?php 				include( locate_template( 'parts/nav-site.php' ) ); ?>
				</header>
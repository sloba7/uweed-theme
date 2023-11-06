<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Uweed
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_directory' ) ?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php bloginfo( 'stylesheet_directory' ) ?>/assets/css/style.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;700;900&display=swap" rel="stylesheet">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'uweed' ); ?></a>


	<div id="header" class="d-flex align-items-center">
		<div class="container d-flex align-items-center">
		<div class="logo">
        <h2><a href="<?php echo get_home_url(); ?>"><?php esc_html_e('New-Shop', 'uweed') ?></a></h2>
		</div>
		<ul  class="main-nav">

</div>
	
		</ul>
	</div>

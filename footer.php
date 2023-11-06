<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Uweed
 */

?>

	<footer id="footer" class="site-footer">
		<div class="container">
	<ul class="footer-menu">
		<li><a href="#"><?php esc_html_e('Return', 'uweed') ?></a></li>
		<li><a href="#"><?php esc_html_e('Shipping', 'uweed') ?></a></li>
		<li><a href=""><?php esc_html_e('Support','uweed') ?></a></li>
	</ul>
	</div>
	</footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>



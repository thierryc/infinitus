<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * Infinitus HTML 5 theme is inspired by Wordpress Twenty_Eleven
 *
 * @package WordPress
 * @subpackage Infinitus
 * @since Infinitus 1.0
 */

get_header(); ?>

		<div id="container">
			<div id="content" role="main">

			<?php if ( is_active_sidebar( 'top-page-widget-area' ) ) : ?>
				<div id="top-page-widget-area" class="widget-area">
					<ul class="infinitus">
						<?php dynamic_sidebar( 'top-page-widget-area' ); ?>
					</ul>
				</div><!-- #Top .widget-area -->
			<?php endif; ?>			

			
			<?php
			/* Run the loop to output the page.
			 * If you want to overload this in a child theme then include a file
			 * called loop-page.php and that will be used instead.
			 */
			get_template_part( 'loop', 'page' );
			?>
			
			<?php if ( is_active_sidebar( 'bottom-page-widget-area' ) ) : ?>
				<div id="bottom-page-widget-area" class="widget-area">
					<ul class="infinitus">
						<?php dynamic_sidebar( 'bottom-page-widget-area' ); ?>
					</ul>
				</div><!-- #Bottom .widget-area -->
			<?php endif; ?>			


			</div><!-- #content -->
		</div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

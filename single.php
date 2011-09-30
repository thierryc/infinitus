<?php
/**
 * The Template for displaying all single posts.
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

			<?php
			/* Run the loop to output the post.
			 * If you want to overload this in a child theme then include a file
			 * called loop-single.php and that will be used instead.
			 */
			get_template_part( 'loop', 'single' );
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

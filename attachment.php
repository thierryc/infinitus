<?php
/**
 * The template for displaying attachments.
 *
 * Infinitus HTML 5 theme is inspired by Wordpress Twenty_Eleven
 *
 * @package WordPress
 * @subpackage Infinitus
 * @since Infinitus 1.0
 */

get_header(); ?>

		<div id="container" class="single-attachment">
			<div id="content" role="main">

			<?php
			/* Run the loop to output the attachment.
			 * If you want to overload this in a child theme then include a file
			 * called loop-attachment.php and that will be used instead.
			 */
			get_template_part( 'loop', 'attachment' );
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

<?php get_footer(); ?>

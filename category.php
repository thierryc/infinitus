<?php
/**
 * The template for displaying Category Archive pages.
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
				<header>
					<h1 class="page-title"><?php
						printf( __( 'Category Archives: %s', 'infinitus' ), '<span>' . single_cat_title( '', false ) . '</span>' );
					?></h1>
				</header>
				<?php
					$category_description = category_description();
					if ( ! empty( $category_description ) )
						echo '<div class="archive-meta">' . $category_description . '</div>';

				/* Run the loop for the category page to output the posts.
				 * If you want to overload this in a child theme then include a file
				 * called loop-category.php and that will be used instead.
				 */
				get_template_part( 'loop', 'category' );
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

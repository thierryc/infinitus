<?php
/**
 * The template for displaying Search Results pages.
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

<?php if ( have_posts() ) : ?>
				<header>
					<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'twentyten' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				</header>
				<?php
				/* Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called loop-search.php and that will be used instead.
				 */
				 get_template_part( 'loop', 'search' );
				?>
<?php else : ?>
				<article id="post-0" class="post no-results not-found">
					<h2 class="entry-title"><?php _e( 'Nothing Found', 'infinitus' ); ?></h2>
					<div class="entry-content">
						<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'infinitus' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->
<?php endif; ?>

								
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

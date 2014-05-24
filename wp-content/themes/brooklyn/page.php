<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package unitedthemes
 */

get_header(); ?>
		
        <div class="grid-container">
        	<div id="primary" class="grid-parent grid-100 tablet-grid-100 mobile-grid-100">
            
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'partials/content', 'page' ); ?>
			
				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() )
						comments_template();
				?>

			<?php endwhile; // end of the loop. ?>
			
            </div><!-- close #primary -->
		</div><!-- close grid-container -->
        
        <div class="ut-scroll-up-waypoint" data-section="section-<?php echo $post->post_name; ?>"></div>
        
<?php get_footer(); ?>

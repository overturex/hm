<?php get_header(); ?>

<div class="container">
	<div class="span12">
    	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        	<h3><?php the_title(); ?></h3>
			<div><?php the_content(); ?></div>
            <?php endwhile; else : ?>

                    <article id="post-not-found" class="hentry clearfix">
                        <header class="article-header">
                            <h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
                        </header>
                        <section class="entry-content">
                            <p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
                        </section>
                        <footer class="article-footer">
                                <p><?php _e( 'This is the error message in the page.php template.', 'bonestheme' ); ?></p>
                        </footer>
                    </article>

            <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>

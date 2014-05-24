<?php
/**
 * The template for displaying single portfolio pages.
 *
 * @package unitedthemes
 */
?>

<?php

$pageslogan   = get_post_meta( get_the_ID() , 'ut_page_slogan' , true ); 
$header_style = get_post_meta( get_the_ID() , 'ut_section_header_style' , true ); 
$header_style = ( !empty($header_style) && $header_style != 'global' ) ? $header_style : ot_get_option('ut_global_headline_style'); 

/* featured image */ 
$fullsize   = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ); 
$fullsizeID = ut_get_attachment_id_from_url( $fullsize );

/* post format */
$post_format = get_post_format();

/* portfolio details */
$ut_portfolio_details = get_post_meta( $post->ID , 'ut_portfolio_details', true ); ?>

<?php get_header(); ?>
    
    <div class="grid-container">
        	<div id="primary" class="grid-parent grid-100 tablet-grid-100 mobile-grid-100">
    			
                <?php if ( have_posts() ) : ?>
                
					<?php while ( have_posts() ) : the_post(); ?>
                    
                        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                            <div class="grid-70 prefix-15 mobile-grid-100 tablet-grid-100">
                                <header class="page-header <?php echo $header_style;?>">
                                    
                                    <h1 class="page-title"><span><?php the_title(); ?></span></h1> 
                                    <?php if( !empty($pageslogan) ) : ?>
                                        <p class="lead"><?php echo $pageslogan; ?></p>
                                    <?php endif; ?>
                                        
                                    <div class="entry-meta">
                                        <?php edit_post_link( __( 'Edit', 'unitedthemes' ), '<span class="edit-link"><i class="fa fa-pencil-square-o"></i>', '</span>' ); ?>
                                    </div>
                                                                 
                                </header><!-- .page-header -->
                            </div>
                            
                            
                            <div class="grid-100 tablet-grid-100 mobile-grid-100">
                            	<div class="ut-portfolio-media">
                                
									<?php /* standard post format */ ?>
                            
                                    <?php if( empty( $post_format ) ) :?>
                                    
                                        <!-- ut-post-thumbnail -->
                                        <div class="ut-post-thumbnail">     
                                            
                                            <?php $thumbnail = ut_resize( $fullsize , '855' , '425', true , true ); ?>
                                            <?php $caption = get_post( $fullsizeID )->post_excerpt; ?>	
                                            
                                            <div class="entry-thumbnail">		
                                                <img alt="<?php echo $caption; ?>" class="wp-post-image" src="<?php echo $fullsize; ?>">
                                            </div>
                                        
                                        </div>
                                        <!-- /end ut-post-thumbnail -->
                                    
                                    <?php endif; ?>
                                    
                                    
                                    
                                    <?php /* gallery post format */ ?>
                                    
                                    <?php if( $post_format == 'gallery' ) :?>
                                    
                                        <?php echo ut_portfolio_flex_slider( $post->ID , true ); ?>
                                    
                                    <?php endif; ?>
                                    
                                    
                                    
                                    <?php /* video post format */ ?>
                                    
                                    <?php if( $post_format == 'video' ) :?>
                                        
                                        <?php 
                                        
                                        /* get the content */
                                        $content = get_the_content();
                                            
                                        /* try to catch video url */
                                        $video_url = get_portfolio_format_video_content( $content );
                                        
                                        
                                        /* output video */
                                        echo '<div class="ut-video">' . apply_filters( 'the_content' , $video_url ) . '</div>';
                                        
                                        /* cut out the video url from content and apply default format to content */
                                        $the_content = str_replace( $video_url , "" , $content);
                                        $the_content = apply_filters( 'the_content' , $the_content );
                                            
                                        ?>
                                    
                                    <?php endif; ?>
                                    
                            	</div>
                            </div>
                            
                            <div class="grid-70 prefix-15 mobile-grid-100 tablet-grid-100">
                                <div class="entry-content clearfix">	
                                    
                                    <?php if( $post_format == 'video' ) : ?>
                            	
										<?php echo $the_content; ?>
                                        
                                    <?php else : ?>
                                                            
                                        <?php the_content(); ?>
                                   
                                   <?php endif; ?>
                                                                  
                                </div><!-- .entry-content -->
                            </div>
                            
                        </div><!-- #post -->
                                       				
					<?php if ( comments_open() || '0' != get_comments_number() )  {
                            comments_template();
                    } ?>
        
                    <?php endwhile; // end of the loop. ?>
    			
                <?php endif; ?>
                
			</div><!-- close #primary -->
	</div><!-- close grid-container -->

<?php get_footer(); ?>
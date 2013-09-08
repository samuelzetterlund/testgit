<?php

				
				<section id="post-content" class="ten columns alpha">
				
					<?php if ( ! have_posts() ) : ?>
					
					<article id="post-not-found">
						<h2 class="post-title"><?php echo __( 'Darn! Nothing to see here!', 'hanna' ); ?></h2>
						<p><?php echo __( 'Sorry, but no results were found. Please try the search again.', 'hanna' ); ?></p>
					</article>
					
					<?php endif; ?>
				
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						
					<article id="single-article" class="archive-article">
				
						<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
						
						<span class="meta-category"><?php _e('Posted in', 'hanna'); ?> - <?php the_category(' & '); ?> <?php _e('on', 'hanna'); ?> <strong><?php the_time('F jS Y'); ?></strong> 
						<span class="comment-count"><?php $commentscount = get_comments_number(); echo $commentscount; ?> <?php _e('Comments', 'hanna'); ?></span>
						<span class="tags"><i class="icon-tags"></i> <?php the_tags(' ',' '); ?></span>
						</span>
						
						<a data-lightbox="width:940;height:550" class="single-thumbnail" href="<?php $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 940,550 ), false, '' ); echo $src[0]; ?>">
							<?php the_post_thumbnail('single-post'); ?>
						</a>
						
						<?php the_excerpt(); ?>
											
					</article><!-- end #single-article -->
						
					<?php endwhile; endif;
					wp_reset_query(); ?>
					
				    <?php gt_content_nav('nav-below');?>

				</section><!-- end #post-content -->

				<?php get_sidebar(); ?>
					
			</section><!-- end #recent-news -->
			
		</div><!-- end .container -->
		
		<div class="back-to-top">
		
			<div class="row">
		
				<a href="#header-global" class="back-to-top-link scroll"><span><?php _e( 'Back to top', 'hanna' ); ?></span></a>
			
			</div><!-- end .row -->
		
		</div><!-- end .back-to-top -->
			
	</div><!-- end #main -->

<?php get_footer(); ?>
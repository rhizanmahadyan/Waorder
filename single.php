<?php get_header(); ?>

<section class="singular">

	<div class="wrapper clear">
		<?php if (have_posts()): while (have_posts()) : the_post(); ?>

			<!-- article -->
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<?php if ( has_post_thumbnail() ) : // Check if Thumbnail exists. ?>
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
						<img class="lazy" data-src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>">
					</a>
				<?php endif; ?>

				<div class="title">
                    <h1 class="text-shadow"><?php the_title(); ?></h1>
                </div>

				<div class="contentbox">
					<div class="textbox">
						<?php the_content(); ?>
					</div>
				</div>

				<?php comments_template(); ?>
				
			</article>

			<?php get_sidebar(); ?>

		<?php endwhile; endif; ?>
	</div>

</section>

<?php get_footer(); ?>

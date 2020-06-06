<?php get_header(); ?>

<section class="singular">

	<div class="wrapper clear">
		<?php while (have_posts()) : the_post(); ?>

			<!-- article -->
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<div class="title">
                    <h1><?php the_title(); ?></h1>
                </div>

				<div class="contentbox">
					<div class="textbox">
						<?php the_content(); ?>
					</div>
				</div>

			</article>

		<?php endwhile; ?>
	</div>

</section>

<?php get_footer(); ?>

<?php get_header(); ?>

	<section class="index">

		<div class="wrapper clear">

			<?php

			if( have_posts() && have_posts() ):
				?>
				<div class="labelbox">
					<div class="newest">
						<h3>&quot;<?php single_cat_title(); ?>&quot;</h3>
					</div>
				</div>
				<div class="boxcontainer clear">

					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part('template/postbox'); ?>
					<?php endwhile; ?>

				</div>
				<?php
				echo waorder_post_pagination(false);
			else:
                ?>
                <div class="boxcontainer clear">

					<?php get_template_part('template/404'); ?>

				</div>
                <?php
			endif;

			wp_reset_postdata();
			?>

		</div>
	</section>

<?php get_footer(); ?>

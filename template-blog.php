<?php /* Template Name: Blog Template */  ?>
<?php get_header(); ?>

	<section class="index">

		<div class="wrapper clear">

			<?php
			$args = array(
				'post_type'      => 'post',
				'posts_per_page' => get_option('posts_per_page'),
				'post_status'    => 'publish',
				'order'          => 'DESC',
				'orderby'        => 'date',
				'paged' => (get_query_var('paged')) ? get_query_var('paged') : 1,
			);

			$cposts = new WP_Query( $args );

			if( $cposts && null !== $cposts->have_posts() && $cposts->have_posts() ):
				?>
				<div class="labelbox">
					<div class="newest">
						<h3>ARTIKEL TERBARU</h3>
					</div>
				</div>
				<div class="boxcontainer clear">

					<?php while ( $cposts->have_posts() ) : $cposts->the_post(); ?>
						<?php get_template_part('template/postbox'); ?>
					<?php endwhile; ?>

				</div>
				<?php
				echo waorder_post_pagination($cposts);
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

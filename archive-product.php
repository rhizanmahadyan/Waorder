<?php get_header(); ?>

	<section class="index">

		<div class="wrapper clear">

			<div class="labelbox clear">
				<div class="archive">
					<?php $filter = isset($_GET['filter']) ? sanitize_text_field($_GET['filter']) : 'TERBARU'; ?>
					<h3>PRODUK <?php echo $filter; ?></h3>
					<div class="filtered">
						<?php echo waorder_product_filter_dropdown(); ?>
					</div>
				</div>
			</div>

			<?php
			if( have_posts() ):
				?>
				<div class="boxcontainer clear">

					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part('template/productbox'); ?>
					<?php endwhile; ?>

				</div>
				<?php
				waorder_product_pagination();
			else:
                ?>
                <div class="boxcontainer clear">

					<?php get_template_part('template/404'); ?>

				</div>
                <?php
			endif;
			?>

		</div>
	</section>

<?php get_footer(); ?>

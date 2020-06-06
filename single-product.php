<?php get_header(); ?>

<section class="singular">

	<div class="wrapper clear">
		<?php if (have_posts()): while (have_posts()) : the_post(); ?>

			<!-- article -->
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<div class="boxtop clear">

					<div class="left">
						<?php
						$photos = array();
						$thumbnail_id = get_post_thumbnail_id( $post->ID );

						if( $thumbnail_id ):
							$photos[] = array(
								'thumb' => wp_get_attachment_image_src($thumbnail_id),
								'full' => wp_get_attachment_image_src($thumbnail_id, 'full'),
							);
						endif;

						$photo_ids = get_post_meta($post->ID, 'waorder_gallery_ids', true);

						foreach( (array) $photo_ids as $key=> $id ):
							$photos[] = array(
								'thumb' => wp_get_attachment_image_src($id),
								'full' => wp_get_attachment_image_src($id, 'full'),
							);
						endforeach;

						?>
						<div class="photo">
							<div class="photobig">
								<img id="bigphoto" class="lazy" data-src="<?php if( isset($photos[0]['full']) ){ echo $photos[0]['full'][0];} ?>"/>
								<?php
								$ribbon = get_post_meta(get_the_ID(), 'product_ribbon', true);
								?>
								<?php if( $ribbon ): ?>
									<span class="ribbon"><small class="text color-scheme-background"><?php echo $ribbon; ?></small></span>
								<?php endif; ?>
							</div>
							<div class="photosmall clear">
								<?php foreach( (array)$photos as $photo ): ?>
									<div class="photosmallbox" onclick="photoChanger(this);" data-image-full="<?php echo $photo['full'][0]; ?>">
										<div class="img lazy" data-bg="url(<?php echo $photo['thumb'][0]; ?>)"></div>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					</div>

					<div class="right">
						<div class="contentbox">
							<?php if( get_post_meta($post->ID, 'product_out_stock', true) == 'yes' ): ?>
								<div class="outstock">
									Stok Habis
								</div>
							<?php endif; ?>
							<h1><?php the_title(); ?></h1>

							<form class="orderBox" method="post" enctype="multipart/form-data" id="productData">
								<?php
								$post_id = get_the_ID();
								$thumb                  = wp_get_attachment_image_src(get_post_thumbnail_id($post_id));
								$is_out_stock           = get_post_meta($post_id, 'product_out_stock', true);
								$price                  = get_post_meta($post_id, 'product_price', true);
								$price_slik             = get_post_meta($post_id, 'product_price_slik', true);
								$size_data              = get_post_meta($post_id, 'product_size', true);
								$color_data             = get_post_meta($post_id, 'product_color', true);

								$custom_variable_label  = get_post_meta($post_id, 'product_custom_variable_label', true);
								$custom_variable_fields = get_post_meta($post_id, 'product_custom_variable_value', true);

								$product_link_mp        = get_post_meta($post_id, 'product_link_mp', true);
			                    $weight = get_post_meta($post_id, 'product_weight', true);
			                    $weight = empty($weight) ? 1000 : intval($weight);
			                    ?>
								<input type="hidden" name="order_item_id" value="<?php echo get_the_ID(); ?>">
								<input type="hidden" name="order_key" value="<?php echo waorder_order_key_generator(); ?>"/>
								<input type="hidden" name="order_item_price" value="<?php echo $price; ?>"/>
								<input type="hidden" name="order_item_price_slik" value="<?php echo $price_slik; ?>"/>
								<input type="hidden" name="order_item_name" value="<?php echo get_the_title(get_the_ID()); ?>"/>
								<input type="hidden" name="order_item_photo" value="<?php if( isset($thumb[0]) ){ echo $thumb[0];} ?>"/>
								<input type="hidden" name="order_item_weight" value="<?php echo $weight; ?>"/>
								<div class="pricing">
									<span class="price" id="price-view">Rp <?php echo number_format($price,0,',','.'); ?></span>
									<?php if($price_slik): ?>
										<span class="price_slik"><del>Rp <?php echo number_format($price_slik,0,',','.'); ?></del></span>
									<?php endif; ?>
								</div>

								<?php if($color_data ): ?>
									<?php $colors = explode(',', $color_data); ?>
									<div class="variable">
										<p>Warna</p>
									<?php foreach( (array)$colors as $key=>$color ): ?>
										<?php if( $key == 0 ): ?>
											<input type="hidden" name="order_item_color" value="<?php echo $color; ?>"/>
										<?php endif; ?>
										<label class="variable-option">
											<input type="radio" name="order_color" value="<?php echo $color; ?>" <?php if($key == 0){ echo 'checked="checked"';} ?> onclick="productOptionColor(this);"><?php echo $color; ?>
											<span class="marked color-scheme-border"></span>
										</label>
									<?php endforeach; ?>
								    </div>
								<?php endif; ?>

								<?php if( $custom_variable_label  ): ?>
									<div class="variable">
										<p><?php echo $custom_variable_label; ?></p>
										<input type="hidden" name="order_item_custom_name" value="<?php echo $custom_variable_label; ?>"/>
										<?php if( isset($custom_variable_fields['chooser']) ): ?>
				                            <?php foreach( (array) $custom_variable_fields['chooser'] as $key=>$val ): ?>
				                                <?php
												$pricess = $custom_variable_fields['price'];
												$prices = $pricess[$key] ? $pricess[$key] : $price;
												?>
												<?php if( $key == 0 ): ?>
													<input type="hidden" name="order_item_custom_value" value="<?php echo $val; ?>"/>
												<?php endif; ?>
												<label class="variable-option">
													<input type="radio" name="order_custom" value="<?php echo $val; ?>" <?php if($key == 0){ echo 'checked="checked"';} ?> onclick="productOptionCustom(this, '<?php echo $prices; ?>');"><?php echo $val; ?>
													<span class="marked color-scheme-border"></span>
												</label>
				                            <?php endforeach; ?>
				                        <?php endif; ?>
								    </div>
								<?php endif; ?>

								<div class="variable">
									<p>Quantity</p>
									<div class="variable-qty clear">
										<button type="button" class="minus" onclick="productOptionQty(this,'minus');">-</button>
										<input min="1" type="number" value="1" name="order_item_qty">
										<button type="button" class="plus" onclick="productOptionQty(this,'plus');">+</button>
									</div>
								</div>

								<div class="variable clear">
									<button type="button" class="order-button<?php if( $is_out_stock == 'yes' ){ echo ' outofstock';}else{echo ' color-scheme-background" onclick="singleCartWA(this);';} ?>">
										<i class="icon ion-logo-whatsapp"></i>
										Beli Sekarang
									</button>
									<button type="button" class="add-to-cart-button<?php if( $is_out_stock == 'yes' ){ echo ' outofstock';}else{echo ' add-to-cart-background" onclick="addToCartWA(this);'; } ?>">
										<i class="icon ion-md-cart"></i>
										Tambah Ke Keranjang
									</button>
								</div>

								<?php
								$ada = array();
								foreach( (array) $product_link_mp as $key=>$val ):
									if( $val ):
										$ada[] = $val;
									endif;
								endforeach;
								?>
								<?php if( $ada ): ?>
									<div class="variable">
										<p style="text-align:center">Anda juga dapat belanja melalui marketplace</p>
										<div class="button-order-mp">
											<?php if( isset($product_link_mp['bukalapak']) && waorder_is_url($product_link_mp['bukalapak']) ): ?>
												<a title="Bukalapak" target="_blank" href="<?php echo $product_link_mp['bukalapak']; ?>">
													<img class="lazy" data-src="<?php echo waorder_theme_url(false); ?>/img/bukalapak.png">
												</a>
											<?php endif; ?>

											<?php if( isset($product_link_mp['tokopedia']) && waorder_is_url($product_link_mp['tokopedia']) ): ?>
												<a title="Tokopedia" target="_blank" href="<?php echo $product_link_mp['tokopedia']; ?>">
													<img class="lazy" data-src="<?php echo waorder_theme_url(); ?>/img/tokopedia.png">
												</a>
											<?php endif; ?>

											<?php if( isset($product_link_mp['shoppe']) && waorder_is_url($product_link_mp['shoppe']) ): ?>
												<a title="Shopee" target="_blank" href="<?php echo $product_link_mp['shoppe']; ?>">
													<img class="lazy" data-src="<?php echo waorder_theme_url(); ?>/img/shoppe.png">
												</a>
											<?php endif; ?>

											<?php if( isset($product_link_mp['lazada']) && waorder_is_url($product_link_mp['lazada']) ): ?>
												<a title="Lazada" target="_blank" href="<?php echo $product_link_mp['lazada']; ?>">
													<img class="lazy" data-src="<?php echo waorder_theme_url(false); ?>/img/lazada.png">
												</a>
											<?php endif; ?>
										</div>
									</div>
								<?php endif; ?>
							</form>

						</div>

						<div class="shareButton clear">
							<div class="labele">BAGIKAN :</div>
							<a class="whatsapp" target="_blank" href="https://api.whatsapp.com/send?text=<?php echo get_the_title(); ?> <?php echo get_the_permalink(); ?>">
								<svg enable-background="new 0 0 418.135 418.135" version="1.1" viewBox="0 0 418.14 418.14" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" height="25px" width="25px">
									<g fill="#7AD06D">
										<path d="m198.93 0.242c-110.43 5.258-197.57 97.224-197.24 207.78 0.102 33.672 8.231 65.454 22.571 93.536l-22.017 106.87c-1.191 5.781 4.023 10.843 9.766 9.483l104.72-24.811c26.905 13.402 57.125 21.143 89.108 21.631 112.87 1.724 206.98-87.897 210.5-200.72 3.771-120.94-96.047-219.55-217.41-213.77zm124.96 321.96c-30.669 30.669-71.446 47.559-114.82 47.559-25.396 0-49.71-5.698-72.269-16.935l-14.584-7.265-64.206 15.212 13.515-65.607-7.185-14.07c-11.711-22.935-17.649-47.736-17.649-73.713 0-43.373 16.89-84.149 47.559-114.82 30.395-30.395 71.837-47.56 114.82-47.56 43.372 1e-3 84.147 16.891 114.82 47.559 30.669 30.669 47.559 71.445 47.56 114.82-1e-3 42.986-17.166 84.428-47.561 114.82z"/>
										<path d="m309.71 252.35-40.169-11.534c-5.281-1.516-10.968-0.018-14.816 3.903l-9.823 10.008c-4.142 4.22-10.427 5.576-15.909 3.358-19.002-7.69-58.974-43.23-69.182-61.007-2.945-5.128-2.458-11.539 1.158-16.218l8.576-11.095c3.36-4.347 4.069-10.185 1.847-15.21l-16.9-38.223c-4.048-9.155-15.747-11.82-23.39-5.356-11.211 9.482-24.513 23.891-26.13 39.854-2.851 28.144 9.219 63.622 54.862 106.22 52.73 49.215 94.956 55.717 122.45 49.057 15.594-3.777 28.056-18.919 35.921-31.317 5.362-8.453 1.128-19.679-8.494-22.442z"/>
									</g>
								</svg>
							</a>
							<a class="line" target="_blank" href="https://line.me/R/msg/text/?<?php echo get_the_title(); ?> <?php echo get_the_permalink(); ?>">
								<svg enable-background="new 0 0 455.731 455.731" version="1.1" viewBox="0 0 455.73 455.73" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" height="25px" width="25px">
									<rect width="455.73" height="455.73" fill="#00C200"/>
										<path d="m393.27 219.6c0.766-4.035 1.145-7.43 1.319-10.093 0.288-4.395-0.04-10.92-0.157-12.963-4.048-70.408-77.096-126.5-166.62-126.5-92.118 0-166.79 59.397-166.79 132.67 0 67.346 63.088 122.97 144.82 131.53 4.997 0.523 8.6 5.034 8.046 10.027l-3.48 31.322c-0.79 7.11 6.562 12.283 13.005 9.173 69.054-33.326 110.35-67.611 135-97.314 4.487-5.405 19.118-25.904 22.101-31.288 6.332-11.43 10.697-23.704 12.75-36.554z" fill="#fff"/>
										<path d="m136.1 229.59v-55.882c0-4.712-3.82-8.532-8.532-8.532s-8.532 3.82-8.532 8.532v64.414c0 4.712 3.82 8.532 8.532 8.532h34.127c4.712 0 8.532-3.82 8.532-8.532s-3.82-8.532-8.532-8.532h-25.595z" fill="#00C500"/>
										<path d="m188.73 246.65h-3.73c-3.682 0-6.667-2.985-6.667-6.667v-68.144c0-3.682 2.985-6.667 6.667-6.667h3.73c3.682 0 6.667 2.985 6.667 6.667v68.144c0 3.682-2.985 6.667-6.667 6.667z" fill="#00C500"/>
										<path d="m257.68 173.71v39.351s-34.073-44.443-34.593-45.027c-1.628-1.827-4.027-2.951-6.69-2.85-4.641 0.176-8.2 4.232-8.2 8.876v64.063c0 4.712 3.82 8.532 8.532 8.532s8.532-3.82 8.532-8.532v-39.112s34.591 44.83 35.099 45.312c1.509 1.428 3.536 2.312 5.773 2.332 4.738 0.043 8.611-4.148 8.611-8.886v-64.059c0-4.712-3.82-8.532-8.532-8.532-4.712 1e-3 -8.532 3.82-8.532 8.532z" fill="#00C500"/>
										<path d="m338.73 173.71c0-4.712-3.82-8.532-8.532-8.532h-34.127c-4.712 0-8.532 3.82-8.532 8.532v64.414c0 4.712 3.82 8.532 8.532 8.532h34.127c4.712 0 8.532-3.82 8.532-8.532s-3.82-8.532-8.532-8.532h-25.595v-15.144h25.595c4.712 0 8.532-3.82 8.532-8.532s-3.82-8.532-8.532-8.532h-25.595v-15.144h25.595c4.712 2e-3 8.532-3.818 8.532-8.53z" fill="#00C500"/>
								</svg>

							</a>
							<a class="facebook" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_the_permalink(); ?>">
								<svg enable-background="new 0 0 408.788 408.788" version="1.1" viewBox="0 0 408.79 408.79" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" height="25px" width="25px">
									<path d="m353.7 0h-298.61c-30.422 0-55.085 24.662-55.085 55.085v298.62c0 30.423 24.662 55.085 55.085 55.085h147.28l0.251-146.08h-37.951c-4.932 0-8.935-3.988-8.954-8.92l-0.182-47.087c-0.019-4.959 3.996-8.989 8.955-8.989h37.882v-45.498c0-52.8 32.247-81.55 79.348-81.55h38.65c4.945 0 8.955 4.009 8.955 8.955v39.704c0 4.944-4.007 8.952-8.95 8.955l-23.719 0.011c-25.615 0-30.575 12.172-30.575 30.035v39.389h56.285c5.363 0 9.524 4.683 8.892 10.009l-5.581 47.087c-0.534 4.506-4.355 7.901-8.892 7.901h-50.453l-0.251 146.08h87.631c30.422 0 55.084-24.662 55.084-55.084v-298.62c-1e-3 -30.423-24.663-55.085-55.086-55.085z" fill="#475993"/>
								</svg>
							</a>
							<a class="twitter" target="_blank" href="https://twitter.com/intent/tweet?text=<?php echo get_the_title(); ?> <?php echo get_the_permalink(); ?>">
								<svg enable-background="new 0 0 410.155 410.155" version="1.1" viewBox="0 0 410.16 410.16" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" height="25px" width="25px">
									<path d="m403.63 74.18c-9.113 4.041-18.573 7.229-28.28 9.537 10.696-10.164 18.738-22.877 23.275-37.067 1.295-4.051-3.105-7.554-6.763-5.385-13.504 8.01-28.05 14.019-43.235 17.862-0.881 0.223-1.79 0.336-2.702 0.336-2.766 0-5.455-1.027-7.57-2.891-16.156-14.239-36.935-22.081-58.508-22.081-9.335 0-18.76 1.455-28.014 4.325-28.672 8.893-50.795 32.544-57.736 61.724-2.604 10.945-3.309 21.9-2.097 32.56 0.139 1.225-0.44 2.08-0.797 2.481-0.627 0.703-1.516 1.106-2.439 1.106-0.103 0-0.209-5e-3 -0.314-0.015-62.762-5.831-119.36-36.068-159.36-85.14-2.04-2.503-5.952-2.196-7.578 0.593-7.834 13.44-11.974 28.812-11.974 44.454 0 23.972 9.631 46.563 26.36 63.032-7.035-1.668-13.844-4.295-20.169-7.808-3.06-1.7-6.825 0.485-6.868 3.985-0.438 35.612 20.412 67.3 51.646 81.569-0.629 0.015-1.258 0.022-1.888 0.022-4.951 0-9.964-0.478-14.898-1.421-3.446-0.658-6.341 2.611-5.271 5.952 10.138 31.651 37.39 54.981 70.002 60.278-27.066 18.169-58.585 27.753-91.39 27.753l-10.227-6e-3c-3.151 0-5.816 2.054-6.619 5.106-0.791 3.006 0.666 6.177 3.353 7.74 36.966 21.513 79.131 32.883 121.96 32.883 37.485 0 72.549-7.439 104.22-22.109 29.033-13.449 54.689-32.674 76.255-57.141 20.09-22.792 35.8-49.103 46.692-78.201 10.383-27.737 15.871-57.333 15.871-85.589v-1.346c-1e-3 -4.537 2.051-8.806 5.631-11.712 13.585-11.03 25.415-24.014 35.16-38.591 2.573-3.849-1.485-8.673-5.719-6.795z" fill="#76A9EA"/>
								</svg>
							</a>
						</div>
					</div>
				</div>

				<div class="boxdetail">
					<div class="contentbox">
						<h2>Detail Produk</h2>
						<div class="textbox">
							<?php the_content(); ?>
						</div>
					</div>
				</div>

				<?php

				$categories = get_the_terms(get_the_ID(), 'product-category');

			    if( $categories ):
					$category_ids = array();
				    foreach($categories as $category) :
				        $category_ids[] = $category->term_id;
				    endforeach;

					$argss = array(
						'post_type'      => 'product',
						'posts_per_page' => 5,
						'post__not_in'   => array(get_the_ID()),
						'post_status'    => 'publish',
						'tax_query'      => array(
							'relation' => 'AND',
							array(
								'taxonomy' => 'product-category',
								'field' => 'term_id',
								'terms' => $category_ids,
							)
						)
					);

					$relateds = get_posts( $argss );

					if( $relateds ):
						?>
						<div class="labelbox">
							<div class="newest">
								<h3>PRODUK TERKAIT</h3>
							</div>
						</div>
						<div class="boxcontainer clear product-related">

							<?php foreach( $relateds as $related ): ?>
								<div class="productbox clear">
								    <a href="<?php echo get_the_permalink($related->ID); ?>" title="<?php echo get_the_title($related->ID); ?>">
								        <div class="content">
											<div class="thumb">
									            <img class="lazy" data-src="<?php echo get_the_post_thumbnail_url($related->ID, 'thumbnail'); ?>" width="100%" height="auto" alt="<?php echo get_the_title($related->ID); ?>">
									        </div>
									        <div class="title">
									            <h3><?php echo get_the_title($related->ID); ?></h3>
									        </div>
									        <div class="pricing">
									            <?php
									            $prices = get_post_meta($related->ID, 'product_price', true);
									            ?>
									            <span class="price">Rp <?php echo number_format($prices,0,',','.'); ?>;</span>
									        </div>
										</div>
								    </a>
								</div>
							<?php endforeach; ?>

						</div>
						<?php
					endif;
				endif;
				?>

			</article>

		<?php endwhile; endif; ?>
	</div>

</section>

<?php get_footer(); ?>

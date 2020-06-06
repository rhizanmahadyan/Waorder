<?php get_header(); ?>

<section class="singular">

	<div class="wrapper clear">
		<?php if (have_posts()): while (have_posts()) : the_post(); ?>

			<?php
			$is_out_stock           = get_post_meta($post->ID, 'product_out_stock', true);
			$price                  = get_post_meta($post->ID, 'product_price', true);
			$price_slik             = get_post_meta($post->ID, 'product_price_slik', true);
			$size_data              = get_post_meta($post->ID, 'product_size', true);
			$color_data             = get_post_meta($post->ID, 'product_color', true);

			$custom_variable_label  = get_post_meta($post->ID, 'product_custom_variable_label', true);
			$custom_variable_fields = get_post_meta($post->ID, 'product_custom_variable_value', true);

			$product_link_mp = get_post_meta($post->ID, 'product_link_mp', true);
			?>

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
							<?php if( $is_out_stock == 'yes' ): ?>
								<div class="outstock">
									Stok Habis
								</div>
							<?php endif; ?>
							<h1><?php the_title(); ?></h1>
							<div class="pricing">
								<span class="price" id="price_view">Rp <?php echo number_format($price,0,',','.'); ?></span>
								<?php if($price_slik): ?>
									<span class="price_slik"><del>Rp <?php echo number_format($price_slik,0,',','.'); ?></del></span>
								<?php endif; ?>
								<input type="hidden" id="productPrice" value="<?php echo $price; ?>"/>
								<input type="hidden" id="productPriceSlik" value="<?php echo $price_slik; ?>"/>
							</div>
							<?php if($size_data): ?>
								<?php $sizes = explode(',', $size_data); ?>
								<div class="product-attribute">
									<p>Ukuran</p>
								<?php foreach( (array)$sizes as $key=>$size ): ?>
									<label class="productOption">
										<input type="radio" name="product_size" value="<?php echo $size; ?>" <?php if($key == 0){ echo 'checked="checked"';} ?> onclick="productOptionSize(this);"><?php echo $size; ?>
										<span class="marked color-scheme-border"></span>
									</label>
								<?php endforeach; ?>
							    </div>
							<?php endif; ?>

							<?php if($color_data ): ?>
								<?php $colors = explode(',', $color_data); ?>
								<div class="product-attribute">
									<p>Warna</p>
								<?php foreach( (array)$colors as $key=>$color ): ?>
									<label class="productOption">
										<input type="radio" name="product_color" value="<?php echo $color; ?>" <?php if($key == 0){ echo 'checked="checked"';} ?> onclick="productOptionColor(this);"><?php echo $color; ?>
										<span class="marked color-scheme-border"></span>
									</label>
								<?php endforeach; ?>
							    </div>
							<?php endif; ?>

							<?php if( $custom_variable_label  ): ?>
								<div class="product-attribute">
									<p><?php echo $custom_variable_label; ?></p>
									<?php if( isset($custom_variable_fields['chooser']) ): ?>
			                            <?php foreach( (array) $custom_variable_fields['chooser'] as $key=>$val ): ?>
			                                <?php
											$pricess = $custom_variable_fields['price'];
											$prices = $pricess[$key] ? $pricess[$key] : $price;
											?>
											<label class="productOption">
												<input type="radio" name="product_custom" value="<?php echo $val; ?>" <?php if($key == 0){ echo 'checked="checked"';} ?> onclick="productOptionCustom(this, '<?php echo $prices; ?>');"><?php echo $val; ?>
												<span class="marked color-scheme-border"></span>
											</label>
			                            <?php endforeach; ?>
			                        <?php endif; ?>
							    </div>
							<?php endif; ?>

							<div class="product-attribute">
								<p>Quantity</p>
								<div class="productQty clear">
									<button class="minus" onclick="productOptionQty(this,'minus');">-</button>
									<input min="1" type="number" value="1" id="productQty">
									<button class="plus" onclick="productOptionQty(this,'plus');">+</button>
								</div>
							</div>

							<div class="product-attribute">
								<button class="productButtonOrder <?php if( $is_out_stock == 'yes' ){ echo 'outstock';}else{echo 'color-scheme-background';} ?>" <?php if( $is_out_stock == 'yes' ){}else{echo 'onclick="openOrderWA();"';} ?>>
									<svg width="20px" height="20px" viewBox="0 -31 512 512" xmlns="http://www.w3.org/2000/svg">
										<path fill="#ffffff" d="m164.96 300h0.023437c0.019531 0 0.039063-0.003906 0.058594-0.003906h271.96c6.6953 0 12.582-4.4414 14.422-10.879l60-210c1.293-4.5273 0.38672-9.3945-2.4453-13.152-2.8359-3.7578-7.2695-5.9688-11.977-5.9688h-366.63l-10.723-48.254c-1.5273-6.8633-7.6133-11.746-14.645-11.746h-90c-8.2852 0-15 6.7148-15 15s6.7148 15 15 15h77.969c1.8984 8.5508 51.312 230.92 54.156 243.71-15.941 6.9297-27.125 22.824-27.125 41.289 0 24.812 20.188 45 45 45h272c8.2852 0 15-6.7148 15-15s-6.7148-15-15-15h-272c-8.2695 0-15-6.7305-15-15 0-8.2578 6.707-14.977 14.961-14.996zm312.15-210-51.43 180h-248.65l-40-180z"/>
										<path fill="#ffffff" d="m150 405c0 24.812 20.188 45 45 45s45-20.188 45-45-20.188-45-45-45-45 20.188-45 45zm45-15c8.2695 0 15 6.7305 15 15s-6.7305 15-15 15-15-6.7305-15-15 6.7305-15 15-15z"/>
										<path fill="#ffffff" d="m362 405c0 24.812 20.188 45 45 45s45-20.188 45-45-20.188-45-45-45-45 20.188-45 45zm45-15c8.2695 0 15 6.7305 15 15s-6.7305 15-15 15-15-6.7305-15-15 6.7305-15 15-15z"/>
									</svg>
									Beli Sekarang
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
								<div class="product-attribute">
									<p style="text-align:center">Anda juga dapat belanja melalui marketplace</p>
									<div class="productButtonOrderMP">
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
						</div>

						<?php waorder_order_form(get_the_ID()); ?>

						<div class="shareButton clear">
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

			<div class="formWaBox open" id="orderViaWa">
				<div class="formWa">
					<div class="heading clear">
						<svg enable-background="new 0 0 512 512" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" width="30px" height="30px">
							<path d="M0,512l35.31-128C12.359,344.276,0,300.138,0,254.234C0,114.759,114.759,0,255.117,0  S512,114.759,512,254.234S395.476,512,255.117,512c-44.138,0-86.51-14.124-124.469-35.31L0,512z" fill="#EDEDED"/>
							<path d="m137.71 430.79 7.945 4.414c32.662 20.303 70.621 32.662 110.34 32.662 115.64 0 211.86-96.221 211.86-213.63s-96.221-210.1-212.74-210.1-210.98 93.572-210.98 210.1c0 40.607 11.476 80.331 32.662 113.88l5.297 7.945-20.303 74.152 75.916-19.421z" fill="#55CD6C"/>
							<path d="m187.14 135.94-16.772-0.883c-5.297 0-10.593 1.766-14.124 5.297-7.945 7.062-21.186 20.303-24.717 37.959-6.179 26.483 3.531 58.262 26.483 90.041s67.09 82.979 144.77 105.05c24.717 7.062 44.138 2.648 60.028-7.062 12.359-7.945 20.303-20.303 22.952-33.545l2.648-12.359c0.883-3.531-0.883-7.945-4.414-9.71l-55.614-25.6c-3.531-1.766-7.945-0.883-10.593 2.648l-22.069 28.248c-1.766 1.766-4.414 2.648-7.062 1.766-15.007-5.297-65.324-26.483-92.69-79.448-0.883-2.648-0.883-5.297 0.883-7.062l21.186-23.834c1.766-2.648 2.648-6.179 1.766-8.828l-25.6-57.379c-0.884-2.649-3.532-5.297-7.063-5.297" fill="#FEFEFE"/>
						</svg>
						<h3><b>Form</b> Whatsapp Order!</h3>
						<div class="close" onclick="closeOrderWA();">×</div>
					</div>
					<div class="item clear">
						<div class="thumb">
							<img src="<?php if( isset($photos[0]['thumb']) ){ echo $photos[0]['thumb'][0];} ?>"/>
						</div>
						<div class="detailbox">
							<div class="detail">
								<h3><?php the_title(); ?></h3>
								<table>
									<tr>
										<?php if( $size_data ): ?>
											<td>Ukuran :</td>
										<?php endif; ?>
										<?php if( $color_data ): ?>
											<td>Warna :</td>
										<?php endif; ?>
										<?php if( $custom_variable_label ): ?>
											<td><?php echo $custom_variable_label; ?> :</td>
										<?php endif; ?>
										<td>Quantity :</td>
										<td>Harga :</td>
									</tr>
									<tr>
										<?php if( $size_data ): ?>
											<td id="product_option_size_view"><?php echo $sizes[0]; ?></td>
										<?php endif; ?>
										<?php if( $color_data ): ?>
											<td id="product_option_color_view"><?php echo $colors[0]; ?></td>
										<?php endif; ?>
										<?php if( $custom_variable_label ): ?>
											<?php if( isset($custom_variable_fields['chooser'][0]) ): ?>
												<td id="product_option_custom_view">
													<?php echo $custom_variable_fields['chooser'][0]; ?>
												</td>
											<?php endif; ?>
										<?php endif; ?>
										<td id="product_option_qty_view">1</td>
										<td id="product_option_qty_view">1</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
					<form class="form" method="post" enctype="multipart/form-data" onsubmit="orderWA(this); return false;" action="<?php echo get_the_permalink(); ?>">
						<table>
							<tr>
								<td>
									<div class="input">
										<svg enable-background="new 0 0 53 53" version="1.1" viewBox="0 0 53 53" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" width="20px" height="20px">
											<path d="m18.613 41.552-7.907 4.313c-0.464 0.253-0.881 0.564-1.269 0.903 4.61 3.887 10.561 6.232 17.063 6.232 6.454 0 12.367-2.31 16.964-6.144-0.424-0.358-0.884-0.68-1.394-0.934l-8.467-4.233c-1.094-0.547-1.785-1.665-1.785-2.888v-3.322c0.238-0.271 0.51-0.619 0.801-1.03 1.154-1.63 2.027-3.423 2.632-5.304 1.086-0.335 1.886-1.338 1.886-2.53v-3.546c0-0.78-0.347-1.477-0.886-1.965v-5.126s1.053-7.977-9.75-7.977-9.75 7.977-9.75 7.977v5.126c-0.54 0.488-0.886 1.185-0.886 1.965v3.546c0 0.934 0.491 1.756 1.226 2.231 0.886 3.857 3.206 6.633 3.206 6.633v3.24c-1e-3 1.18-0.647 2.267-1.684 2.833z" fill="#E7ECED"/>
											<path d="m26.953 4e-3c-14.633-0.25-26.699 11.41-26.949 26.043-0.142 8.297 3.556 15.754 9.444 20.713 0.385-0.336 0.798-0.644 1.257-0.894l7.907-4.313c1.037-0.566 1.683-1.653 1.683-2.835v-3.24s-2.321-2.776-3.206-6.633c-0.734-0.475-1.226-1.296-1.226-2.231v-3.546c0-0.78 0.347-1.477 0.886-1.965v-5.126s-1.053-7.977 9.75-7.977 9.75 7.977 9.75 7.977v5.126c0.54 0.488 0.886 1.185 0.886 1.965v3.546c0 1.192-0.8 2.195-1.886 2.53-0.605 1.881-1.478 3.674-2.632 5.304-0.291 0.411-0.563 0.759-0.801 1.03v3.322c0 1.223 0.691 2.342 1.785 2.888l8.467 4.233c0.508 0.254 0.967 0.575 1.39 0.932 5.71-4.762 9.399-11.882 9.536-19.9 0.252-14.633-11.407-26.699-26.041-26.949z" fill="rgba(0,0,0,.2)"/>
										</svg>
										<input type="text" name="full_name" placeholder="Nama Lengkap" required oninvalid="this.setCustomValidity('Input Nama Lengkap Anda')" oninput="this.setCustomValidity('')">
									</div>
								</td>
								<td>
									<div class="input">
										<svg enable-background="new 0 0 27.442 27.442" version="1.1" viewBox="0 0 27.442 27.442" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" width="20px" height="20px">
											<path d="m19.494 0h-11.546c-1.105 0-1.997 0.896-1.997 1.999v23.446c0 1.102 0.892 1.997 1.997 1.997h11.546c1.103 0 1.997-0.895 1.997-1.997v-23.446c0-1.103-0.894-1.999-1.997-1.999zm-8.622 1.214h5.7c0.144 0 0.261 0.215 0.261 0.481s-0.117 0.482-0.261 0.482h-5.7c-0.145 0-0.26-0.216-0.26-0.482s0.115-0.481 0.26-0.481zm2.85 24.255c-0.703 0-1.275-0.572-1.275-1.276s0.572-1.274 1.275-1.274c0.701 0 1.273 0.57 1.273 1.274s-0.572 1.276-1.273 1.276zm6.273-4.369h-12.547v-17.727h12.547v17.727z" fill="rgba(0,0,0,.2)"/>
										</svg>
										<input type="tel" name="phone" placeholder="Nomor Hp" pattern="[0-9]{9,13}" required oninvalid="this.setCustomValidity('Nomor Hp tidak valid!')" oninput="this.setCustomValidity('')">
									</div>
								</td>
							</tr>
						</table>
						<table>
							<tr>
								<td>
									<div class="input">
										<svg enable-background="new 0 0 512 512" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" width="20px" height="20px">
											<path fill="rgba(0,0,0,.2)" d="m256 0c-102.24 0-185.43 83.182-185.43 185.43 0 126.89 165.94 313.17 173 321.04 6.636 7.391 18.222 7.378 24.846 0 7.065-7.868 173-194.15 173-321.04-2e-3 -102.24-83.183-185.43-185.43-185.43zm0 469.73c-55.847-66.338-152.04-197.22-152.04-284.3 0-83.834 68.202-152.04 152.04-152.04s152.04 68.202 152.04 152.04c-1e-3 87.088-96.174 217.94-152.04 284.3z"/>
											<path fill="rgba(0,0,0,.2)" d="m256 92.134c-51.442 0-93.292 41.851-93.292 93.293s41.851 93.293 93.292 93.293 93.291-41.851 93.291-93.293-41.85-93.293-93.291-93.293zm0 153.19c-33.03 0-59.9-26.871-59.9-59.901s26.871-59.901 59.9-59.901 59.9 26.871 59.9 59.901-26.871 59.901-59.9 59.901z"/>
										</svg>
										<input type="tel" name="district" placeholder="Kecamatan" required>
									</div>
								</td>
							</tr>
						</table>
						<!--- <table>
							<tr>
								<td>
									<div class="input">
										<svg enable-background="new 0 0 129 129" version="1.1" viewBox="0 0 129 129" xmlns="http://www.w3.org/2000/svg" width="20px" height="25px">
											<path d="m121.3 34.6c-1.6-1.6-4.2-1.6-5.8 0l-51 51.1-51.1-51.1c-1.6-1.6-4.2-1.6-5.8 0s-1.6 4.2 0 5.8l53.9 53.9c0.8 0.8 1.8 1.2 2.9 1.2 1 0 2.1-0.4 2.9-1.2l53.9-53.9c1.7-1.6 1.7-4.2 0.1-5.8z" fill="rgba(0,0,0,.2)"/>
										</svg>
										<select required name="payment_type" oninvalid="this.setCustomValidity('Pilih Metode pmbayaran!')" oninput="this.setCustomValidity('')">
											<option hidden="hidden" selected="selected" value="">Metode Pembayaran</option>
											<optgroup label="Metode Pembayaran">
												<option value="BCA">BCA</option>
												<option value="Mandiri">Mandiri</option>
												<option value="BNI">BNI</option>
												<option value="BRI">BRI</option>
											</optgroup>
										</select>
									</div>
								</td>
							</tr>
						</table>--->
						<table>
							<tr>
								<td>
									<div class="input">
										<textarea name="address" placeholder="Alamat Lengkap"></textarea>
									</div>
								</td>
							</tr>
						</table>
						<!---<table>
							<tr>
								<td>
									<div class="input">
										<svg width="20px" height="20px" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
											<path fill="rgba(0,0,0,.2)" d="m316 260c-5.5195 0-10 4.4805-10 10s4.4805 10 10 10 10-4.4805 10-10-4.4805-10-10-10z"/>
											<path fill="rgba(0,0,0,.2)" d="m102.17 369.79-100 126c-2.3867 3.0039-2.8398 7.1094-1.1719 10.562 1.668 3.457 5.168 5.6523 9.0039 5.6523h492c3.8359 0 7.3359-2.1953 9.0039-5.6523 1.6719-3.4531 1.2148-7.5586-1.1719-10.562l-100-126c-1.8945-2.3906-4.7812-3.7852-7.832-3.7852h-87.598l74.785-117.3c17.543-26.301 26.812-56.973 26.812-88.703 0-88.223-71.773-160-160-160s-160 71.777-160 160c0 31.73 9.2695 62.398 26.812 88.703l74.785 117.3h-87.598c-3.0508 0-5.9336 1.3945-7.832 3.7852zm-37.336 79.215h60.465l-34.125 43h-60.469zm145.52-63 27.414 43h-71.062l34.129-43zm91.301 0h9.5195l34.125 43h-71.059zm59.52 63 34.125 43h-278.59l34.129-43zm59.66 43-34.129-43h60.469l34.125 43zm10.465-63h-60.465l-34.129-43h60.469zm-291.79-191.31c-15.379-23.023-23.508-49.887-23.508-77.688 0-77.195 62.805-140 140-140s140 62.805 140 140c0 27.801-8.1289 54.664-23.504 77.688-0.042969 0.058594-0.078125 0.11719-0.11719 0.17578-6.5664 10.301-111.32 174.61-116.38 182.54-12.723-19.957-103.42-162.21-116.38-182.54-0.035156-0.058593-0.074219-0.11719-0.11328-0.17578zm35.789 148.31-34.125 43h-60.469l34.129-43z"/>
											<path fill="rgba(0,0,0,.2)" d="m256 260c54.898 0 100-44.457 100-100 0-55.141-44.859-100-100-100s-100 44.859-100 100c0 55.559 45.117 100 100 100zm0-180c44.113 0 80 35.887 80 80 0 44.523-36.176 80-80 80-43.836 0-80-35.477-80-80 0-44.113 35.887-80 80-80z"/>
											<path fill="rgba(0,0,0,.2)" d="m298.12 294.12c-4.7266-2.8516-10.875-1.3281-13.727 3.4023l-36.961 61.32c-2.8516 4.7305-1.3281 10.875 3.4023 13.727 4.75 2.8633 10.887 1.3086 13.727-3.4023l36.961-61.32c2.8516-4.7305 1.3281-10.875-3.4023-13.727z"/>
										</svg>
										<input type="text" name="address" placeholder="Alamat Lengkap" required oninvalid="this.setCustomValidity('Lengkapi alamat Anda!')" oninput="this.setCustomValidity('')">
									</div>
								</td>
							</tr>
						</table>
						<table>
							<tr>
								<td>
									<div class="input">
										<svg width="20px" height="20px" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
											<path fill="rgba(0,0,0,.2)" d="m316 260c-5.5195 0-10 4.4805-10 10s4.4805 10 10 10 10-4.4805 10-10-4.4805-10-10-10z"/>
											<path fill="rgba(0,0,0,.2)" d="m102.17 369.79-100 126c-2.3867 3.0039-2.8398 7.1094-1.1719 10.562 1.668 3.457 5.168 5.6523 9.0039 5.6523h492c3.8359 0 7.3359-2.1953 9.0039-5.6523 1.6719-3.4531 1.2148-7.5586-1.1719-10.562l-100-126c-1.8945-2.3906-4.7812-3.7852-7.832-3.7852h-87.598l74.785-117.3c17.543-26.301 26.812-56.973 26.812-88.703 0-88.223-71.773-160-160-160s-160 71.777-160 160c0 31.73 9.2695 62.398 26.812 88.703l74.785 117.3h-87.598c-3.0508 0-5.9336 1.3945-7.832 3.7852zm-37.336 79.215h60.465l-34.125 43h-60.469zm145.52-63 27.414 43h-71.062l34.129-43zm91.301 0h9.5195l34.125 43h-71.059zm59.52 63 34.125 43h-278.59l34.129-43zm59.66 43-34.129-43h60.469l34.125 43zm10.465-63h-60.465l-34.129-43h60.469zm-291.79-191.31c-15.379-23.023-23.508-49.887-23.508-77.688 0-77.195 62.805-140 140-140s140 62.805 140 140c0 27.801-8.1289 54.664-23.504 77.688-0.042969 0.058594-0.078125 0.11719-0.11719 0.17578-6.5664 10.301-111.32 174.61-116.38 182.54-12.723-19.957-103.42-162.21-116.38-182.54-0.035156-0.058593-0.074219-0.11719-0.11328-0.17578zm35.789 148.31-34.125 43h-60.469l34.129-43z"/>
											<path fill="rgba(0,0,0,.2)" d="m256 260c54.898 0 100-44.457 100-100 0-55.141-44.859-100-100-100s-100 44.859-100 100c0 55.559 45.117 100 100 100zm0-180c44.113 0 80 35.887 80 80 0 44.523-36.176 80-80 80-43.836 0-80-35.477-80-80 0-44.113 35.887-80 80-80z"/>
											<path fill="rgba(0,0,0,.2)" d="m298.12 294.12c-4.7266-2.8516-10.875-1.3281-13.727 3.4023l-36.961 61.32c-2.8516 4.7305-1.3281 10.875 3.4023 13.727 4.75 2.8633 10.887 1.3086 13.727-3.4023l36.961-61.32c2.8516-4.7305 1.3281-10.875-3.4023-13.727z"/>
										</svg>
										<input type="text" name="sub_district" placeholder="Kecamatan" required oninvalid="this.setCustomValidity('Lengkapi nama Kecamatan!')" oninput="this.setCustomValidity('')">
									</div>
								</td>
								<td>
									<div class="input">
										<svg width="20px" height="20px" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
											<path fill="rgba(0,0,0,.2)" d="m316 260c-5.5195 0-10 4.4805-10 10s4.4805 10 10 10 10-4.4805 10-10-4.4805-10-10-10z"/>
											<path fill="rgba(0,0,0,.2)" d="m102.17 369.79-100 126c-2.3867 3.0039-2.8398 7.1094-1.1719 10.562 1.668 3.457 5.168 5.6523 9.0039 5.6523h492c3.8359 0 7.3359-2.1953 9.0039-5.6523 1.6719-3.4531 1.2148-7.5586-1.1719-10.562l-100-126c-1.8945-2.3906-4.7812-3.7852-7.832-3.7852h-87.598l74.785-117.3c17.543-26.301 26.812-56.973 26.812-88.703 0-88.223-71.773-160-160-160s-160 71.777-160 160c0 31.73 9.2695 62.398 26.812 88.703l74.785 117.3h-87.598c-3.0508 0-5.9336 1.3945-7.832 3.7852zm-37.336 79.215h60.465l-34.125 43h-60.469zm145.52-63 27.414 43h-71.062l34.129-43zm91.301 0h9.5195l34.125 43h-71.059zm59.52 63 34.125 43h-278.59l34.129-43zm59.66 43-34.129-43h60.469l34.125 43zm10.465-63h-60.465l-34.129-43h60.469zm-291.79-191.31c-15.379-23.023-23.508-49.887-23.508-77.688 0-77.195 62.805-140 140-140s140 62.805 140 140c0 27.801-8.1289 54.664-23.504 77.688-0.042969 0.058594-0.078125 0.11719-0.11719 0.17578-6.5664 10.301-111.32 174.61-116.38 182.54-12.723-19.957-103.42-162.21-116.38-182.54-0.035156-0.058593-0.074219-0.11719-0.11328-0.17578zm35.789 148.31-34.125 43h-60.469l34.129-43z"/>
											<path fill="rgba(0,0,0,.2)" d="m256 260c54.898 0 100-44.457 100-100 0-55.141-44.859-100-100-100s-100 44.859-100 100c0 55.559 45.117 100 100 100zm0-180c44.113 0 80 35.887 80 80 0 44.523-36.176 80-80 80-43.836 0-80-35.477-80-80 0-44.113 35.887-80 80-80z"/>
											<path fill="rgba(0,0,0,.2)" d="m298.12 294.12c-4.7266-2.8516-10.875-1.3281-13.727 3.4023l-36.961 61.32c-2.8516 4.7305-1.3281 10.875 3.4023 13.727 4.75 2.8633 10.887 1.3086 13.727-3.4023l36.961-61.32c2.8516-4.7305 1.3281-10.875-3.4023-13.727z"/>
										</svg>
										<input type="text" name="district" placeholder="Kabupaten" required oninvalid="this.setCustomValidity('Lengkapi nama Kabupaten!')" oninput="this.setCustomValidity('')">
									</div>
								</td>
							</tr>
						</table>--->
						<div class="subtotal">
							<table>
								<tr>
									<td>
										Sub Total<br>
										<span style="font-weight: 400;font-style:italic;font-size:10px;">*Belum termasuk Ongkos kirim</span>
									</td>
									<td>
										<span id="product_sub_total_view" style="font-size:18px;color: #FF5050;font-weight: bold">Rp <?php echo number_format($price,0,',','.'); ?></span>&nbsp;<?php if($price_slik){?><span id="product_sub_total_slik_view" ><del>Rp <?php echo number_format($price_slik,0,',','.'); ?></del></span><?php } ?>
									</td>
								<tr>
							</table>
						</div>
						<div class="subtotal">
							<table>
								<tr>
									<td>
										Ongkir
									</td>
									<td>
										<span id="product_sub_total_view" style="font-size:18px;color: #FF5050;font-weight: bold">Rp <?php echo number_format($price,0,',','.'); ?></span>&nbsp;<?php if($price_slik){?><span id="product_sub_total_slik_view" ><del>Rp <?php echo number_format($price_slik,0,',','.'); ?></del></span><?php } ?>
									</td>
								<tr>
							</table>
						</div>
						<table>
							<tr>
								<td>
									<button id="sendWA" class="color-scheme-background" type="submit">
										<svg enable-background="new 0 0 535.5 535.5" version="1.1" viewBox="0 0 535.5 535.5" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" width="20px" height="20px">
											<polygon points="0 497.25 535.5 267.75 0 38.25 0 216.75 382.5 267.75 0 318.75" fill="#ffffff"/>
										</svg>
										Kirim
									</button>
								</td>
							</tr>
						</table>
						<input type="hidden" name="product" value="<?php the_title(); ?>">
						<input type="hidden" name="product_qty" id="product_option_qty" value="1">
						<?php if( $size_data ): ?>
							<input type="hidden" name="product_size" id="product_option_size" value="<?php echo $sizes[0]; ?>">
						<?php endif; ?>
						<?php if( $color_data ): ?>
							<input type="hidden" name="product_color" id="product_option_color" value="<?php echo $colors[0]; ?>">
						<?php endif; ?>
						<?php if( $custom_variable_label ): ?>
							<?php if( isset($custom_variable_fields['chooser'][0]) ): ?>
								<input type="hidden" name="product_custom" id="product_option_custom" value="<?php echo $custom_variable_fields['chooser'][0]; ?>">
								<input type="hidden" name="product_custom_label" id="product_option_custom" value="<?php echo $custom_variable_label; ?>">
							<?php endif; ?>
						<?php endif; ?>
						<input type="hidden" name="product_subtotal" id="product_sub_total" value="Rp <?php echo number_format($price,0,',','.'); ?>">
						<input type="hidden" name="destination" value="<?php echo waorder_admin_phone(); ?>">
						<input type="hidden" name="gretings" value="<?php echo get_theme_mod('waorder_greeting_message','Haloo Admin'); ?>">
						<input type="hidden" name="nonce" value="<?php echo wp_create_nonce('waordernonce'); ?>"/>
						<input type="hidden" name="order_key" value="<?php echo waorder_order_key_generator(); ?>"/>
					</form>
				</div>
			</div>

		<?php endwhile; endif; ?>
	</div>

</section>

<?php get_footer(); ?>

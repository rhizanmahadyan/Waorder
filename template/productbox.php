<article class="productbox">
    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
        <div class="content">
            <div class="thumb">
                <img class="lazy" data-src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>" alt="<?php echo get_the_title(); ?>">
                <?php
                $ribbon = get_post_meta(get_the_ID(), 'product_ribbon', true);
                ?>
                <?php if( $ribbon ): ?>
                    <span class="ribbon"><small class="text color-scheme-background"><?php echo $ribbon; ?></small></span>
                <?php endif; ?>
            </div>
            <div class="title">
                <h3><?php echo get_the_title(); ?></h3>
            </div>
            <div class="pricing">
                <?php
                $price = get_post_meta(get_the_ID(), 'product_price', true);
                $price_slik = (int) get_post_meta(get_the_ID(), 'product_price_slik', true);
                ?>
                <?php if( $price_slik ): ?><span class="price_slik"><del>Rp <?php echo number_format($price_slik,0,',','.'); ?></del></span><?php endif; ?>
                <span class="price">Rp <?php echo number_format($price,0,',','.'); ?></span>
            </div>
        </div>
    </a>
</article>

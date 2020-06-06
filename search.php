<?php
global $wp;
if( isset($wp->query_vars['post_type']) && $wp->query_vars['post_type'] == 'product' ):
	get_template_part('template/search-product');
else:
	get_template_part('template/search-post');
endif;
?>

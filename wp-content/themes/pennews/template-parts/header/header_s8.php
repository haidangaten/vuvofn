<div class="header__top header--s2 header--s8">
	<div class="<?php echo penci_get_class_header_width(); ?> header-top__container">
		<?php get_template_part( 'template-parts/header/logo' ); ?>
		<?php get_template_part( 'template-parts/header/banner' ); ?>
	</div>
</div>
<header id="masthead" class="site-header header--s2 header--s8" data-height="<?php echo penci_get_data_height_nav(); ?>" <?php penci_get_schema_header(); ?>>
	<div class="<?php echo penci_get_class_header_width(); ?> header-content__container">
		<?php get_template_part( 'template-parts/header/menu' ); ?>
		<?php get_template_part( 'template-parts/header/cart_search_social' ); ?>
	</div>
</header><!-- #masthead -->
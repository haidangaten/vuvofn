<div class="header__top header--s3 customizer-width">
	<div class="<?php echo penci_get_class_header_width(); ?>">
		<?php get_template_part( 'template-parts/header/logo' ); ?>
	</div>
</div>
<header id="masthead" class="site-header site-header__main header--s3" data-height="<?php echo penci_get_data_height_nav(); ?>" <?php penci_get_schema_header(); ?>>
	<div class="<?php echo penci_get_class_header_width(); ?> header-content__container">
		<?php get_template_part( 'template-parts/header/menu' ); ?>
		<?php get_template_part( 'template-parts/header/cart_search_social' ); ?>
	</div>
</header><!-- #masthead -->

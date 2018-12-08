<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php
echo do_shortcode( '[penci_custom_slider slider_id="' . get_the_ID() . '"]' );
?>
<style type="text/css">
html {
    margin-top: 0 !important;
}
#wpadminbar {
	display: none !important;
}
		</style>
<?php wp_footer(); ?>

</body>
</html>


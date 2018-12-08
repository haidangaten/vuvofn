<?php
$show_signin = penci_get_setting( 'penci_topbar_show_signin' );
if ( empty( $show_signin ) ) {
	return;
}

echo '<div class="topbar_item topbar__menu topbar__logout_login">';
if ( is_user_logged_in() ) {
	$current_user = wp_get_current_user();

	printf(
		'<ul class="topbar__logout">
			<li class="menu-item">%s<a href="%s">%s</a></li>
			<li class="menu-item"><a href="%s"><i class="fa fa-sign-out"></i> %s</a></li>
		</ul>',
		get_avatar( $current_user->ID, 20 ),
		get_author_posts_url( $current_user->ID ),
		$current_user->display_name,
		wp_logout_url(home_url( '/' )),
		penci_get_tran_setting( 'penci_topbar_logout' )
	);
}else {
	printf(
		'<ul class="topbar__login">
			<li class="menu-item login login-popup"><a href="%s"><i class="fa fa-sign-in"></i> %s</a></li>
		</ul>',
		esc_url( '#login-form' ),
		penci_get_tran_setting( 'penci_topbar_signin' )
	);
}

echo '</div>';

echo penci_login_register_popup();
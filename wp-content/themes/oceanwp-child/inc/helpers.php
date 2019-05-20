<?php
if ( ! function_exists( 'oceanwp_social_options' ) ) {

	function oceanwp_social_options() {
		return apply_filters( 'ocean_social_options', array(
			'twitter' => array(
				'label' => esc_html__( 'Twitter', 'oceanwp' ),
				'icon_class' => 'fa fa-twitter-square',
			),
			'facebook' => array(
				'label' => esc_html__( 'Facebook', 'oceanwp' ),
				'icon_class' => 'fa fa-facebook-square',
			),
			'googleplus' => array(
				'label' => esc_html__( 'Google Plus', 'oceanwp' ),
				'icon_class' => 'fa fa-google-plus',
			),
			'pinterest'  => array(
				'label' => esc_html__( 'Pinterest', 'oceanwp' ),
				'icon_class' => 'fa fa-pinterest-p',
			),
			'dribbble' => array(
				'label' => esc_html__( 'Dribbble', 'oceanwp' ),
				'icon_class' => 'fa fa-dribbble',
			),
			'vk' => array(
				'label' => esc_html__( 'VK', 'oceanwp' ),
				'icon_class' => 'fa fa-vk',
			),
			'instagram'  => array(
				'label' => esc_html__( 'Instagram', 'oceanwp' ),
				'icon_class' => 'fa fa-instagram',
			),
			'linkedin' => array(
				'label' => esc_html__( 'LinkedIn', 'oceanwp' ),
				'icon_class' => 'fa fa-linkedin-square',
			),
			'tumblr'  => array(
				'label' => esc_html__( 'Tumblr', 'oceanwp' ),
				'icon_class' => 'fa fa-tumblr',
			),
			'github'  => array(
				'label' => esc_html__( 'Github', 'oceanwp' ),
				'icon_class' => 'fa fa-github-alt',
			),
			'flickr'  => array(
				'label' => esc_html__( 'Flickr', 'oceanwp' ),
				'icon_class' => 'fa fa-flickr',
			),
			'skype' => array(
				'label' => esc_html__( 'Skype', 'oceanwp' ),
				'icon_class' => 'fa fa-skype',
			),
			'youtube' => array(
				'label' => esc_html__( 'Youtube', 'oceanwp' ),
				'icon_class' => 'fa fa-youtube-square',
			),
			'vimeo' => array(
				'label' => esc_html__( 'Vimeo', 'oceanwp' ),
				'icon_class' => 'fa fa-vimeo-square',
			),
			'vine' => array(
				'label' => esc_html__( 'Vine', 'oceanwp' ),
				'icon_class' => 'fa fa-vine',
			),
			'xing' => array(
				'label' => esc_html__( 'Xing', 'oceanwp' ),
				'icon_class' => 'fa fa-xing',
			),
			'yelp' => array(
				'label' => esc_html__( 'Yelp', 'oceanwp' ),
				'icon_class' => 'fa fa-yelp',
			),
			'tripadvisor' => array(
				'label' => esc_html__( 'Tripadvisor', 'oceanwp' ),
				'icon_class' => 'fa fa-tripadvisor',
			),
			'rss'  => array(
				'label' => esc_html__( 'RSS', 'oceanwp' ),
				'icon_class' => 'fa fa-rss',
			),
			'email' => array(
				'label' => esc_html__( 'Email', 'oceanwp' ),
				'icon_class' => 'fa fa-envelope',
			),
		) );
	}
}
/**
 * Returns sidr menu source
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'oceanwp_sidr_menu_source' ) ) {
	
	function oceanwp_sidr_menu_source() {

		// Return if is not sidebar mobile style
		if ( 'sidebar' != oceanwp_mobile_menu_style() ) {
			return;
		}

		// Define array of items
		$items = array();

		// Add close button
		if ( get_theme_mod( 'ocean_mobile_menu_close_btn', true ) ) {
			$items['sidrclose'] = '#sidr-close';
		}

		// If has mobile menu
		if ( has_nav_menu( 'mobile_menu' ) ) {
			$items['mobile-nav'] = '#mobile-nav';
		}

		// Add main navigation
		else {

			// Navigation
			$items['nav'] = '#dmnavigation';

			// Add top bar menu
			if ( has_nav_menu( 'topbar_menu' ) ) {
				$items['top-nav'] = '#top-bar-nav';
			}

		}

		if ( 'full_screen' != oceanwp_header_style() ) {

			// Add social menu
			if ( true == get_theme_mod( 'ocean_menu_social', false )
				&& get_theme_mod( 'ocean_menu_social_profiles' ) ) {
				$items['social'] = '#site-header .oceanwp-social-menu';
			}

		}

		// Add search form
		if ( get_theme_mod( 'ocean_mobile_menu_search', true ) ) {
			$items['search'] = '#mobile-menu-search';
		}

		// Apply filters for child theming
		$items = apply_filters( 'ocean_mobile_menu_source', $items );

		// Turn items into comma seperated list
		$items = implode( ', ', $items );

		// Return
		return $items;

	}

}

?>
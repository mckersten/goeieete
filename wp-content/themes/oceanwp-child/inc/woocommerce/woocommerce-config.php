<?php
function menu_cart_icon($items, $args)
{

        // Return items if is in the Elementor edit mode, to avoid error
    if (OCEANWP_ELEMENTOR_ACTIVE && \Elementor\Plugin::$instance->editor->is_edit_mode()) {
        return $items;
    }

        // Only used for the main menu
    if ('main_menu' != $args->theme_location) {
        return $items;
    }

        // Get style
        $style = oceanwp_menu_cart_style();
        $header_style = oceanwp_header_style();

        // Return items if no style
    if (!$style) {
        return $items;
    }

        // Add cart link to menu items
    if ('full_screen' == $header_style) {
        $items .= '<li class="woo-cart-link"><a href="' . esc_url(wc_get_cart_url()) . '">' . esc_html__('Your cart', 'oceanwp') . '</a></li>';
    } else {
        $items .= get_cart_icon();
    }

        // Return menu items
        return $items;
}

        /**
         * Add cart icon
         *
         * @since 1.5.0
         */
function get_cart_icon()
{

    // Style
    $style = oceanwp_menu_cart_style();
    $header_style = oceanwp_header_style();
    $cart_style = get_theme_mod('ocean_woo_cart_dropdown_style', 'compact');

    // Toggle class
    $toggle_class = 'toggle-cart-widget';

    // Define classes to add to li element
    $classes = array('woo-menu-icon');

    // Add style class
    $classes[] = 'wcmenucart-toggle-' . $style;

    // If bag style
    if ('yes' == get_theme_mod('ocean_woo_menu_bag_style', 'no')) {
        $classes[] = 'bag-style';
    }

    // Cart style
    if ('compact' != $cart_style) {
        $classes[] = $cart_style;
    }

    // Prevent clicking on cart and checkout
    if ('custom_link' != $style && ( is_cart() || is_checkout() )) {
        $classes[] = 'nav-no-click';
    }

    // Add toggle class
    else {
        $classes[] = $toggle_class;
    }

    // Turn classes into string
    $classes = implode(' ', $classes);

    ob_start();
    ?>

            <li class="<?php echo esc_attr($classes); ?>">
        <?php // /oceanwp_wcmenucart_menu_item(); ?>
        <?php
        if ('drop_down' == $style && 'full_screen' != $header_style && 'vertical' != $header_style) {
            ?>
                    <div class="current-shop-items-dropdown owp-mini-cart clr">
                        <div class="current-shop-items-inner clr">
                <?php the_widget('WC_Widget_Cart', 'title='); ?>
                        </div>
                    </div>
        <?php } ?>
            </li>
            
            
            <?php if (is_user_logged_in()) {?>
            <li class="Inloggen">
            <a href="<?php echo site_url('my-account'); ?>" >Mijn Account</a>
            </li>
            <li class="Registreren"><button type="button" onclick="location.href='<?php echo wp_logout_url(home_url()); ?>';">Uitloggen</button></li>
            <?php } else {?>
            <li class="Inloggen">
            
            <a href="<?php echo site_url('inloggen');?>">Inloggen</a>
            </li>
            <li class="Registreren"><button type="button" onclick="location.href='<?php echo get_site_url(); ?>/registreren/';">Account aanmaken</button></li>
            <?php } ?>
            
            <?php
            return ob_get_clean();
}
 add_filter('wp_nav_menu_items', 'menu_cart_icon', 11, 2);

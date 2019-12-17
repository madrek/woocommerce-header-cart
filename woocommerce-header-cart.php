/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
    <?php
        if (function_exists('sage_woocommerce_header_cart')) {
            sage_woocommerce_header_cart();
        }
    ?>
*/

add_filter('woocommerce_add_to_cart_fragments', function ($fragments) {
    ob_start();
    sage_woocommerce_cart_link();
    $fragments['a.cart-contents'] = ob_get_clean();
    return $fragments;
});

/**
 * Cart Link.
 *
 * Displayed a link to the cart including the number of items present and the cart total.
 */
function sage_woocommerce_cart_link()
{
    ?>
    <a class="cart-contents nav-link" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e('View your shopping cart', 'sage'); ?>">
        <?php
        $count = WC()->cart->get_cart_contents_count();
        if ($count != 0) {
            $item_count_text = sprintf(
                /* translators: number of items in the mini cart. */
                _n('%d item', '%d items', WC()->cart->get_cart_contents_count(), 'sage'),
                WC()->cart->get_cart_contents_count()
            );
            ?>
            <span class="amount"><?php echo wp_kses_data(WC()->cart->get_cart_subtotal()); ?></span> <span class="count"><?php echo esc_html($item_count_text); ?></span>
        <?php } ?>
        <?php the_theme_svg('cart'); ?>
    </a>
    <?php
}

/**
 * Display Header Cart.
 */
function sage_woocommerce_header_cart()
{
    if (is_cart()) {
        $class = 'current-menu-item';
    } else {
        $class = '';
    }
    ?>
    <ul class="site-header-cart navbar-nav">
        <li class="menu-item <?php echo esc_attr($class); ?>">
            <?php sage_woocommerce_cart_link(); ?>
        </li>
        <li>
            <?php
            $instance = array(
                'title' => '',
            );

            the_widget('WC_Widget_Cart', $instance);
            ?>
        </li>
    </ul>
    <?php
}

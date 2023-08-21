<?php
/*
Plugin Name: Order Item Notes For WooCommerce
Plugin URI: https://github.com/petermorlion/orderitem-notes-for-woocommerce
Description: A WooCommerce plugin to add notes or comments to individual order items of an order.
Version: 1.1.0
Author: Peter Morlion
Author URI: https://redstar.be
Text Domain: order-item-notes-for-woocommerce
*/

//uncomment following two lines to see php errors
/*
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
*/

defined('ABSPATH') || exit;

/**
 * Activation and deactivation hooks for WordPress
 */
function redstar_woocommerceorderitemnotes_activate()
{
    // Your activation logic goes here.
}
register_activation_hook(__FILE__, 'redstar_woocommerceorderitemnotes_activate');

function redstar_woocommerceorderitemnotes_deactivate()
{
    // Your deactivation logic goes here.

    // Don't forget to:
    // Remove Scheduled Actions
    // Remove Notes in the Admin Inbox
    // Remove Admin Tasks
}
register_deactivation_hook(__FILE__, 'redstar_woocommerceorderitemnotes_deactivate');

if (!class_exists('WooCommerceOrderItemNotes')) {
    class WooCommerceOrderItemNotes
    {
        function __construct()
        {
            add_action('init', array(&$this, 'redstar_woocommerceorderitemnotes_init'));
            add_action('woocommerce_after_order_itemmeta', array(&$this, 'redstar_woocommerceorderitemnotes_after_order_itemmeta'), 1000, 2);
            add_filter('woocommerce_hidden_order_itemmeta', array(&$this, 'redstar_woocommerceorderitemnotes_hidden_order_itemmeta'));
            add_filter('wp_insert_post_data', array(&$this, 'redstar_woocommerceorderitemnotes_insert_post_data'), 10, 2);
            add_action('pre_post_update', array(&$this, 'redstar_woocommerceorderitemnotes_pre_post_update'), 10, 2);
            add_action( 'before_woocommerce_init', array(&$this, 'redstar_woocommerceorderitemnotes_declare_hpos_compatibility'), 10, 0);
        }

        function redstar_woocommerceorderitemnotes_declare_hpos_compatibility() {
            if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
                \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, false );
            }
        }

        function redstar_woocommerceorderitemnotes_init()
        {
            load_plugin_textdomain('order-item-notes-for-woocommerce', false, dirname(plugin_basename(__FILE__)) . '/languages');
        }

        function redstar_woocommerceorderitemnotes_after_order_itemmeta($item_id, $item)
        {
            $notes = $item->get_meta('_order_item_note');
?>
            <h4>
                <?php
                esc_html_e('Notes', 'order-item-notes-for-woocommerce');
                ?>
            </h4>
            <textarea name="order_item_note_<?php echo esc_attr($item_id); ?>" spellcheck="true" autocomplete="off"><?php echo esc_textarea($notes);?></textarea>
<?php
        }

        function redstar_woocommerceorderitemnotes_hidden_order_itemmeta($hidden_itemmeta)
        {
            array_push($hidden_itemmeta, '_order_item_note');
            return $hidden_itemmeta;
        }

        function redstar_woocommerceorderitemnotes_insert_post_data($data, $postarr) {
            wc_get_logger()->info("insert", array('source' => 'order_item_notes_for_woocommerce'));
            foreach ($postarr as $post_field => $post_value) {
                if (!str_starts_with($post_field, 'order_item_note_')) {
                    continue;
                }

                $order_item_id = intval(substr($post_field, 16));
                $order_item = new WC_Order_Item_Product($order_item_id);
                $order_item->update_meta_data('_order_item_note', $post_value);
                $order_item->save();
            }

            return $data;
        }

        function redstar_woocommerceorderitemnotes_pre_post_update($post_id, $data)
        {
            wc_get_logger()->info("update", array('source' => 'order_item_notes_for_woocommerce'));
            foreach ($data as $post_field => $post_value) {
                if (!str_starts_with($post_field, 'order_item_note_')) {
                    continue;
                }

                $order_item_id = intval(substr($post_field, 16));
                $order_item = new WC_Order_Item_Product($order_item_id);
                $order_item->update_meta_data('_order_item_note', $post_value);
                $order_item->save();

                unset($data[$post_field]);
            }
        }
    }
}

new WooCommerceOrderItemNotes();

?>

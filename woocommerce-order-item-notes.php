<?php
/*
Plugin Name: WooCommerce Order Item Notes
Plugin URI: https://redstar.be
Description: A WooCommerce plugin to add notes or comments to individual order items of an order.
Version: 2.0
Author: Peter Morlion
Author URI: https://redstar.be
Text Domain: woocommerce-order-item-notes
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
		function __construct() {
			add_action('init', array(&$this, 'redstar_woocommerceorderitemnotes_init'));
			add_action('woocommerce_after_order_itemmeta', array(&$this, 'redstar_woocommerceorderitemnotes_admin_order_item_line_item_html'), 1000, 2);
		}

        function redstar_woocommerceorderitemnotes_init() {
            load_plugin_textdomain('woocommerce-order-item-notes', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
        }
    
        function redstar_woocommerceorderitemnotes_admin_order_item_line_item_html($item_id, $item) {
            $notes = $item->get_meta('_order_item_note');
            
            echo '<h4>' . __('Notes', 'woocommerce-order-item-notes') . '</h4>';            
            echo '<textarea name="order_item_note_' . $item_id . '" spellcheck="true" autocomplete="off">';
            echo $notes;
            echo '</textarea>';
        }
    }
}

new WooCommerceOrderItemNotes();

?>

<?php

/*
 * Plugin Name:       Bookshelf
 * Description:       bookshelf the basics with this plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Avtandil Kakachishvili
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       my-basics-plugin
 */

ob_start(); // Start output buffering

defined('ABSPATH') || exit;


/* --plugin directory url --*/
function include_plugin_files()
{
    include_once('book-post-type.php');
    include_once('front-page/show-books.php');
    include_once('wishlist/wishlist-ajax.php');
    include_once('wishlist/wishlist-shortcode.php');
}
include_plugin_files();


 /* -- style and javascript --*/
function my_plugin_enqueue_book_script()
{
    // bootstrap
    wp_enqueue_script('bootstrap-script', plugins_url('js/bootstrap.min.js', __FILE__), array(), '1.0.0', true);
    wp_enqueue_style('bootstrap-style', plugins_url('style/bootstrap.min.css', __FILE__),  array(), 'all');

    // my style
    wp_enqueue_style('custom-style', plugins_url('style/custom-style.css', __FILE__),  array(), 'all');


    // wishlist
    wp_enqueue_script('wishlist-script', plugins_url('js/wishlist.js', __FILE__), array('jquery'), '1.0', true);
    wp_localize_script('wishlist-script', 'wishlistAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('wishlist-nonce')
    ));

}
add_action('wp_enqueue_scripts', 'my_plugin_enqueue_book_script');


ob_end_clean();



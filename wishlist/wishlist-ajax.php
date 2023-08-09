<?php
function handle_ajax_add_to_wishlist() {
    // Check the AJAX nonce for security
    if (!check_ajax_referer('wishlist-nonce', 'nonce', false)) {
        wp_send_json_error('Invalid nonce.');
    }

    // Check if the user is logged in
    if (is_user_logged_in()) {
        $user_id = get_current_user_id();
        $item_id = intval($_POST['item_id']);

        // Check if the item is already in the user's wishlist
        $wishlist_query = new WP_Query(array(
            'post_type' => 'wishlist_item',
            'post_status' => 'publish',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'item_id',
                    'value' => $item_id,
                ),
                array(
                    'key' => 'user_id',
                    'value' => $user_id,
                ),
            ),
        ));

        if ($wishlist_query->have_posts()) {
            // Item is already in the wishlist, return an error response
            wp_send_json_error('Item is already in your wishlist.');
        }

        // If not, proceed to add the item to the wishlist
        $item_title = get_the_title($item_id);
        $item_image = wp_get_attachment_image_src(get_post_thumbnail_id($item_id), 'full');
        $item_content = get_post_field('post_content', $item_id);
        $item_permalink = get_permalink($item_id);

        // Add item to the wishlist custom post type
        $post_id = wp_insert_post(array(
            'post_type' => 'wishlist_item',
            'image' => $item_image,
            'post_title' => $item_title,
            'post_content' => $item_content,
            'item_permalink' => $item_permalink,
            'post_status' => 'publish',
        ));

        if ($post_id) {
            // Store additional meta data like user ID or item details
            update_post_meta($post_id, 'item_id', $item_id);
            update_post_meta($post_id, 'user_id', $user_id);
            update_post_meta($post_id, 'item_image', $item_image[0]);


            // Create the wishlist page if it doesn't exist
            $wishlist_page = get_page_by_title('Wishlist');
            if (!$wishlist_page) {
                $wishlist_page = array(
                    'post_title' => 'Wishlist',
                    'post_content' => '[display_wishlist_items]',
                    'post_status' => 'publish',
                    'post_type' => 'page',
                );

                $wishlist_page_id = wp_insert_post($wishlist_page);

                // Optionally, you can set this new page as the WordPress reading page
                update_option('show_on_front', 'page');
            }

            // Return a success response
            wp_send_json_success(array('message' => 'Item added to wishlist successfully.'));
        } else {
            // Return an error response
            wp_send_json_error('Failed to add item to wishlist.');
        }
    } else {
        // Return an error response for non-logged-in users
        wp_send_json_error('You must be logged in to add items to your wishlist.');
    }
}
add_action('wp_ajax_add_to_wishlist', 'handle_ajax_add_to_wishlist');
add_action('wp_ajax_nopriv_add_to_wishlist', 'handle_ajax_add_to_wishlist');


// remove card in wishlist page
function handle_ajax_remove_from_wishlist()
{
    // Check the AJAX nonce for security
    if (!check_ajax_referer('wishlist-nonce', 'nonce', false)) {
        wp_send_json_error('Invalid nonce.');
    }

    // Check if the user is logged in
    if (is_user_logged_in()) {
        $user_id = get_current_user_id();
        $item_id = intval($_POST['item_id']);

        // Delete the wishlist item post
        $deleted = wp_delete_post($item_id, true);

        if ($deleted) {
            wp_send_json_success(array('message' => 'Item removed from wishlist successfully.'));
        } else {
            wp_send_json_error('Failed to remove item from wishlist.');
        }
    } else {
        wp_send_json_error('You must be logged in to remove items from your wishlist.');
    }
}

add_action('wp_ajax_remove_from_wishlist', 'handle_ajax_remove_from_wishlist');
add_action('wp_ajax_nopriv_remove_from_wishlist', 'handle_ajax_remove_from_wishlist'); // For non-logged-in users






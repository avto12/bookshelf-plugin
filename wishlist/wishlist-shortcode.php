<?php


if (!is_admin()) {
//add to button shortcode
function add_to_wishlist_button_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'id' => get_the_ID(),
    ), $atts);

    ob_start();
    ?>
    <form method="post">
        <input type="hidden" name="wishlist_item_id" value="<?php echo esc_attr($atts['id']); ?>">
        <span name="add_to_wishlist" class="add-to-wishlist" data-item-id="<?php echo esc_attr($atts['id']); ?>">
            <?php
            if (is_user_logged_in()) {
                $user_id = get_current_user_id();
                $item_id = intval($atts['id']);

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
                    // Item is already in the wishlist, display check icon
                    ?>
                    <span class="check_icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                              <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                            </svg>
                        </span>
                    <?php
                } else {
                    // Item is not in the wishlist, display heart icon
                    ?>
                    <span data-toggle="tooltip" data-placement="top" title="<?= esc_html__('Add Wishlist'); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip"
                                 data-bs-title="This top tooltip is themed via CSS variables.">
                                <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
                            </svg>
                        </span>
                    <?php
                }
            }
            ?>
        </span>
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode('add_to_wishlist_button', 'add_to_wishlist_button_shortcode');



//card shortcode
function display_wishlist_items_shortcode()
{
    include "wishlist-card.php";
}
add_shortcode('display_wishlist_items', 'display_wishlist_items_shortcode');



//count shortcode
function wishlist_count()
{
    function count_wishlist_items($user_id) {
    $wishlist_items = get_posts(array(
        'post_type' => 'wishlist_item',
        'meta_key' => 'user_id',
        'meta_value' => $user_id,
    ));

    return count($wishlist_items);
}
?>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-chat-right-heart-fill" viewBox="0 0 16 16">
                <path d="M16 2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h9.586a1 1 0 0 1 .707.293l2.853 2.853a.5.5 0 0 0 .854-.353V2ZM8 3.993c1.664-1.711 5.825 1.283 0 5.132-5.825-3.85-1.664-6.843 0-5.132Z"/>
            </svg>
            <span id="wishlist-count"><?php echo count_wishlist_items(get_current_user_id()); ?></span>
        </div>
<?php }
add_shortcode('count_wishlist', 'wishlist_count');
?>

<?php
}

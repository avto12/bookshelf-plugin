<?php


    $user_id = get_current_user_id();

    // Get wishlist items for the current user
    $wishlist_items = get_posts(array(
        'post_type' => 'wishlist_item',
        'meta_key' => 'user_id',
        'meta_value' => $user_id,
    ));


?>

    <section class="bookshelf-posts">
        <div class="row row-cols-1 row-cols-lg-3  row-cols-md-2 row-cols-sm-2 g-4">
            <?php if (isset($wishlist_items) && $wishlist_items) : ?>
                <?php foreach ($wishlist_items as $wishlist_item): ?>

                    <div class="col">
                        <div class="card h-100 rounded-4 border-0 box-information">
                            <span class="remove-from-wishlist" data-item-id="<?= $wishlist_item->ID ?>" data-toggle="tooltip" data-placement="top" title="<?= esc_html__('Remove Wishlist'); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                    <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                                </svg>
                            </span>
                            <img src="<?= esc_url($wishlist_item->item_image); ?>" alt="" class="card-img-top rounded-top-4 book-cover-img" />
                            <div class="card-body">
                                <h2 class="card-title">
                                    <a class="link-design" href="<?= $wishlist_item->post_name; ?>"><?= $wishlist_item->post_title; ?> </a>
                                </h2>
                                <p class="card-text"> <?= wp_trim_words($wishlist_item->post_content, 12) ?> </p>
                            </div>

                            <a class="text-end link-design" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank">

                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                                    <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" />
                                </svg>
                            </a>

                        </div>
                    </div>

                <?php endforeach; ?>

                <?php wp_reset_postdata(); ?> <!-- Restore the global post data after the loop. -->
            <?php else : ?>
                <p> <?= esc_html__('No books found.'); ?></p>
            <?php endif; ?>
        </div>
    </section>


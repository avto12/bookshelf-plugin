<?php

    $book_args = array(
        'post_type'   => 'books',
        'post_status' => 'publish',
        'order'       => 'DESC',
    );

    $books_query = new WP_Query($book_args);

?>


<section class="bookshelf-posts">

    <div class="row row-cols-1 row-cols-lg-3  row-cols-md-2 row-cols-sm-2 g-4">
            <?php if ($books_query->have_posts()) : ?>
                <?php foreach ($books_query->posts as $book) : setup_postdata($book); ?>
                    <div class="col">
                        <div class="card h-100 rounded-4 border-0 box-information">

                            <img src="<?= wp_get_attachment_image_src(get_post_thumbnail_id($book), 'full ')[0]; ?>" alt="" class="card-img-top rounded-top-4 book-cover-img" />
                            <?php echo do_shortcode('[add_to_wishlist_button id="' . $book->ID . '"]'); ?>
                            <div class="card-body">
                                <h2 class="card-title">
                                    <a class="link-design" href="<?= get_permalink($book); ?>"><?= $book->post_title; ?> </a>
                                </h2>
                                <p class="card-text"> <?= wp_trim_words($book->post_content, 12) ?> </p>
                                <div>
                                    <?php $authors = get_the_terms($book->ID, 'authors'); ?>
                                    <?php if ($authors && !is_wp_error($authors)) : ?>
                                        <p class="book-details">
                                            <strong><?= esc_html__('Author:'); ?></strong>
                                            <?php foreach ($authors as $author) : ?>
                                                <span> <?php echo esc_html($author->name); ?> </span>
                                            <?php endforeach; ?>
                                        </p>
                                    <?php endif; ?>

                                    <?php $genres = get_the_terms($book->ID, 'genres'); ?>
                                    <?php if ($genres && !is_wp_error($genres)) : ?>
                                        <p class="book-details">
                                            <strong><?= esc_html__('Genre:'); ?></strong>
                                            <?php foreach ($genres as $genre) : ?>
                                                <span> <?php echo esc_html($genre->name); ?> </span>
                                            <?php endforeach; ?>
                                        </p>
                                    <?php endif; ?>

                                    <?php $published_years = get_the_terms($book->ID, 'published_years'); ?>
                                    <?php if ($published_years && !is_wp_error($published_years)) : ?>
                                        <p class="book-details">
                                            <strong><?= esc_html__('Published Year:'); ?></strong>
                                            <?php foreach ($published_years as $year) : ?>
                                                <span> <?php echo esc_html($year->name); ?> </span>
                                            <?php endforeach; ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
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

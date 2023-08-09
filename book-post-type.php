<?php



/* ---  Create custom post type books ---*/
function books_post_type()
{
    register_post_type(
        'books',
        array(
            'labels' => array(
                'name' => __('Books'),
//                'singular_name' => __('')
            ),
            'public' => true,
            'show_in_rest' => true,
            'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt'),
            'has_archive' => true,
            'rewrite'   => array('slug' => 'books'),
            'menu_position' => 5,
            'menu_icon' => 'dashicons-book',
            // 'taxonomies' => array('books', 'post_tag') // this is IMPORTANT
        )
    );
}
add_action('init', 'books_post_type');



function create_taxonomy()
{

    /* --- authors taxonomy ---*/
    register_taxonomy('authors', 'books', array(
        'hierarchical' => true,
        'labels' => array(
            'name' => _x('authors', 'taxonomy author name'),
            'singular_name' => _x('author', 'taxonomy author name'),
            'menu_name' => __('author'),
            'all_items' => __('All author'),
            'edit_item' => __('Edit author'),
            'update_item' => __('Update author'),
            'add_new_item' => __('Add author'),
            'new_item_name' => __('New author'),
        ),
        'show_ui' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
    ));


    /* --- Genres taxonomy ---*/
    register_taxonomy('genres', 'books', array(
        'hierarchical' => true,
        'labels' => array(
            'name' => _x('genres', 'taxonomy genres name'),
            'singular_name' => _x('Genres', 'taxonomy genres name'),
            'menu_name' => __('Genre'),
            'all_items' => __('All Genre'),
            'edit_item' => __('Edit Genre'),
            'update_item' => __('Update Genre'),
            'add_new_item' => __('Add Genre'),
            'new_item_name' => __('New Genre'),
        ),
        'show_ui' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
    ));


    /* --- Published years taxonomy ---*/
    register_taxonomy('published_years', 'books', array(
        'hierarchical' => true,
        'labels' => array(
            'name' => _x('published years', 'taxonomy published years name'),
            'singular_name' => _x('published_years', 'taxonomy published_years name'),
            'menu_name' => __('Published year'),
            'all_items' => __('All Published year'),
            'edit_item' => __('Edit Published year'),
            'update_item' => __('Update Published year'),
            'add_new_item' => __('Add Published year'),
            'new_item_name' => __('New Published year'),
        ),
        'show_ui' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
    ));
}
add_action('init', 'create_taxonomy', 10);




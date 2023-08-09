 <?php

// book card show
    if (!is_admin()) {
        function show_books()
        {
            include 'book-card.php';
        }
        add_shortcode('post_new', 'show_books');
    }

?>

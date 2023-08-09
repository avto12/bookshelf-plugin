// wishlist.js
document.addEventListener('DOMContentLoaded', function() {
  const addToWishlistButtons = document.querySelectorAll('.add-to-wishlist');
  const removeFromWishlistButtons = document.querySelectorAll('.remove-from-wishlist');

  addToWishlistButtons.forEach(button => {
    button.addEventListener('click', function(event) {
      event.preventDefault();
        const itemId = this.dataset.itemId;

      // AJAX request to add item to wishlist
      fetch(wishlistAjax.ajaxurl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=add_to_wishlist&nonce=${wishlistAjax.nonce}&item_id=${itemId}`,
      })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              // Item added to wishlist successfully, update UI as needed
              console.log(data.message);
                const wishlistCountElement = document.getElementById('wishlist-count');
                if (wishlistCountElement) {
                    wishlistCountElement.textContent = data.count;
                }

            }
          })
          .catch(error => {
            // Handle fetch error
            console.error('Fetch error:', error);
          });
    });
  });



  // remove book in wishlist

removeFromWishlistButtons.forEach(button => {
    button.addEventListener('click', function(event) {
      event.preventDefault();
      const itemId = this.dataset.itemId;

      // AJAX request to remove item from wishlist
      fetch(wishlistAjax.ajaxurl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=remove_from_wishlist&nonce=${wishlistAjax.nonce}&item_id=${itemId}`,
      })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              // Item removed from wishlist successfully, update UI as needed
              console.log(data.message);
              // Optional: Reload the page to refresh the wishlist items display
              location.reload();
            } else {
              // Failed to remove item from wishlist, handle error
              console.error(data.message);
            }
          })
          .catch(error => {
            // Handle fetch error
            console.error('Fetch error:', error);
          });
    });
  });
});

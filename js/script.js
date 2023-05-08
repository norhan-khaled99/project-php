// Add to cart button click event
$(".add-to-cart").click(function(event) {
    event.preventDefault();
    let productId = $(this).attr("data-id");
    let action = "add";
    let quantity = $("#quantity-" + productId).val();
  
    // Ajax call
    $.ajax({
      url: "ajax.php",
      method: "POST",
      data: {productId: productId, action: action, quantity: quantity},
      success: function(response) {
        let data = JSON.parse(response);
        if (data.status == "success") {
          $("#cart-count").html(data.cartCount);
          $("#cart-items").html(data.cartItems);
          $("#cart-total").html(data.cartTotal);
          $("#success-message").html(data.message);
          $("#cart-modal").modal("show");
        } else {
          alert(data.message);
        }
      }
    });
  });
  
  // Remove from cart button click event
  $(document).on("click", ".remove-from-cart", function() {
    let productId = $(this).attr("data-id");
    let action = "remove";
  
    // Ajax call
    $.ajax({
      url: "ajax.php",
      method: "POST",
      data: {productId: productId, action: action},
      success: function(response) {
        let data = JSON.parse(response);
        if (data.status == "success") {
          $("#cart-count").html(data.cartCount);
          $("#cart-items").html(data.cartItems);
          $("#cart-total").html(data.cartTotal);
        } else {
          alert(data.message);
        }
      }
    });
  });
  
  // Clear cart button click event
  $("#clear-cart").click(function() {
    let action = "clear";
  
    // Ajax call
    $.ajax({
      url: "ajax.php",
      method: "POST",
      data: {action: action},
      success: function(response) {
        let data = JSON.parse(response);
        if (data.status == "success") {
          $("#cart-count").html(data.cartCount);
          $("#cart-items").html(data.cartItems);
          $("#cart-total").html(data.cartTotal);
        } else {
          alert(data.message);
        }
      }
    });
  });
  
  // Checkout button click event
  $("#checkout").click(function() {
    let action = "checkout";
  
    // Ajax call
    $.ajax({
      url: "ajax.php",
      method: "POST",
      data: {action: action},
      success: function(response) {
        let data = JSON.parse(response);
        if (data.status == "success") {
          let orderItems = "";
          $.each(data.cartItems, function(index, item) {
            orderItems += `
              <div class="order-item">
                <span class="order-item-name">${item.name} x ${item.quantity}</span>
                <span class="order-item-price">${item.total_price}</span>
              </div>
            `;
          });
          let orderSummaryModal = document.getElementById("order-summary-modal");
          orderSummaryModal.innerHTML = `
            <div class="order-summary">
              <h3>Your order summary:</h3>
              ${orderItems}
              <div class="order-total">
                <span class="order-total-label">Total:</span>
                <span class="order-total-amount">${data.cartTotal}</span>
              </div>
            </div>
          `;
          $("#cart-count").html(data.cartCount);
          $("#cart-items").html(data.cartItems);
          $("#cart-total").html(data.cartTotal);
          $("#checkout-modal").modal("show");
        } else {
          alert(data.message);
        }
      }
    });
  });
  
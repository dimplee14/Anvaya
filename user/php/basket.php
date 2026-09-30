<?php
include 'db.php';
session_start();
// Get user_id from session (adjust if your session variable is different)
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
if (!$user_id) {
  header('Location: login.php');
  exit();
}

$hasDesignForm = false;
$hasDesignPreference = false;
$orderApproved = false;
$finalOrderDetails = null;
// Fetch all orders for this user
$orders = [];
$sql = "SELECT o.order_id, o.preference_id, o.status, o.final_style_desc, o.measurement AS final_measurement, o.final_price, o.delivery_date AS expected_delivery_date, d.designer_name, d.phone AS designer_contact, o.delivery_address FROM orders o LEFT JOIN designers d ON o.designer_id = d.designer_id WHERE o.user_id = $user_id ORDER BY o.order_id DESC";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $orders[] = $row;
  }
}
$hasDesignForm = count($orders) > 0;
// Check if user has a design preference form
$pref_sql = "SELECT preference_id FROM user_design_preferences WHERE user_id = $user_id LIMIT 1";
$pref_result = mysqli_query($conn, $pref_sql);
if ($pref_result && mysqli_num_rows($pref_result) > 0) {
  $hasDesignPreference = true;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Basket / Checkout</title>
  <link rel="stylesheet" href="../css/basket.css">
</head>

<body>
  <div class="">
    <?php if (!$hasDesignForm && $hasDesignPreference): ?>
      <!-- Show order receive modal if user has design preference but no orders -->
      <div id="orderReceivedModal" class="fullscreen-modal" style="display:flex;">
        <button class="back-btn" onclick="history.back()"
          style="position:absolute; left:32px; top:32px; background:#fff; border:none; border-radius:50%; box-shadow:0 2px 8px #e0e0e0; width:48px; height:48px; font-size:1.5rem; cursor:pointer; transition:background 0.2s; color:#007bff; z-index:10;">←</button>
        <div style="font-size:4rem; margin-bottom:18px;">
          <span
            style="display:inline-block; background:#f5f5f5; border-radius:50%; padding:28px 36px; box-shadow:0 2px 12px #eee;">&#128172;</span>
        </div>
        <div style="font-size:2rem; font-weight:600; margin-bottom:10px; color:#007bff;">Order received!</div>
        <div style="font-size:1.1rem; margin-bottom:28px; color:#555;">A designer will contact you soon to confirm your
          requirements and begin processing your order.</div>
      </div>
      <style>
        .fullscreen-modal {
          position: fixed;
          top: 0;
          left: 0;
          width: 100vw;
          height: 100vh;
          background: #fff;
          z-index: 9999;
          display: flex;
          flex-direction: column;
          align-items: center;
          justify-content: center;
          overflow: hidden;
        }

        body.modal-open {
          overflow: hidden !important;
        }
      </style>
      <script>
        document.addEventListener('DOMContentLoaded', function () {
          document.body.classList.add('modal-open');
        });
      </script>
    <?php elseif (!$hasDesignForm): ?>
      <div id="emptyBasketModal" class="fullscreen-modal" style="display:flex;">
        <button class="back-btn" onclick="history.back()"
          style="position:absolute; left:32px; top:32px; background:#fff; border:none; border-radius:50%; box-shadow:0 2px 8px #e0e0e0; width:48px; height:48px; font-size:1.5rem; cursor:pointer; transition:background 0.2s; color:#007bff; z-index:10;">←</button>
        <div style="font-size:4rem; margin-bottom:18px;">
          <span
            style="display:inline-block; background:#f5f5f5; border-radius:50%; padding:28px 36px; box-shadow:0 2px 12px #eee;">🛒</span>
        </div>
        <div style="font-size:2rem; font-weight:600; margin-bottom:10px; color:#444;">Your basket is currently empty</div>
        <div style="font-size:1.1rem; margin-bottom:28px; color:#888;">You have not added any items to your basket yet.
        </div>
        <a href="design.php"
          style="display:inline-block; background:#007bff; color:#fff; padding:12px 32px; border-radius:24px; text-decoration:none; font-size:1.1rem; font-weight:500; box-shadow:0 2px 8px #e0e0e0; transition:background 0.2s;">Browse
          Designs</a>
      </div>
      <style>
        .fullscreen-modal {
          position: fixed;
          top: 0;
          left: 0;
          width: 100vw;
          height: 100vh;
          background: #fff;
          z-index: 9999;
          display: flex;
          flex-direction: column;
          align-items: center;
          justify-content: center;
          overflow: hidden;
        }

        body.modal-open {
          overflow: hidden !important;
        }
      </style>
      <script>
        document.addEventListener('DOMContentLoaded', function () {
          document.body.classList.add('modal-open');
        });
      </script>
    <?php elseif ($hasDesignForm): ?>
      <div class="top-bar">
        <button class="back-btn" onclick="history.back()">← Back</button>
        <h1>Basket / Orders</h1>
      </div>
      <?php if (count($orders) > 1): ?>
        <div class="multiple-orders-info"
          style="background:#e3eafc; color:#003366; border-radius:10px; padding:18px 24px; margin-bottom:28px; font-size:1.15rem; font-weight:600; text-align:center; box-shadow:0 2px 8px #e0e0e0;">
          You have <?php echo count($orders); ?> orders in your basket.
        </div>
      <?php endif; ?>
      <?php foreach ($orders as $order): ?>
        <?php
        // ...existing code for status mapping...
        $statusSteps = [
          'pending' => 'Order Placed',
          'approve' => 'Approved',
          'confirmed' => 'Confirmed',
          'processing' => 'Processing',
          'ready' => 'Ready for Delivery',
          'delivered' => 'Delivered'
        ];
        $currentStatus = strtolower(trim($order['status']));
        $statusMap = [
          'order_received' => 'pending',
          'pending' => 'pending',
          'order_confirmed' => 'confirmed',
          'order_confirm' => 'confirmed',
          'confirmed' => 'confirmed',
          'in_process' => 'processing',
          'in process' => 'processing',
          'processing' => 'processing',
          'out_for_delivery' => 'ready',
          'out for delivery' => 'ready',
          'ready' => 'ready',
          'delivered' => 'delivered',
          'delivered ' => 'delivered',
          'Delivered' => 'delivered',
          'DELIVERED' => 'delivered',
          'cancelled' => 'cancelled',
        ];
        // Normalize status for any variant of confirmed or delivered
        if (isset($statusMap[$currentStatus])) {
          $currentStatus = $statusMap[$currentStatus];
        } elseif (strpos($currentStatus, 'confirm') !== false) {
          $currentStatus = 'confirmed';
        } elseif (strpos($currentStatus, 'delivered') !== false) {
          $currentStatus = 'delivered';
        }
        $stepKeys = array_keys($statusSteps);
        $currentStep = array_search($currentStatus, $stepKeys);
        ?>
        <div class="order-card">
          <?php if ($currentStatus === 'order_recieved'): ?>
            <div id="orderReceivedModal" class="fullscreen-modal" style="display:flex;">
              <button class="back-btn" onclick="history.back()"
                style="position:absolute; left:32px; top:32px; background:#fff; border:none; border-radius:50%; box-shadow:0 2px 8px #e0e0e0; width:48px; height:48px; font-size:1.5rem; cursor:pointer; transition:background 0.2s; color:#007bff; z-index:10;">←</button>
              <div style="font-size:4rem; margin-bottom:18px;">
                <span
                  style="display:inline-block; background:#f5f5f5; border-radius:50%; padding:28px 36px; box-shadow:0 2px 12px #eee;">&#128172;</span>
              </div>
              <div style="font-size:2rem; font-weight:600; margin-bottom:10px; color:#007bff;">Order received!</div>
              <div style="font-size:1.1rem; margin-bottom:28px; color:#555;">A designer will contact you soon to confirm your
                requirements and begin processing your order.</div>
            </div>
            <style>
              .fullscreen-modal {
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                background: #fff;
                z-index: 9999;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                overflow: hidden;
              }

              body.modal-open {
                overflow: hidden !important;
              }
            </style>
            <script>         document.addEventListener('DOMContentLoaded', function () { document.body.classList.add('modal-open'); });
            </script>
          <?php else: ?>
            <div class="section order-status">
              <h2>Order #<?php echo $order['order_id']; ?> Status</h2>
              <div class="progress-bar">
                <?php $stepKeys = array_keys($statusSteps);
                $i = 0;
                foreach ($statusSteps as $key => $label):
                  $isActive = ($currentStep !== false && $currentStep >= $i);
                  // ...existing code...
                  ?>
                  <div class="step<?php echo $isActive ? ' active' : ''; ?>">
                    <span class="status-icon">
                      <?php if ($key === 'pending'): ?>&#128722;
                      <?php elseif ($key === 'confirmed'): ?>&#9989;
                      <?php elseif ($key === 'processing'): ?>&#128295;
                      <?php elseif ($key === 'ready'): ?>&#128666;
                      <?php elseif ($key === 'delivered'): ?>&#127873;
                      <?php endif; ?>
                    </span> <?php echo $label; ?>
                  </div>
                  <?php $i++; endforeach; ?>
              </div>
              <p class="expected-date">Expected Delivery:
                <span><?php echo htmlspecialchars($order['expected_delivery_date'] ?? 'To be updated'); ?></span>
              </p>
              <?php if ($currentStatus === 'cancelled'): ?>
                <div style="color:#FA0608; font-weight:600; margin-top:10px;">This order has been cancelled.</div>
              <?php endif; ?>
            </div>
            <div class="section order-summary">
              <h2>Order Summary</h2>
              <div class="summary-row">
                <div>
                  <p><strong>Designer Name:</strong>
                    <span><?php echo htmlspecialchars($order['designer_name'] ?? 'N/A'); ?></span>
                  </p>
                  <p><strong>Designer Contact:</strong>
                    <span><?php echo htmlspecialchars($order['designer_contact'] ?? 'N/A'); ?></span>
                  </p>
                </div>
                <div>
                  <?php if (!empty($order['designer_contact'])): ?>
                    <button class="message-btn"
                      onclick="window.open('https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $order['designer_contact']); ?>','_blank')">
                      <span style="margin-right:8px;">&#128172;</span>Message Designer
                    </button>
                  <?php endif; ?>
                </div>
              </div>
              <div class="divider"></div>
              <p><strong>Style:</strong> <span><?php echo htmlspecialchars($order['final_style_desc'] ?? 'N/A'); ?></span></p>
              <p><strong>Approx Size:</strong>
                <span><?php echo htmlspecialchars($order['final_measurement'] ?? 'N/A'); ?></span>
              </p>
              <p class="final-price"><strong>Final Price:</strong>
                <span>₹<?php echo htmlspecialchars($order['final_price'] ?? 'N/A'); ?></span>
              </p>
              <p class="basket-warning" style="color:#FA0608;margin-top:8px;font-size:1rem;">* Please proceed with payment
                only if all details are correct. For any questions, contact your designer.</p>
            </div>
            <div class="section client-info">
              <h2>Delivery Address</h2>
              <?php
              $canEnterAddress = ((in_array($currentStatus, ['confirmed', 'approve'])) && empty($order['delivery_address']));
              $isDelivered = (strpos($currentStatus, 'delivered') !== false);
              $isCancelled = ($currentStatus === 'cancelled');
              // Allow cancel only if address/payment not done (status confirmed, address empty)
              $canCancel = ($currentStatus === 'confirmed' && empty($order['delivery_address']));
              ?>
              <?php if ($isDelivered): ?>
                <div
                  style="background:#e6ffe6; color:#218838; border-radius:10px; padding:24px; font-size:1.2rem; font-weight:600; text-align:center; margin-top:16px; box-shadow:0 2px 8px #d4edda;">
                  <span style="font-size:2.5rem; display:block; margin-bottom:10px;">&#127873;</span>
                  <div>Your order has been <span style="color:#28a745;">delivered</span>! Thank you for choosing us.</div>
                </div>
                <section class="review-section wide-review-section fullwidth-review-section"
                  id="review-section-<?php echo $order['order_id']; ?>">
                  <header style="display:flex; flex-direction:column; align-items:center; margin-bottom:28px;">
                    <span
                      style="font-size:2.6rem; color:#007bff; background:rgba(0,123,255,0.08); border-radius:50%; padding:12px 18px; box-shadow:0 2px 8px #e3eafc; margin-bottom:8px;">&#128172;</span>
                    <h3
                      style="margin:0; color:#003366; font-size:1.45rem; font-weight:900; letter-spacing:0.5px; text-align:center;">
                      We Value Your Feedback</h3>
                    <div style="font-size:1.01rem; color:#4a5a6a; margin-top:6px; text-align:center; max-width:320px;">Help us
                      improve by sharing your honest review and a photo of your order!</div>
                  </header>
                  <div class="review-form-container" style="width:100%; margin:0 auto;">
                    <form class="review-form" data-order-id="<?php echo $order['order_id']; ?>" enctype="multipart/form-data"
                      style="display:flex; flex-direction:column; gap:18px;">
                      <div style="display:flex; flex-direction:column; align-items:center; gap:8px;">
                        <label style="font-weight:700; color:#333; font-size:1.08rem;">Your Rating</label>
                        <span class="star-rating"
                          style="font-size:2.2rem; color:#FFD700; cursor:pointer; filter: drop-shadow(0 1px 2px #e0e0e0);">
                          <span data-value="1">&#9733;</span>
                          <span data-value="2">&#9733;</span>
                          <span data-value="3">&#9733;</span>
                          <span data-value="4">&#9733;</span>
                          <span data-value="5">&#9733;</span>
                        </span>
                        <input type="hidden" name="rating" class="review-rating" value="0">
                      </div>
                      <div>
                        <label for="review-text" style="font-weight:700; color:#333; font-size:1.08rem;">Your Review</label>
                        <textarea id="review-text" name="review" class="review-text" rows="3"
                          style="width:100%; border-radius:12px; border:1.5px solid #b3c6e0; padding:14px; font-size:1.08rem; background:#f6faff; box-shadow:0 1px 4px #f0f4fa; resize:vertical; min-height:80px; max-height:200px; margin-top:6px;"
                          placeholder="Write your feedback..." required></textarea>
                      </div>
                      <div>
                        <label style="font-weight:700; color:#333; font-size:1.08rem;">Photo (optional)</label><br>
                        <input type="file" name="photo" class="review-photo-input" accept="image/*"
                          style="margin-top:8px; border-radius:10px; border:1.5px solid #b3c6e0; padding:8px; background:#f6faff; width:100%; max-width:220px;">
                        <div class="photo-preview" style="margin-top:12px; display:none; text-align:center;"></div>
                      </div>
                      <button type="submit" class="submit-review-btn"
                        style="background:linear-gradient(90deg,#007bff,#00c6ff); color:#fff; border:none; border-radius:22px; padding:14px 0; font-size:1.13rem; font-weight:800; cursor:pointer; box-shadow:0 2px 10px #e0e0e0; transition:background 0.2s; width:100%; max-width:220px; margin:0 auto; display:block; letter-spacing:0.5px;">Submit
                        Review</button>
                      <div class="review-success"
                        style="display:none; color:#28a745; font-weight:700; margin-top:16px; text-align:center;">Thank you for
                        your review!</div>
                    </form>
                  </div>
                  <div class="review-thankyou" style="display:none;">
                    <div style="text-align:center;">
                      <span class="review-stars"
                        style="font-size:2.2rem; color:#FFD700; display:block; margin-bottom:10px; filter: drop-shadow(0 1px 2px #e0e0e0);"></span>
                      <div style="font-size:1.13rem; color:#28a745; font-weight:700; margin-bottom:8px;">Thank you for sharing
                        your feedback!</div>
                      <div class="review-details" style="margin-top:10px; color:#333; font-size:1.08rem;"></div>
                      <div class="review-photo-show" style="margin-top:18px; text-align:center;"></div>
                    </div>
                  </div>
                </section>
              </div>
            <?php elseif ($canEnterAddress): ?>
              <form class="clientForm" data-order-id="<?php echo $order['order_id']; ?>" autocomplete="off">
                <div class="form-group">
                  <textarea class="deliveryAddress" placeholder="Enter your delivery address" required></textarea>
                </div>
                <button type="button" class="pay-btn"
                  onclick="confirmOrderForOrderId(<?php echo $order['order_id']; ?>, this)">Confirm Order & Pay</button>
              </form>
              <div class="order-confirmed-message" style="display:none;"></div>
            <?php elseif (!empty($order['delivery_address'])): ?>
              <div class="order-confirmed-message"
                style="background:#e6ffe6; color:#218838; border-radius:10px; padding:24px; font-size:1.3rem; font-weight:600; text-align:center; margin-top:16px; box-shadow:0 2px 8px #d4edda;">
                <span style="font-size:2.5rem; display:block; margin-bottom:10px;">&#127881;</span>
                Your order is <span style="color:#28a745;">confirmed!</span><br>
                Thank you for your order. Your items will be delivered to:<br>
                <span
                  style="font-size:1.1rem; color:#155724; display:block; margin-top:10px;">"<?php echo htmlspecialchars($order['delivery_address']); ?>"</span>
              </div>
            <?php elseif ($isCancelled): ?>
              <div
                style="background:#ffe6e6; color:#c82333; border-radius:10px; padding:24px; font-size:1.2rem; font-weight:600; text-align:center; margin-top:16px; box-shadow:0 2px 8px #f5c6cb;">
                <span style="font-size:2.5rem; display:block; margin-bottom:10px;">&#10060;</span>
                This order has been cancelled.
              </div>
            <?php else: ?>
              <div style="color:#888; margin-top:8px;">Your order is being processed. You can submit your delivery address after
                admin approval.</div>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
  </div>
  <script src="../js/basket.js"></script>
  <script>
    function confirmOrderForOrderId(orderId, btn) {
      var form = btn.closest('.clientForm');
      var address = form.querySelector('.deliveryAddress').value.trim();
      if (!address) {
        alert('Please enter your delivery address.');
        return;
      }
      btn.disabled = true;
      btn.textContent = 'Processing...';
      fetch('process_confirm_order.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'order_id=' + encodeURIComponent(orderId) + '&delivery_address=' + encodeURIComponent(address)
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Reload the page to fetch updated status from the server
            window.location.reload();
          } else {
            alert(data.message || 'Failed to confirm order.');
            btn.disabled = false;
            btn.textContent = 'Confirm Order & Pay';
          }
        })
        .catch(() => {
          alert('Network error. Please try again later.');
          btn.disabled = false;
          btn.textContent = 'Confirm Order & Pay';
        });
    }

    // Review form UI and AJAX
    document.addEventListener('DOMContentLoaded', function () {
      document.querySelectorAll('.review-section').forEach(function (section) {
        var orderId = section.id.replace('review-section-', '');
        var formContainer = section.querySelector('.review-form-container');
        var thankyou = section.querySelector('.review-thankyou');
        // Check if review exists
        fetch('get_review.php?order_id=' + encodeURIComponent(orderId))
          .then(response => response.json())
          .then(data => {
            if (data.review) {
              // Show thank you and review details
              formContainer.style.display = 'none';
              thankyou.style.display = 'block';
              var stars = '';
              for (var i = 0; i < 5; i++) stars += (i < data.review.rating ? '★' : '☆');
              thankyou.querySelector('.review-stars').innerHTML = stars;
              thankyou.querySelector('.review-details').innerHTML =
                '<div style="font-size:1rem; color:#444;">' + data.review.review.replace(/</g, '&lt;').replace(/>/g, '&gt;') + '</div>';
              if (data.review.photo_path) {
                thankyou.querySelector('.review-photo-show').innerHTML = '<img src="../../' + data.review.photo_path + '" alt="Review Photo" style=" border-radius:10px; box-shadow:0 2px 8px #e0e0e0; margin-top:8px;">';
              } else {
                thankyou.querySelector('.review-photo-show').innerHTML = '';
              }
            } else {
              // Show form
              formContainer.style.display = 'block';
              thankyou.style.display = 'none';
            }
          });
      });
      document.querySelectorAll('.review-section .star-rating').forEach(function (stars) {
        let ratingInput = stars.closest('.review-section').querySelector('.review-rating');
        stars.querySelectorAll('span').forEach(function (star) {
          star.addEventListener('mouseenter', function () {
            let val = parseInt(star.getAttribute('data-value'));
            stars.querySelectorAll('span').forEach(function (s, i) {
              s.style.color = (i < val) ? '#FFD700' : '#ccc';
            });
          });
          star.addEventListener('mouseleave', function () {
            let current = parseInt(ratingInput.value);
            stars.querySelectorAll('span').forEach(function (s, i) {
              s.style.color = (i < current) ? '#FFD700' : '#ccc';
            });
          });
          star.addEventListener('click', function () {
            let val = parseInt(star.getAttribute('data-value'));
            ratingInput.value = val;
            stars.querySelectorAll('span').forEach(function (s, i) {
              s.style.color = (i < val) ? '#FFD700' : '#ccc';
            });
          });
        });
      });
      document.querySelectorAll('.review-form').forEach(function (form) {
        // Photo preview
        var photoInput = form.querySelector('.review-photo-input');
        var photoPreview = form.querySelector('.photo-preview');
        if (photoInput) {
          photoInput.addEventListener('change', function () {
            if (photoInput.files && photoInput.files[0]) {
              var reader = new FileReader();
              reader.onload = function (e) {
                photoPreview.innerHTML = '<img src="' + e.target.result + '" style="max-width:100%; border-radius:10px; box-shadow:0 2px 8px #e0e0e0;">';
                photoPreview.style.display = 'block';
              };
              reader.readAsDataURL(photoInput.files[0]);
            } else {
              photoPreview.innerHTML = '';
              photoPreview.style.display = 'none';
            }
          });
        }
        form.addEventListener('submit', function (e) {
          e.preventDefault();
          var orderId = form.getAttribute('data-order-id');
          var rating = form.querySelector('.review-rating').value;
          var review = form.querySelector('.review-text').value.trim();
          var btn = form.querySelector('.submit-review-btn');
          if (!rating || rating < 1 || rating > 5) {
            alert('Please select a rating.');
            return;
          }
          if (!review) {
            alert('Please write your review.');
            return;
          }
          btn.disabled = true;
          btn.textContent = 'Submitting...';
          var formData = new FormData();
          formData.append('order_id', orderId);
          formData.append('rating', rating);
          formData.append('review', review);
          if (photoInput && photoInput.files && photoInput.files[0]) {
            formData.append('photo', photoInput.files[0]);
          }
          fetch('submit_review_with_photo.php', {
            method: 'POST',
            body: formData
          })
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                form.closest('.review-form-container').style.display = 'none';
                var thankyou = form.closest('.review-section').querySelector('.review-thankyou');
                thankyou.style.display = 'block';
                var stars = '';
                for (var i = 0; i < 5; i++) stars += (i < rating ? '★' : '☆');
                thankyou.querySelector('.review-stars').innerHTML = stars;
                thankyou.querySelector('.review-details').innerHTML = '<div style="font-size:1rem; color:#444;">' + review.replace(/</g, '&lt;').replace(/>/g, '&gt;') + '</div>';
                if (data.photo) {
                  thankyou.querySelector('.review-photo-show').innerHTML = '<img src="../' + data.photo + '" alt="Review Photo" style="max-width:100%; border-radius:10px; box-shadow:0 2px 8px #e0e0e0; margin-top:8px;">';
                } else {
                  thankyou.querySelector('.review-photo-show').innerHTML = '';
                }
              } else {
                alert(data.message || 'Failed to submit review.');
                btn.disabled = false;
                btn.textContent = 'Submit Review';
              }
            })
            .catch(() => {
              alert('Network error. Please try again.');
              btn.disabled = false;
              btn.textContent = 'Submit Review';
            });
        });
      });
    });
  </script>
</body>

</html>

</html>
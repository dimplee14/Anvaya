<?php
include 'db.php';
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit();
}

// Handle form submission and user check before any output
$success = '';
$error = '';

if (isset($_POST['submit_design'])) {
  $occasion = $_POST['occasion'] ?? '';
  $style = $_POST['style'] ?? '';
  $budget = $_POST['budget'] ?? '';
  $liked_items = $_POST['selected_products'] ?? '';
  $age = $_POST['age'] ?? '';
  $height = $_POST['height'] ?? '';
  $size = $_POST['size'] ?? '';
  $color = $_POST['color'] ?? '';
  $agree = isset($_POST['agree']) ? 1 : 0;

  // Insert into user_design_preferences table only if user_id exists in users
  $user_id = $_SESSION['user_id'];
  $created_at = date('Y-m-d H:i:s');
  $check_stmt = $conn->prepare("SELECT user_id FROM users WHERE user_id = ?");
  $check_stmt->bind_param("i", $user_id);
  $check_stmt->execute();
  $check_stmt->store_result();
  if ($check_stmt->num_rows !== 1) {
    $check_stmt->close();
    header('Location: login.php');
    exit();
  }
  $check_stmt->close();

  // Handle file uploads
  $uploaded_files = [];
  if (!empty($_FILES['file']['name'][0])) {
    $target_dir = '../assets/img/uploads/';
    if (!is_dir($target_dir)) {
      mkdir($target_dir, 0777, true);
    }
    foreach ($_FILES['file']['name'] as $key => $name) {
      if (!empty($name)) {
        $tmp_name = $_FILES['file']['tmp_name'][$key];
        $file_name = uniqid() . '_' . basename($name);
        $target_file = $target_dir . $file_name;
        if (move_uploaded_file($tmp_name, $target_file)) {
          $uploaded_files[] = $file_name;
        }
      }
    }
  }
  $images = $uploaded_files ? implode(',', $uploaded_files) : null;

  $stmt = $conn->prepare("INSERT INTO user_design_preferences (user_id, occasion, style, budget, liked_items, age, height, approx_size, colour, uploaded_photo, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
  if ($stmt) {
    $stmt->bind_param("issssssssss", $user_id, $occasion, $style, $budget, $liked_items, $age, $height, $size, $color, $images, $created_at);
    if ($stmt->execute()) {
      $_SESSION['design_success'] = "Thank you for submitting your design preferences! Our designer will contact you via WhatsApp within 48 hours to start your personalized designer outfit process.";
      header('Location: ' . $_SERVER['PHP_SELF']);
      exit();
    } else {
      $_SESSION['design_error'] = "Error submitting your design. Please try again.";
    }
    $stmt->close();
  } else {
    $_SESSION['design_error'] = "Database error.";
  }
  // Redirect to avoid resubmission on refresh
  header('Location: ' . $_SERVER['PHP_SELF']);
  exit();
}

// Show messages if redirected
$success = '';
$error = '';
if (isset($_SESSION['design_success'])) {
  $success = $_SESSION['design_success'];
  unset($_SESSION['design_success']);
}
if (isset($_SESSION['design_error'])) {
  $error = $_SESSION['design_error'];
  unset($_SESSION['design_error']);
}

include("header.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Design Studio</title>
  <link rel="stylesheet" href="../css/design.css">
  <link rel="stylesheet" href="../css/media/design.css">
</head>

<body>
  <main>
    <section class="design-Studio">
      <div class="design">
        <div class="design-heading heading">
          <div class="black-head head">Design<span> Studio</span></div>
          <div class="underline">
            <div class="black-underline1 underline1"></div>
            <div class="black-underline2 underline2"></div>
            <div class="black-underline1 underline1"></div>
          </div>
        </div>
        <div class="design-content content">
          <p class="black-p p">Answer these simple questions and our Design and Styling team will help you
            Design your own Dream Outfit!</p>
        </div>
      </div>


      <div class="gender-btn">
        <div class="male"><button type="button" class="male-btn">Male</button></div>
        <div class="female"><button type="button" class="female-btn active">Female</button></div>
        <input type="hidden" name="gender" id="gender_input" value="female">
      </div>

      <?php if ($success): ?>
        <div class="submit-message" style="color:green;"><?php echo $success; ?></div>
      <?php elseif ($error): ?>
        <div class="submit-message" style="color:red;background:#fbeaea;"><?php echo $error; ?></div>
      <?php endif; ?>

      <form class="design-form" method="post" action="" enctype="multipart/form-data"
        onsubmit="collectSelectedProducts()">
        <input type="hidden" name="selected_products" id="selected_products">

        <!-- Question 1 -->
        <div class="que1-box">
          <div class="que1-img"><img src="../assets/img/3.4.jpg" alt=""></div>
          <div class="que1">
            <label class="que">When are you planning to wear it?</label>
            <div class="sapration-line"></div>
            <?php
            $occasions = ["Wedding", "Engagement or Reception", "Festival or Small Event", "Birthday or Parties", "Family Function / Traditional Ceremony", "Other"];
            foreach ($occasions as $idx => $val) {
              $id = "occasion_" . $idx;
              echo "<div class='radio-btn'>
                            <input type='radio' name='occasion' id='$id' value='$val' required>
                            <label for='$id'>$val</label>
                          </div>";
            }
            ?>
          </div>
        </div>

        <!-- Question 2 -->
        <div class="que2-box">
          <div class="que2">
            <label class="que">Choose Your Perfect Style
            </label>
            <div class="sapration-line"></div>
            <?php
            // Default to female styles, will be replaced by JS for male
            $female_styles = ["Lehenga", "Saree", "Anarkali", "Designer Suits", "Evening Gown / Party Gown", "Indo-Western Fusion", "Custom / Other"];
            $male_styles = ["Bandhgala", "Casual Shirt", "Kurta", "Sherwani", "Designer Suits", "jodhpuri", "Custom / Other"];
            $styles = $female_styles; // default
            echo '<div id="style-options-php">';
            foreach ($styles as $idx => $val) {
              $id = "style_" . $idx;
              echo "<div class='radio-btn'>
                            <input type='radio' name='style' id='$id' value='$val' required>
                            <label for='$id'>$val</label>
                          </div>";
            }
            echo '</div>';
            ?>
          </div>
          <div class="que2-img"><img src="../assets/img/3.4.jpg" alt=""></div>
        </div>
        <script>
          // Gender switch logic for style options
          const maleStyles = ["Bandhgala", "Casual Shirt", "Kurta", "Sherwani", "Designer Suits", "jodhpuri", "Custom / Other"];
          const femaleStyles = ["Lehenga", "Saree", "Anarkali", "Designer Suits", "Evening Gown / Party Gown", "Indo-Western Fusion", "Custom / Other"];
          document.querySelector('.male-btn').addEventListener('click', function () {
            document.getElementById('gender_input').value = 'male';
            document.querySelector('.male-btn').classList.add('active');
            document.querySelector('.female-btn').classList.remove('active');
            renderStyleOptions(maleStyles);
          });
          document.querySelector('.female-btn').addEventListener('click', function () {
            document.getElementById('gender_input').value = 'female';
            document.querySelector('.female-btn').classList.add('active');
            document.querySelector('.male-btn').classList.remove('active');
            renderStyleOptions(femaleStyles);
          });
          function renderStyleOptions(styles) {
            const container = document.getElementById('style-options-php');
            let html = '';
            styles.forEach((val, idx) => {
              const id = 'style_' + idx;
              html += `<div class='radio-btn'>
                <input type='radio' name='style' id='${id}' value='${val}' required>
                <label for='${id}'>${val}</label>
            </div>`;
            });
            container.innerHTML = html;
          }
        </script>

        <!-- Budget & Products -->
        <div class="selection-box">
          <div class="heading-budget-box">
            <div class="selection-heading">
              <div>
                <div class="que">Select All Which You Like <span>(Let us Know What You Like)</span>
                </div>
                <div class="sapration-line"></div>
              </div>
              <div class="light-heading">Saree</div>
            </div>
            <div class="budget-box">
              <div class="budget-form">
                <select name="budget" required>
                  <option value="" disabled selected>What’s Your Budget ?</option>
                  <option value="10000">Under 10,000</option>
                  <option value="30000">Under 30,000</option>
                  <option value="50000">Under 50,000</option>
                  <option value="100000+">Over 1,00,000</option>
                </select>
              </div>
            </div>
          </div>
          <div class="saree-img-group">
            <div class="crousel-track">
              <div class="saree-img1 card">
                <div class="img"><img src="../assets/img/6.1.png" alt=""></div>
                <div>Saree Name</div>
              </div>

              <div class="saree-img2 card">
                <div class="img"><img src="../assets/img/6.2.png" alt=""></div>
                <div>Saree Name</div>

              </div>

              <div class="saree-img3 card">
                <div class="img"><img src="../assets/img/6.3.png" alt=""></div>
                <div>Saree Name</div>

              </div>

              <div class="saree-img4 card">
                <div class="img"><img src="../assets/img/6.4.png" alt=""></div>
                <div>Saree Name</div>

              </div>

              <div class="saree-img5 card">
                <div class="img"><img src="../assets/img/6.1.png" alt=""></div>
                <div>Saree Name</div>

              </div>

            </div>
            <div class="crousel-dots"></div>
          </div>
        </div>

        <!-- File Upload & Personal Info -->
        <div class="tell-us-main">
          <div class="tell-file">
            <div class="que">Tell us your likes.</div>
            <div class="sapration-line"></div>
            <div class="light-head">Upload up to 5 Images of Your Inspirations.</div>
            <div class="file-upload">
              <input type="file" name="file[]" id="file" multiple accept="image/*" max="5">
              <script>
                document.addEventListener('DOMContentLoaded', function () {
                  var fileInput = document.getElementById('file');
                  fileInput.addEventListener('change', function (e) {
                    if (this.files.length > 5) {
                      // Only keep the first 5 files, do not show error
                      var dt = new DataTransfer();
                      for (var i = 0; i < 5; i++) {
                        dt.items.add(this.files[i]);
                      }
                      this.files = dt.files;
                    }
                  });
                });
              </script>
              <label for="file" class="file-label">Browse or Drop Your Images here. (Optional)</label>
            </div>
            <div class="agree">
              <input type="radio" name="agree" id="agree" required>
              <label for="agree">I Agree to the Terms & Conditions</label>
            </div>
          </div>

          <div class="tell-us-more">
            <div class="que">Tell us more about you.</div>
            <div class="sapration-line"></div>
            <div class="drop-down-list-group">
              <div class="group1">
                <select name="age" required>
                  <option value="" disabled selected>What’s Your Age ?</option>
                  <option value="0-18">Under 18</option>
                  <option value="18-25">18 to 25</option>
                  <option value="26-35">26 to 35</option>
                  <option value="36-45">36 to 45</option>
                  <option value="46-60">46 to 60</option>
                  <option value="60+">60 and above</option>
                </select>
              </div>
              <div class="group2">
                <select name="height" required>
                  <option value="" disabled selected>What’s Your Height ?</option>
                  <option value="-150">Under 150 cm</option>
                  <option value="150-160">150 to 160 cm</option>
                  <option value="161-170">161 to 170 cm</option>
                  <option value="171-180">171 to 180 cm</option>
                  <option value="181-190">181 to 190 cm</option>
                  <option value="190+">Above 190 cm</option>
                </select>
              </div>
              <div class="group3">
                <select name="size" required>
                  <option value="" disabled selected>What’s Your Approximate Size ?</option>
                  <option value="xs">Extra Small (XS)</option>
                  <option value="s">Small (S)</option>
                  <option value="m">Medium (M)</option>
                  <option value="l">Large (L)</option>
                  <option value="xl">Extra Large (XL)</option>
                  <option value="xxl">Double Extra Large (XXL)</option>
                </select>
              </div>
              <div class="group4">
                <select name="color" required>
                  <option value="" disabled selected>Your Colour Preferences ?</option>
                  <option value="Neutral tones (beige, white, gray)">Neutral tones (beige, white, gray)</option>
                  <option value="Bold & vibrant colors">Bold & vibrant colors</option>
                  <option value="Pastel colors">Pastel colors</option>
                  <option value="Earthy colors">Earthy colors</option>
                  <option value="Monochrome">Monochrome</option>
                  <option value="Metallic finishes">Metallic finishes</option>
                  <option value="custom">Custom / No preference</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        <div class="submit-btn">
          <button type="submit" name="submit_design">Submit</button>
        </div>
      </form>

      <!-- Optional: Size chart -->
      <div class="size-color-box">
        <div class="size-chart">
          <div class="que" for="que">Female Size Chart</div>
          <div class="sapration-line"></div>
          <div class="size-chart-table">
            <table class="markdown-table">
              <thead>
                <tr>
                  <th>
                    <p>Sizes</p>
                  </th>
                  <th>
                    <p>XS</p>
                  </th>
                  <th>
                    <p>S</p>
                  </th>
                  <th>
                    <p>M</p>
                  </th>
                  <th>
                    <p>L</p>
                  </th>
                  <th>
                    <p>XL</p>
                  </th>
                  <th>
                    <p>XXL</p>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <p>Chest</p>
                  </td>
                  <td>
                    <p>36</p>
                  </td>
                  <td>
                    <p>38</p>
                  </td>
                  <td>
                    <p>40</p>
                  </td>
                  <td>
                    <p>42</p>
                  </td>
                  <td>
                    <p>44</p>
                  </td>
                  <td>
                    <p>47</p>
                  </td>
                </tr>
                <tr>
                  <td>
                    <p>Waist</p>
                  </td>
                  <td>
                    <p>31</p>
                  </td>
                  <td>
                    <p>33</p>
                  </td>
                  <td>
                    <p>35</p>
                  </td>
                  <td>
                    <p>37</p>
                  </td>
                  <td>
                    <p>39</p>
                  </td>
                  <td>
                    <p>40</p>
                  </td>
                </tr>
                <tr>
                  <td>
                    <p>Hips</p>
                  </td>
                  <td>
                    <p>37</p>
                  </td>
                  <td>
                    <p>39</p>
                  </td>
                  <td>
                    <p>42</p>
                  </td>
                  <td>
                    <p>44</p>
                  </td>
                  <td>
                    <p>46</p>
                  </td>
                  <td>
                    <p>49</p>
                  </td>
                </tr>
                <tr>
                  <td>
                    <p>Shoulder</p>
                  </td>
                  <td>
                    <p>15</p>
                  </td>
                  <td>
                    <p>15.5</p>
                  </td>
                  <td>
                    <p>16</p>
                  </td>
                  <td>
                    <p>16.5</p>
                  </td>
                  <td>
                    <p>17</p>
                  </td>
                  <td>
                    <p>18</p>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </section>
  </main>

  <script>
    function collectSelectedProducts() {
      var selected = [];
      document.querySelectorAll('.saree-img-group .card').forEach(function (card) {
        if (card.classList.contains('selected')) {
          selected.push(card.querySelector('div:nth-child(2)').textContent.trim());
        }
      });
      document.getElementById('selected_products').value = selected.join(',');
    }
  </script>

  <script src="../js/design.js"></script>
  <?php require_once('footer.php'); ?>
</body>

</html>
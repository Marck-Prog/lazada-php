<?php
session_start();
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
// Add security headers
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline'; img-src 'self' data:;");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lazada Clone</title>
    <link rel="stylesheet" href="css/styles.css" />
  </head>
  <body>
    <!-- Topbar Section -->
    <div class="topbar">
      <div class="topbar-container">
        <div class="topbar-links">
          <a href="#">FEEDBACK</a>
          <a href="#">SAVE MORE ON APP</a>
          <a href="#">SELL ON LAZADA</a>
          <a href="#">CUSTOMER CARE</a>
          <a href="#">TRACK MY ORDER</a>
          <?php if (isset($_SESSION["user_id"])): ?>
            <a href="admin/logout.php">LOGOUT</a>
          <?php else: ?>
            <a href="#" id="login-link">LOGIN</a>
            <a href="#" id="signup-link">SIGNUP</a>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Header Section -->
    <header>
      <div class="header-container">
        <div class="logo">
          <img src="images/logo.png" alt="Lazada Logo" />
        </div>
        <div class="search-bar">
          <input type="text" placeholder="Search in Lazada" />
          <img src="images/search.ico" alt="search icon" class="search-icon" />
        </div>
        <div class="header-icons">
          <img src="images/shopping.png" alt="Cart Icon" />
        </div>
        <div class="lazada-loans">
          <img src="images/lazada-loans.png" alt="Lazada Loans" />
        </div>
      </div>
    </header>

    <!-- Include Hero Section -->
    <?php include 'hero.php'; ?>

    <!-- Product List Section -->
    <main>
      <div class="main-container">
        <h1>Our Products</h1>
        <div id="product-list" class="product-grid"></div>
      </div>
    </main>

    <!-- Footer Section -->
    <footer>
      <div class="footer-container">
        <div class="footer-banners">
          <div class="banner balloon-blast">
            <img src="images/logo.png" alt="Balloon Blast" />
          </div>
          <div class="banner lazada-loans">
            <img src="images/logo.png" alt="Lazada Loans" />
          </div>
          <div class="banner lazada-wallet">
            <img src="images/logo.png" alt="Lazada Wallet" />
          </div>
        </div>
        <div class="footer-links">
          <div class="footer-column">
            <h3>Customer Care</h3>
            <a href="#">Help Center</a>
            <a href="#">How to Buy</a>
            <a href="#">Shipping & Delivery</a>
            <a href="#">International Product Policy</a>
            <a href="#">How to Return</a>
            <a href="#">Question?</a>
            <a href="#">Contact Us</a>
          </div>
          <div class="footer-column">
            <h3>Lazada</h3>
            <a href="#">About Lazada</a>
            <a href="#">Affiliate Program</a>
            <a href="#">Lazada Affiliate Academy</a>
            <a href="#">Careers</a>
            <a href="#">Terms & Conditions</a>
            <a href="#">Privacy Policy</a>
            <a href="#">Press & Media</a>
            <a href="#">Intellectual Property Protection</a>
          </div>
          <div class="footer-column app-download">
            <div class="app-header">
              <img src="images/mobile-logo.png" alt="Lazada App Icon" />
              <div class="app-text">
                <h3>Always Better</h3>
                <p>Download the App</p>
              </div>
            </div>
            <div class="app-links">
              <a href="#"><img src="images/appstore.png" alt="App Store" /></a>
              <a href="#"><img src="images/google-play.png" alt="Google Play" /></a>
              <a href="#"><img src="images/app-gallery.png" alt="App Gallery" /></a>
            </div>
          </div>
        </div>
      </div>
    </footer>

    <!-- Login Modal -->
    <div id="login-modal" class="modal">
      <div class="modal-content">
        <span class="close">×</span>
        <h2>Login</h2>
        <form id="login-form">
          <input type="email" name="email" placeholder="Email" required />
          <input type="password" name="password" placeholder="Password" required />
          <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>" />
          <button type="submit">Login</button>
        </form>
      </div>
    </div>

    <!-- Signup Modal -->
    <div id="signup-modal" class="modal">
      <div class="modal-content">
        <span class="close">×</span>
        <h2>Signup</h2>
        <form id="signup-form">
          <input type="text" name="username" placeholder="Username" required />
          <input type="email" name="email" placeholder="Email" required />
          <input type="password" name="password" placeholder="Password" required />
          <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>" />
          <button type="submit">Signup</button>
        </form>
      </div>
    </div>

    <script src="js/index.js"></script>
  </body>
</html>
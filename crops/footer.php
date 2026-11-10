<footer class="site-footer">
  <img class="footer-farmer-background" src="assets/img/farmers.png" alt="" aria-hidden="true">
  <div class="container footer-inner">
    <div class="row">
      <div class="col-md-5 mb-4 mb-md-0">
        <a href="index.php"><img class="footer-brand img-fluid" src="assets/img/footer-logo.png" alt="Crop Census"></a>
        <p>Practical, data-powered tools for more informed growing decisions.</p>
        <div class="footer-social-links" aria-label="Social and email sign-in links">
          <a href="https://accounts.google.com/" target="_blank" rel="noopener noreferrer" aria-label="Sign in to Google for Gmail" title="Gmail">
            <i class="fab fa-google" aria-hidden="true"></i>
          </a>
          <a href="https://x.com/i/flow/login" target="_blank" rel="noopener noreferrer" aria-label="Sign in to X" title="X">
            <i class="fab fa-twitter" aria-hidden="true"></i>
          </a>
          <a href="https://www.instagram.com/accounts/login/" target="_blank" rel="noopener noreferrer" aria-label="Sign in to Instagram" title="Instagram">
            <i class="fab fa-instagram" aria-hidden="true"></i>
          </a>
          <a href="https://www.facebook.com/login/" target="_blank" rel="noopener noreferrer" aria-label="Sign in to Facebook" title="Facebook">
            <i class="fab fa-facebook-f" aria-hidden="true"></i>
          </a>
          <a href="https://github.com/login" target="_blank" rel="noopener noreferrer" aria-label="Sign in to GitHub" title="GitHub">
            <i class="fab fa-github" aria-hidden="true"></i>
          </a>
        </div>
      </div>
      <div class="col-6 col-md-3 mb-4 mb-md-0">
        <h5>Explore</h5>
        <p class="mb-1"><a class="footer-link" href="crop_recommendation.php">Crop recommendation</a></p>
        <p class="mb-1"><a class="footer-link" href="fertilizer_recommendation.php">Fertilizer recommendation</a></p>
        <p class="mb-1"><a class="footer-link" href="yield_prediction.php">Yield prediction</a></p>
        <p class="mb-1"><a class="footer-link" href="rainfall_prediction.php">Rainfall prediction</a></p>
      </div>
      <div class="col-6 col-md-4">
        <h5>Get in touch</h5>
        <address class="mb-2">Vidyaranya Nagar, Tollgate<br>Bengaluru, Karnataka 560 023</address>
        <p class="mb-1"><a class="footer-link" href="tel:+918431344952">+91 84313 44952</a></p>
        <p><a class="footer-link" href="mailto:champgow213@gmail.com">champgow213@gmail.com</a></p>
      </div>
    </div>
    <div class="footer-bottom d-flex justify-content-between flex-wrap">
      <span>&copy; <?php echo date('Y'); ?> Crop Census. All rights reserved.</span>
      <a class="footer-link" href="#top">Back to top &uarr;</a>
    </div>
  </div>
</footer>

<div class="farm-chat" id="farm-chat"
  data-user-name="<?php echo isset($_SESSION['user_name']) ? e((string) $_SESSION['user_name']) : ''; ?>"
  data-authenticated="<?php echo isLoggedIn() ? 'true' : 'false'; ?>">
  <button class="farm-chat-launcher" id="farm-chat-launcher" type="button" aria-expanded="false" aria-controls="farm-chat-panel">
    <span class="farm-chat-launcher-icon" aria-hidden="true"><img src="assets/img/farm-chat-farmer.svg" alt=""></span>
    <span>Farm assistant</span>
  </button>
  <section class="farm-chat-panel" id="farm-chat-panel" role="dialog" aria-labelledby="farm-chat-title" aria-hidden="true">
    <header class="farm-chat-header">
      <div>
        <span class="farm-chat-status"><span></span> Crop Census assistant</span>
        <h2 id="farm-chat-title">How can I help your farm?</h2>
      </div>
      <button class="farm-chat-close" id="farm-chat-close" type="button" aria-label="Close assistant">&times;</button>
    </header>
    <div class="farm-chat-messages" id="farm-chat-messages" aria-live="polite" aria-relevant="additions"></div>
    <div class="farm-chat-controls" id="farm-chat-controls"></div>
  </section>
</div>

<script src="https://cdn.staticfile.org/jquery/3.6.3/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
<script src="https://cdn.staticfile.org/markdown-it/13.0.1/markdown-it.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
  integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
  integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://use.fontawesome.com/ee1c3da296.js"></script>
<script src="assets/js/farm-chatbot.js"></script>

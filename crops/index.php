<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<?php include 'header.php'; ?>
<body id="top">
<?php include 'nav.php'; ?>

<main>
  <section class="home-hero">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-7 home-hero-copy">
          <span class="home-eyebrow"><span class="home-dot"></span> Practical tools for better farming</span>
          <h1>Grow with<br><span>better insight.</span></h1>
          <p>Make confident decisions for your farm with data-powered crop, fertilizer, yield and rainfall tools.</p>
          <div class="home-hero-actions">
            <a class="btn home-primary-button" href="crop_recommendation.php">Explore recommendations <i class="fas fa-arrow-right"></i></a>
            <a class="home-text-link" href="#farm-tools">See all tools</a>
          </div>
          <div class="home-proof"><i class="fas fa-leaf"></i> Thoughtful insights for every growing season</div>
        </div>
        <div class="col-lg-5 home-hero-art">
          <div class="home-art-glow"></div>
          <img src="assets/img/farmers.png" alt="Illustration of a farmer tending plants" class="img-fluid">
          <div class="home-art-note"><span class="home-note-icon"><i class="fas fa-leaf"></i></span><span><strong>Smarter choices</strong><small>Rooted in your farm data</small></span></div>
        </div>
      </div>
    </div>
    <div class="home-hero-bottom"></div>
  </section>

  <section class="home-tools" id="farm-tools">
    <div class="container">
      <div class="home-section-heading">
        <span class="home-section-label">Your farm toolkit</span>
        <h2>Make your next decision a better one.</h2>
        <p>Choose a tool to get useful guidance from the information you already know about your land.</p>
      </div>
      <div class="row">
        <div class="col-md-6 col-lg-4">
          <a class="tool-card" href="crop_recommendation.php">
            <span class="tool-icon"><i class="fas fa-leaf"></i></span>
            <span class="tool-card-label">Recommendation</span>
            <strong>Find the right crop</strong>
            <span>Match soil nutrients and local conditions to a crop recommendation.</span>
            <span class="tool-card-link">Get started <i class="fas fa-arrow-right"></i></span>
          </a>
        </div>
        <div class="col-md-6 col-lg-4">
          <a class="tool-card" href="fertilizer_recommendation.php">
            <span class="tool-icon tool-icon-sun"><i class="fas fa-flask"></i></span>
            <span class="tool-card-label">Recommendation</span>
            <strong>Plan fertilizer use</strong>
            <span>Explore fertilizer guidance based on crop, soil and field conditions.</span>
            <span class="tool-card-link">Get started <i class="fas fa-arrow-right"></i></span>
          </a>
        </div>
        <div class="col-md-6 col-lg-4">
          <a class="tool-card" href="crop_prediction.php">
            <span class="tool-icon tool-icon-blue"><i class="fas fa-chart-line"></i></span>
            <span class="tool-card-label">Prediction</span>
            <strong>Explore crop patterns</strong>
            <span>Look up crops grown by location and season.</span>
            <span class="tool-card-link">Get started <i class="fas fa-arrow-right"></i></span>
          </a>
        </div>
        <div class="col-md-6 col-lg-4">
          <a class="tool-card" href="yield_prediction.php">
            <span class="tool-icon tool-icon-orange"><i class="fas fa-chart-bar"></i></span>
            <span class="tool-card-label">Prediction</span>
            <strong>Estimate crop yield</strong>
            <span>Get a yield estimate using your crop, area and growing season.</span>
            <span class="tool-card-link">Get started <i class="fas fa-arrow-right"></i></span>
          </a>
        </div>
        <div class="col-md-6 col-lg-4">
          <a class="tool-card" href="rainfall_prediction.php">
            <span class="tool-icon tool-icon-blue"><i class="fas fa-tint"></i></span>
            <span class="tool-card-label">Prediction</span>
            <strong>Check rainfall outlook</strong>
            <span>Review a regional rainfall estimate for your selected month.</span>
            <span class="tool-card-link">Get started <i class="fas fa-arrow-right"></i></span>
          </a>
        </div>
        <div class="col-md-6 col-lg-4">
          <div class="tool-card tool-card-note">
            <span class="tool-icon tool-icon-purple"><i class="fas fa-lightbulb"></i></span>
            <span class="tool-card-label">Made for the field</span>
            <strong>Useful, focused guidance</strong>
            <span>Simple tools designed to help turn farm details into a clearer next step.</span>
            <a class="tool-card-link" href="#about-tools">How it works <i class="fas fa-arrow-down"></i></a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="home-about" id="about-tools">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6">
          <span class="home-section-label">A little more clarity</span>
          <h2>Farm knowledge, supported by data.</h2>
          <p>Crop Census brings practical prediction and recommendation tools together in one place. Enter local details, explore an estimate, and use it as one more input in your planning.</p>
          <a class="home-about-link" href="#farm-tools">Find a tool for your farm <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="col-lg-6 home-about-image">
          <img src="assets/img/agri.png" alt="Agriculture data and technology illustration" class="img-fluid">
        </div>
      </div>
    </div>
  </section>
</main>

<?php require 'footer.php'; ?>
</body>
</html>

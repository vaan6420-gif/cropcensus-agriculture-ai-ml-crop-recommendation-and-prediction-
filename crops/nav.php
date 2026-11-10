<?php require_once 'config.php'; ?>
<nav id="navbar-main" class="navbar navbar-main navbar-expand-lg navbar-light position-sticky top-0">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">
      <img src="assets/img/navv.png" alt="Crop Census">
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar_global"
      aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbar_global">
      <ul class="navbar-nav ml-auto align-items-lg-center">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="predictionMenu" role="button"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Predictions</a>
          <div class="dropdown-menu" aria-labelledby="predictionMenu">
            <a class="dropdown-item" href="crop_prediction.php">Crop prediction</a>
            <a class="dropdown-item" href="yield_prediction.php">Yield prediction</a>
            <a class="dropdown-item" href="rainfall_prediction.php">Rainfall prediction</a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="recommendationMenu" role="button"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Recommendations</a>
          <div class="dropdown-menu" aria-labelledby="recommendationMenu">
            <a class="dropdown-item" href="crop_recommendation.php">Crop recommendation</a>
            <a class="dropdown-item" href="fertilizer_recommendation.php">Fertilizer recommendation</a>
          </div>
        </li>
        <?php if (isLoggedIn()): ?>
          <li class="nav-item"><span class="nav-link account-greeting">Hi, <?php echo e($_SESSION['user_name']); ?></span></li>
          <li class="nav-item"><a class="nav-link nav-account-link" href="logout.php">Sign out</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="login.php">Sign in</a></li>
          <li class="nav-item"><a class="nav-link nav-account-link" href="register.php">Create account</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

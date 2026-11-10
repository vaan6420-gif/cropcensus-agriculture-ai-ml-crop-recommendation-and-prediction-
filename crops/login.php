<?php
require_once 'config.php';

$redirect = safePostLoginDestination(
    (string) ($_POST['redirect'] ?? $_GET['redirect'] ?? 'index.php')
);

if (isLoggedIn()) {
    header('Location: ' . $redirect);
    exit;
}

$error = '';
$email = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(trim((string) ($_POST['email'] ?? '')));
    $password = (string) ($_POST['password'] ?? '');
    $statement = $pdo->prepare('SELECT id, name, password_hash FROM users WHERE email = ?');
    $statement->execute(array($email));
    $user = $statement->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = (int) $user['id'];
        $_SESSION['user_name'] = $user['name'];
        header('Location: ' . $redirect);
        exit;
    }
    $error = 'Incorrect email or password.';
}
$flash = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);
?>
<!DOCTYPE html>
<html>
<?php include 'header.php'; ?>
<body id="top">
<?php include 'nav.php'; ?>
<section class="auth-section">
  <div class="container">
    <div class="row auth-layout align-items-center">
      <div class="col-md-6 auth-art">
        <img src="assets/img/farmers.png" alt="">
        <span class="home-section-label">Better insight for every growing season</span>
        <h1>Good decisions<br>start in the field.</h1>
        <p>Sign in to explore practical, data-powered tools for your farm.</p>
      </div>
      <div class="col-md-6">
       <div class="auth-card">
        <div class="card-body p-5">
          <h2 class="text-center">Welcome back</h2>
          <p class="auth-intro text-center">Sign in to continue to Crop Census.</p>
          <?php if ($flash): ?><div class="alert alert-success"><?php echo e($flash); ?></div><?php endif; ?>
          <?php if ($error): ?><div class="alert alert-danger"><?php echo e($error); ?></div><?php endif; ?>
          <form method="post">
            <input type="hidden" name="redirect" value="<?php echo e($redirect); ?>">
            <div class="form-group"><label for="email">Email address</label><input id="email" type="email" name="email" class="form-control" value="<?php echo e($email); ?>" required></div>
            <div class="form-group"><label for="password">Password</label><input id="password" type="password" name="password" class="form-control" required></div>
            <button type="submit" class="btn auth-submit btn-block">Sign in</button>
          </form>
          <p class="text-center mt-3 mb-0">New user? <a href="register.php?redirect=<?php echo rawurlencode($redirect); ?>">Create an account</a></p>
        </div>
       </div>
      </div>
    </div>
  </div>
</section>
<?php require 'footer.php'; ?>
</body>
</html>

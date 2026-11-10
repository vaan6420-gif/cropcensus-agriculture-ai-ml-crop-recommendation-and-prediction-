<?php
require_once 'config.php';

$redirect = safePostLoginDestination(
    (string) ($_POST['redirect'] ?? $_GET['redirect'] ?? 'index.php')
);

$errors = array();
$name = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim((string) ($_POST['name'] ?? ''));
    $email = strtolower(trim((string) ($_POST['email'] ?? '')));
    $password = (string) ($_POST['password'] ?? '');
    $confirmPassword = (string) ($_POST['confirm_password'] ?? '');

    if ($name === '' || strlen($name) > 100) {
        $errors[] = 'Please enter your name (up to 100 characters).';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }
    if (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters long.';
    }
    if ($password !== $confirmPassword) {
        $errors[] = 'Passwords do not match.';
    }

    if (!$errors) {
        $statement = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $statement->execute(array($email));
        if ($statement->fetch()) {
            $errors[] = 'An account with that email already exists.';
        } else {
            $statement = $pdo->prepare(
                'INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)'
            );
            $statement->execute(array($name, $email, password_hash($password, PASSWORD_DEFAULT)));
            $_SESSION['flash'] = 'Registration successful. You can now sign in.';
            header('Location: login.php?redirect=' . rawurlencode($redirect));
            exit;
        }
    }
}
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
        <img src="assets/img/agri.png" alt="">
        <span class="home-section-label">A little more clarity</span>
        <h1>Grow with<br>better insight.</h1>
        <p>Create an account to access Crop Census recommendations and predictions.</p>
      </div>
      <div class="col-md-6">
       <div class="auth-card">
        <div class="card-body p-5">
          <h2 class="text-center">Create an account</h2>
          <p class="auth-intro text-center">Join Crop Census and explore practical tools for your farm.</p>
          <?php if ($errors): ?><div class="alert alert-danger"><?php echo e(implode(' ', $errors)); ?></div><?php endif; ?>
          <form method="post" novalidate>
            <input type="hidden" name="redirect" value="<?php echo e($redirect); ?>">
            <div class="form-group"><label for="name">Full name</label><input id="name" name="name" class="form-control" value="<?php echo e($name); ?>" required></div>
            <div class="form-group"><label for="email">Email address</label><input id="email" type="email" name="email" class="form-control" value="<?php echo e($email); ?>" required></div>
            <div class="form-group"><label for="password">Password</label><input id="password" type="password" name="password" class="form-control" minlength="8" required></div>
            <div class="form-group"><label for="confirm_password">Confirm password</label><input id="confirm_password" type="password" name="confirm_password" class="form-control" minlength="8" required></div>
            <button type="submit" class="btn auth-submit btn-block">Create account</button>
          </form>
          <p class="text-center mt-3 mb-0">Already registered? <a href="login.php?redirect=<?php echo rawurlencode($redirect); ?>">Sign in</a></p>
        </div>
       </div>
      </div>
    </div>
  </div>
</section>
<?php require 'footer.php'; ?>
</body>
</html>

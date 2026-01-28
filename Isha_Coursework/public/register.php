<?php
// public/register.php
require_once '../config/db.php';
require_once '../includes/functions.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrfToken($_POST['csrf_token']);
    
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    if (empty($username) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } else {
        // Check if user exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        
        if ($stmt->rowCount() > 0) {
            $error = "Username or email already exists.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
            if ($stmt->execute([$username, $email, $hashed_password])) {
                $success = "Registration successful! You can now login.";
            } else {
                $error = "Something went wrong.";
            }
        }
    }
}

require_once '../includes/header.php';
?>

<div class="auth-container fade-in">
    <h2 style="text-align: center; margin-bottom: 2rem;">Create Account</h2>
    
    <?php if($error): ?>
        <div class="alert" style="color: #fca5a5; background: rgba(239, 68, 68, 0.1); padding: 1rem; border-radius: 8px; margin-bottom: 1rem; border: 1px solid rgba(239, 68, 68, 0.2);">
            <i class="fa-solid fa-triangle-exclamation"></i> <?php echo h($error); ?>
        </div>
    <?php endif; ?>
    
    <?php if($success): ?>
        <div class="alert" style="color: #6ee7b7; background: rgba(16, 185, 129, 0.1); padding: 1rem; border-radius: 8px; margin-bottom: 1rem; border: 1px solid rgba(16, 185, 129, 0.2);">
            <i class="fa-regular fa-circle-check"></i> <?php echo h($success); ?> <a href="login.php" style="color: inherit; text-decoration: underline;">Login here</a>.
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
        
        <div class="form-group">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        
        <button type="submit" class="btn btn-primary" style="width: 100%;">
            <i class="fa-solid fa-user-plus"></i> Sign Up
        </button>
        
        <p style="text-align: center; margin-top: 1.5rem; color: var(--text-gray); font-size: 0.9rem;">
            Already have an account? <a href="login.php" style="color: var(--primary); text-decoration: none;">Login</a>
        </p>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>
